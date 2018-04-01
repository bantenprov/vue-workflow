<?php

    namespace Bantenprov\VueWorkflow\Http\Traits;
    use Bantenprov\VueWorkflow\Models\WorkflowType;
    use Bantenprov\VueWorkflow\Models\History;
    use Bantenprov\VueWorkflow\Models\TransitionState;
    use Bantenprov\VueWorkflow\Models\Transition;
    

    /**
     * Workflow trait
     */
    trait WorkflowTrait
    {        

        public function insertWithWorkflow($class, $datas)
        {
            // if(in_array('label|asc',$request)){
            //     return 'work!!';                
            // }
            //dd($request);
            //$class->create($datas);
            $workflow = WorkflowType::where('content_type', class_basename($class));
            
            if($workflow->count() > 0){
                $get = $class->create($datas);
                //$class->find($get->id)->delete();
                
                $transition = Transition::where('name','propose-to-propose')->where('workflow_id',$workflow->first()->workflow_id)->first();
                
                $this->storeHistory(
                    class_basename($class),
                    $get->id,
                    $workflow->first()->workflow_id,
                    $transition->id,
                    $transition->from,
                    $transition->to,
                    \Auth::user()->id
                );     
            }else{
                $class->create($datas);
            }
            
        }

        public function storeHistory($content_type, $content_id, $workflow_id, $workflow_transition_id, $from_state, $to_state, $user_id, $message = '')
        {
            $save['content_type']           = $content_type;
            $save['content_id']             = $content_id;
            $save['workflow_id']            = $workflow_id;
            $save['workflow_transition_id'] = $workflow_transition_id;
            $save['from_state']             = $from_state;
            $save['to_state']               = $to_state;
            $save['user_id']                = $user_id;
            $save['message']                = $message;

            $history = History::create($save);

            $this->storeTransitionState($history->to_state ,$history->content_id, $history->id);
        }

        public function storeTransitionState($current_state, $content_id, $history_id)
        {
            $save['current_state'] = $current_state;
            $save['content_id'] = $content_id;
            $save['history_id'] = $history_id;

            TransitionState::create($save);
        }

        public function updateWithWorkflow($class, $content_id, $request)
        {
            $check = History::where('content_id', $content_id);

            $response = [];

            if($check->count() > 1){
                $response['message'] = "Cant update, current state must be propose !";
            }else{
                $class->update($request);
                $response['message'] = "Update success";
            }

            return $response;
        }

        // public function workflowExecute($op, $datas)
        // {

        // }


    }
    