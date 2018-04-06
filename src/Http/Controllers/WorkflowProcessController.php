<?php
// ganti name class dg WorkflowTransitionController
namespace Bantenprov\VueWorkflow\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\VueWorkflow\Facades\VueWorkflow;
use Bantenprov\VueWorkflow\Models\State;
use Bantenprov\VueWorkflow\Models\Workflow;
use Bantenprov\VueWorkflow\Models\WorkflowType;
use Bantenprov\VueWorkflow\Models\TransitionState;
use Bantenprov\VueWorkflow\Models\Transition;
use Bantenprov\VueWorkflow\Models\History;

use Bantenprov\VueWorkflow\Http\Traits\WorkflowTrait;

use App\Http\Controllers\Traits\WorkflowConditionTrait;

use Validator;

class WorkflowProcessController extends Controller
{
    use WorkflowTrait;
    use WorkflowConditionTrait;

    protected $wokflowModel;
    protected $stateModel;
    protected $historyModel;
    protected $transitionStateModel;
    protected $transitionModel;
    protected $workflowTypeModel;

    /**
     * WorkflowProcessController constructor.
     * @param State $state
     * @param Workflow $workflow
     * @param WorkflowType $workflowType
     * @param TransitionState $transitionState
     * @param Transition $transition
     * @param History $history
     */
    public function __construct(State $state, Workflow $workflow, WorkflowType $workflowType, TransitionState $transitionState, Transition $transition, History $history){        

        $this->wokflowModel = $workflow;
        $this->stateModel = $state;
        // $this->historyModel = config('vue-workflow.WORKFLOW_HISTORY');
        $this->historyModel = $history;
        $this->transitionStateModel = $transitionState;
        $this->transitionModel = $transition;
        $this->workflowTypeModel = $workflowType;

    }

    public function getLastHistory()
    {

    }

    /**
     * @param $content_type
     * @param $content_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function availableState($content_type,$content_id)
    {      
        // $call_func = "guard__".str_replace('-', '_', $func);
        // $checkCondition = $this->$call_func();
        // dd($func);
        //dd(call_user_func("test_call_func"));
        
        $workflow = WorkflowType::where('content_type', $content_type)->first();

        if(!$workflow){
            return response()->json([
                'status' => false
                ]);
        }

        $history = $this->historyModel->where('workflow_id',$workflow->workflow_id)->where('content_id',$content_id)->orderBy('created_at','desc')->first();

        if(!$history){
            return response()->json([
                'status' => false
                ]);
        }




        $check_history = $this->historyModel->where('workflow_id',$workflow->workflow_id)->where('content_id',$content_id)->count();


        $transition_state = TransitionState::where('history_id',$history->id)->orderBy('created_at','desc')->first();

        $transitions = Transition::where('from',$transition_state->current_state)->get();
        
        $states = State::where('workflow_id',$history->workflow_id)->get();

        $current_state = State::find($transition_state->current_state);

        $state_response = [];

        foreach($transitions as $transition)
        {
            
            foreach($states as $state)
            {
                if($state->id == $transition->to && $state->id != $transition_state->current_state){
                    if(!empty($transition->vueGuard->permission_id)){
                        $permission = \App\Permission::find($transition->vueGuard->permission_id);
                        if( (\Auth::user()->hasPermission($permission->name)) ){
                            // if($checkCondition){
                                array_push($state_response,$state);
                            // }else{
                                // array_set($state,'permission',0);
                            // }                          
                        }
                        array_set($state,'permission',$transition->vueGuard->permission_id);
                        
                    }else{
                        array_set($state,'permission',0);
                    }                    
                }
            }
        }
        if($check_history == 1){
            return response()->json([
                'status' => true,
                'state' => $state_response,
                'transition_state' => $transition_state,
                'current_state' => $current_state,
                'current_history' => $history,
                'user' => '-'
                ]);
        }elseif($check_history > 1){
            return response()->json([
                'status' => true,
                'state' => $state_response,
                'transition_state' => $transition_state,
                'current_state' => $current_state,
                'current_history' => $history,
                'user' => (empty($history->user)) ? '-' : $history->user->name
                ]);
        }
        return response()->json([
            'status' => false,
            ]);

    }

    /**
     * @param Request $req
     * @param $content_type
     * @param $content_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllHistoryThisContent(Request $req, $content_type, $content_id){

        $response = array();

        $param = explode('|',$req->get('sort'));

        $workflow = WorkflowType::where('content_type', $content_type)->first();

        $histories = $this->historyModel->where('workflow_id',$workflow->workflow_id)->where('content_id',$content_id)->orderBy('created_at','desc')->paginate(10);

        if($req->get('filter') != ''){
            $search = "%{$req->get('filter')}%";

            $response = $this->historyModel
            ->where('workflow_id',$workflow->workflow_id)
            ->where('content_id',$content_id)
            ->with('fromState')
            ->with('toState')
            ->with('user')
            ->where('content_type','like',$search)
            ->orderBy($param[0], $param[1])
            ->paginate(10);
        }else{
            if($req->get('sort') == ''){
                $response = $this->historyModel
                ->where('workflow_id',$workflow->workflow_id)
                ->where('content_id',$content_id)
                ->with('fromState')
                ->with('toState')
                ->with('user')
                ->paginate(10);
            }else{
                $response = $this->historyModel
                ->where('workflow_id',$workflow->workflow_id)
                ->where('content_id',$content_id)
                ->with('fromState')
                ->with('toState')
                ->with('user')
                ->orderBy($param[0], $param[1])
                ->paginate(10);
            }
        }

        foreach($response as $data){
            if(empty($data->message)){
                $data->message = "Start";
            }
        }

        return response()->json($response);

    }

    /**
     * @param Request $request
     * @param $content_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeState(Request $request, $content_id)
    {
        $from   = $this->stateModel->find($request->from_state)->name;
        $to     = $this->stateModel->find($request->to_state)->name;
        $func = $from.'-to-'.$to;

        $call_func = "guard__".str_replace('-', '_', $func);
        $checkCondition = $this->$call_func($content_id);

        //return response()->json($checkCondition);

        if(!$checkCondition){
            $response['message'] = 'tidak mempunyai akses untuk ini.';
            return response()->json($response);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if($validator->fails()){
            $response['status'] = false;
            $response['message'] = 'reason is required';
        }else{
            $this->storeHistory(
                $request->content_type,
                $content_id,
                $request->workflow_id,
                $request->workflow_transition_id,
                $request->from_state,
                $request->to_state,
                \Auth::user()->id,
                $request->message
            );
            $response['status'] = true;
            $response['message'] = 'success';
        }        

        return response()->json($response);
    }   
    

}
