<?php namespace Bantenprov\VueWorkflow\Http\Middleware;

use Closure;

/**
 * The VueWorkflowMiddleware class.
 *
 * @package Bantenprov\VueWorkflow
 * @author  bantenprov <developer.bantenprov@gmai.com>
 */
class VueWorkflowMiddleware
{


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {    

        //$return = response()->json(['guest' => true]);

        if(!\Auth::guest()){
            $return = response('',403);    
            
        }else{            
            $return = $next($request);
            
        }

        return $return;
    }
}
