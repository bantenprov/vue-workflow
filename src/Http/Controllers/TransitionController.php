<?php

namespace Bantenprov\VueWorkflow\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\VueWorkflow\Models\Transition;
use Bantenprov\VueWorkflow\Models\Workflow;
use Bantenprov\VueWorkflow\Models\State;
use Validator;

class TransitionController extends Controller
{

    protected $transitionModel;
    protected $workflowModel;
    protected $stateModel;

    /**
     * [Function] __construct
     * @param
     * 
     * @return 
     */
    public function __construct(Transition $transition, Workflow $workflow, State $state)
    {
        $this->transitionModel = $transition;
        $this->workflowModel = $workflow;
        $this->stateModel = $state;
    }

    /**
     * [Function] index
     * @param Request $req
     * 
     * @return json
     */
    public function index(Request $request)
    {
        // $response;

        //     $param = explode('|',$req->get('sort'));

        //     if($req->get('filter') != ''){
        //         $search = "%{$req->get('filter')}%";
        //         $response = $this->transitionModel->where('name','like',$search)->orderBy($param[0], $param[1])->paginate(10);
        //     }else{
        //         if($req->get('sort') == ''){
        //             $response = $this->transitionModel->paginate(10);
        //         }else{
        //             $response = $this->transitionModel->orderBy($param[0], $param[1])->paginate(10);     
        //         }                
        //     }

        //     foreach($response as $kegiatan){            
        //         array_set($response->data, 'workflow_id', $kegiatan->kegiatan->label);           
        //     }

            // ===================================================

        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);

            $query = $this->transitionModel->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->transitionModel->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('label', 'like', $value)
                    ->orWhere('description', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->paginate($perPage);
        
        foreach($response as $workflow){            
            array_set($response->data, 'workflow_id', $workflow->getWorkflow->label);           
        }

        

        return response()->json($response);
    }

    /**
     * [Function] create
     * @param 
     * 
     * @return json
     */
    public function create()
    {        
        $response = $this->workflowModel->all();          

        return response()->json($response);
    }

    /**
     * [Function] getWorkflowState
     * @param 
     * 
     * @return json
     */
    public function getWorkflowState($id)
    {
        if($id == 'undefined'){
            $response = [];  
        }else{
            $response = $this->stateModel->where('workflow_id',$id)->get();  
        }            

        return response()->json($response);
    }

    /**
     * [Function] store
     * @param Request $req
     * 
     * @return json
     */
    public function store(Request $req)
    {
        $request['label']           = $req->label;
        $request['name']            = strtolower($req->name);
        $request['workflow_id']     = $req->workflow_id; 
        $request['from']            = $req->from; 
        $request['to']              = $req->to;
        $request['message']         = $req->message;

        // $check = $this->transitionModel->where('name',$req->name)->whereNull('deleted_at')->count();

        $validator = Validator::make($req->all(),[
            'name'          => 'required',
            'label'         => 'required',            
            'message'       => 'required',
            'from'          => 'required',
            'to'            => 'required',
            'workflow_id'   => 'required',
        ]);

        if($validator->fails()){
            //if($check > 0){
                $response['message']    = 'failed transition allready exist !';
                $response['status']     = false;
            // }else{
            //     $response['message']    = 'success add new transition';
            //     $response['status']     = true;
            //     $this->transitionModel->create($request);
            // }                
        }else{
            $response['message']    = 'success add new transition';
            $response['status']     = true;
            $this->transitionModel->create($request);
        }

        return response()->json($response);
    }

    /**
     * [Function] edit
     * @param $id
     * 
     * @return json
     */
    public function edit($id)
    {
        $response = $this->transitionModel
                        ->with('stateTo')
                        ->with('stateFrom')
                        ->with('getWorkflow')
                        ->findOrFail($id);
        $response['status'] = true;
        return response()->json($response);
    }
    
    /**
     * [Function] update
     * @param Request $req
     * @param $id
     * 
     * @return json
     */
    public function update(Request $req,$id)
    {
        $request['label']           = $req->label;
        $request['name']            = strtolower($req->name);
        $request['workflow_id']     = $req->workflow_id; 
        $request['from']            = $req->from; 
        $request['to']              = $req->to;
        $request['message']         = $req->message;          
        
        $check = $this->transitionModel->where('name',$req->name)->whereNull('deleted_at')->count();

        if($req->old_name == $req->name){
            $validator = Validator::make($req->all(),[
                'label'         => 'required',
                'name'          => 'required',
                'message'       => 'required',
                'from'          => 'required',
                'to'            => 'required',
                'workflow_id'   => 'required',
            ]);
        }else{
            $validator = Validator::make($req->all(),[
                'label'         => 'required',
                'name'          => 'required|unique:workflow_transition,name',
                'message'       => 'required',
                'from'          => 'required',
                'to'            => 'required',
                'workflow_id'   => 'required',
            ]);
        }
        

        if($validator->fails()){
            if($check > 0){
                $response['message']    = 'failed state allready exist !';
                $response['status']     = false;
            }else{
                $response['message']    = 'success add new state';
                $response['status']     = true;
                $this->transitionModel->findOrFail($id)->update($request);
            }                
        }else{
            $response['message']    = 'success add new state';
            $response['status']     = true;
            $this->transitionModel->findOrFail($id)->update($request);
        }

        

        return response()->json($response);
    }
    
    /**
     * [Function] destroy
     * @param Request $req
     * 
     * @return json
     */
    public function destroy($id)
    {
        $state = $this->transitionModel->findOrFail($id)->delete();

        return response()->json(['status' => true]);
    }
}
