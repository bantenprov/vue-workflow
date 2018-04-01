<?php namespace Bantenprov\VueWorkflow\Console\Commands;

use Illuminate\Console\Command;
use File;
/**
 * The VueWorkflowCommand class.
 *
 * @package Bantenprov\VueWorkflow
 * @author  bantenprov <developer.bantenprov@gmai.com>
 */
class VueWorkflowCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vue-workflow:publish-trait';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Trait for Bantenprov\VueWorkflow package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {        
        if(!File::exists(base_path().'/app/Http/Controllers/Traits')){
            File::makeDirectory(base_path().'/app/Http/Controllers/Traits');
            if(!File::exists(base_path().'/app/Http/Controllers/Traits/WorkflowConditionTrait.php')){
                File::put(base_path().'/app/Http/Controllers/Traits/WorkflowConditionTrait.php',File::get(__DIR__.'/../../stubs/WorkflowConditionTrait.stub'));
            }else{
                $this->error('File WorkflowConditionTrait.php already exist');
            }
        }else{
            if(!File::exists(base_path().'/app/Http/Controllers/Traits/WorkflowConditionTrait.php')){
                File::put(base_path().'/app/Http/Controllers/Traits/WorkflowConditionTrait.php',File::get(__DIR__.'/../../stubs/WorkflowConditionTrait.stub'));
            }else{
                $this->error('File WorkflowConditionTrait.php already exist');
            }
        }
    }
}
