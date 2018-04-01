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
    protected $signature = 'bantenprov:vue-workflow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Demo command for Bantenprov\VueWorkflow package';

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
        //$file = File::get(base_path().'/composer.json');
        //$this->info(config('app'));
        print_r(config('app')['providers']);
        print_r(            
            (in_array('Bantenprov\ProdukHukum\ProdukHukumServiceProvider',config('app')['providers'])) ? 'true' : 'false'
        );
        //$this->info(get_class());
        //$this->info('Welcome to command for Bantenprov\VueWorkflow package');
    }
}
