<?php namespace Bantenprov\VueWorkflow\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\VueWorkflow\Facades\VueWorkflow;
use Bantenprov\VueWorkflow\Models\Workflow;
use Bantenprov\VueWorkflow\Models\WorkflowType;
use Bantenprov\VueWorkflow\Models\Transition;

use Validator;

use Bantenprov\VueWorkflow\Http\Traits\WorkflowTrait;

/**
 * The VueWorkflowController class.
 *
 * @package Bantenprov\VueWorkflow
 * @author  bantenprov <developer.bantenprov@gmai.com>
 */
class WorkflowController extends Controller
{

    use WorkflowTrait;
    
    protected $workflowModel;
    protected $workflowTypeModel;

    /**
     * WorkflowController constructor.
     * @param Request $request
     * @param Workflow $workflow
     * @param WorkflowType $workflowType
     */
    public function __construct(Request $request, Workflow $workflow, WorkflowType $workflowType){
        $this->workflowModel        = $workflow;
        $this->workflowTypeModel    = $workflowType; 

        //dd($request->path());
    }

    /**
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $req)
    {     
             
        // $transition = Transition::where('name','propose-to-propose')->where('workflow_id','19')->first();
        // dd($transition->id);
        //dd($this->getRequest($req->input('sort')));  
        
        //dd(class_basename($this->workflowTypeModel));
        //dd(class_basename(get_class($this)));
        //dd(get_declared_classes());
        // foreach (get_declared_classes() as $value) {
        //     //Illuminate\Database\Eloquent\Model
        //     if(get_parent_class($value) == "Illuminate\Database\Eloquent\Model"){
        //         echo $value."<br>";
        //     }
        //     //echo $value."<br>";
            
        // }
        // dd();
        $response = array();

        $param = explode('|',$req->get('sort'));

        if($req->get('filter') != ''){
            $search = "%{$req->get('filter')}%";
            $response = $this->workflowModel->where('name','like',$search)->orderBy($param[0], $param[1])->paginate(10);
        }else{
            if($req->get('sort') == ''){
                $response = $this->workflowModel->paginate(10);
            }else{
                $response = $this->workflowModel->orderBy($param[0], $param[1])->paginate(10);     
            }                
        }

        return response()->json($response);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {        
        $content_type = config('vue-workflow.content_type');
        
        return response()->json($content_type);
    }

    /**
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $req)
    {

        // $request['content_id']      = 1;
        // $request['content_type']    = $req->content_type;
        $request['label']           = $req->label;
        $request['name']            = $req->name;

        $validator = Validator::make($req->all(),[
            'label'             => 'required',
            'name'              => 'required'
        ]);

        if($validator->fails()){
            $response['message']    = 'failed transition allready exist !';
            $response['status']     = false;               
        }else{
            $response['message']    = 'success add new transition';
            $response['status']     = true;                
        }

        //$this->insertWithWorkflow($this->workflowModel, $request);
        $this->workflowModel->create($request);
        return response()->json($response);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $check = $this->workflowTypeModel->where('workflow_id',$id)->count();
        
        if($check > 0){
            $response = $this->workflowModel->findOrFail($id);
            $response['workflow_type'] = ['label' =>$this->workflowModel->findOrFail($id)->getWorkflowType->workflow_type];
            $response['content_type'] = ['label' => $this->workflowModel->findOrFail($id)->getWorkflowType->content_type];
            $response['status'] = true;
        }else{
            $response = $this->workflowModel->findOrFail($id);
            $response['workflow_type'] = '-';
            $response['content_type'] = '-';
            $response['status'] = true;
        }
        
        return response()->json($response);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {        
                
        $response['status']     = true;
        $response['workflow']   = $this->workflowModel->findOrFail($id);
        
        return response()->json($response);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {      
        
        $validator = Validator::make($request->all(), [
            'label' => 'required',
            'name'  => 'required'
        ]);

        if($validator->fails()){

            $response['status']     = false;
            $response['message']    = 'failed update ';

        }else{

            $response['status']     = true;
            $response['message']    = 'update success';
            $this->workflowModel->findOrFail($id)->update($request->all());

        }
                
        
        
        return response()->json($response);
    }


    /**
     * @param Request $req
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeWorkflow(Request $req, $id)
    {
        $workflow['workflow_id']    = $id;
        $workflow['workflow_type']  = $req->workflow_type;
        $workflow['content_type']   = $req->content_type;

        $this->workflowTypeModel->create($workflow);

        return response()->json(['status' => true, 'message' => 'Success register workflow']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $state = $this->workflowModel->findOrFail($id)->delete();

        return response()->json(['status' => true]);
    }
}
