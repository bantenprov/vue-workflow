<?php

    namespace Bantenprov\VueWorkflow\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Bantenprov\VueWorkflow\Facades\VueWorkflow;
    use Bantenprov\VueWorkflow\Models\State;
    use Bantenprov\VueWorkflow\Models\Workflow;

    use Validator;

    /**
     * [Class] StateController
     */
    class StateController extends Controller{

        protected $stateModel;
        protected $workflowModel;

        /**
         * [Function] __construct
         */
        public function __construct(State $state, Workflow $workflow)
        {
            $this->stateModel = $state;
            $this->workflowModel = $workflow;
        }


        /**
         * [Function] index
         * @param Request $req
         *
         * @return json
         */
        public function index(Request $request)
        {
            //dd(response()->json(['message' => 'success', 'status' => true]));
            // $response;

            // $param = explode('|',$req->get('sort'));

            // if($req->get('filter') != ''){
            //     $search = "%{$req->get('filter')}%";
            //     $response = $this->stateModel->where('name','like',$search)->orderBy($param[0], $param[1])->paginate(10);
            // }else{
            //     if($req->get('sort') == ''){
            //         $response = $this->stateModel->paginate(10);
            //     }else{
            //         $response = $this->stateModel->orderBy($param[0], $param[1])->paginate(10);
            //     }
            // }

            if (request()->has('sort')) {
                list($sortCol, $sortDir) = explode('|', request()->sort);

                $query = $this->stateModel->orderBy($sortCol, $sortDir);
            } else {
                $query = $this->stateModel->orderBy('id', 'asc');
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
                array_set($response->data, 'workflow_id', $workflow->workflow->label);
            }



            return response()->json($response);

        }

        /**
         * [Function] create
         * @param
         *
         * @return json
         */
        public function create(){

            $workflows = $this->stateModel->all();
            //dd($workflows);
            // $response = [];
            // foreach($workflows as $workflow){
            //     $response[] = [
            //         'id' => $workflow->workflow->id,
            //         'label' => $workflow->workflow->label
            //     ];

            // }
            $workflows =  $this->workflowModel->all();

            $response = $workflows;
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
            $request['name']            = $req->name;
            $request['description']     = $req->description;
            $request['workflow_id']     = $req->workflow_id;
            $request['status']          = 1;

            $check = $this->stateModel->where('name',$req->name)->whereNull('deleted_at')->count();

            $validator = Validator::make($req->all(),[
                'label'         => 'required',
                'name'          => 'required',
                'description'   => 'required',
                'workflow_id'   => 'required'
            ]);

            if($validator->fails()){
                if($check > 0){
                    $response['message']    = 'failed state allready exist !';
                    $response['status']     = false;
                }else{
                    $response['message']    = 'success add new state';
                    $response['status']     = true;
                    $this->stateModel->create($request);
                }
            }else{
                $response['message']    = 'success add new state';
                $response['status']     = true;
                $this->stateModel->create($request);
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
            $response = $this->stateModel->findOrFail($id);
            $response['workflow'] = $response->workflow;
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
            $request['name']            = $req->name;
            $request['description']     = $req->description;
            $request['status']          = 1;

            $check = $this->stateModel->where('name',$req->name)->whereNull('deleted_at')->count();

            if($req->old_name == $req->name){
                $validator = Validator::make($req->all(),[
                    'label'         => 'required',
                    'name'          => 'required',
                    'description'   => 'required',
                ]);
            }else{
                $validator = Validator::make($req->all(),[
                    'label'         => 'required',
                    'name'          => 'required|unique:workflow_state,name',
                    'description'   => 'required',
                ]);
            }


            if($validator->fails()){
                if($check > 0){
                    $response['message']    = 'failed state allready exist !';
                    $response['status']     = false;
                }else{
                    $response['message']    = 'success add new state';
                    $response['status']     = true;
                    $this->stateModel->findOrFail($id)->update($request);
                }
            }else{
                $response['message']    = 'success add new state';
                $response['status']     = true;
                $this->stateModel->findOrFail($id)->update($request);
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
            $state = $this->stateModel->findOrFail($id)->delete();

            return response()->json(['status' => true]);
        }

    }
