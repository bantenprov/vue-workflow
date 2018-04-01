<?php namespace Bantenprov\VueWorkflow\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The VueWorkflow facade.
 *
 * @package Bantenprov\VueWorkflow
 * @author  bantenprov <developer.bantenprov@gmai.com>
 */
class VueWorkflow extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'vue-workflow';
    }
}
