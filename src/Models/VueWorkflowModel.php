<?php namespace Bantenprov\VueWorkflow\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The VueWorkflowModel class.
 *
 * @package Bantenprov\VueWorkflow
 * @author  bantenprov <developer.bantenprov@gmai.com>
 */
class VueWorkflowModel extends Model
{
    /**
    * Table name.
    *
    * @var string
    */
    protected $table = 'vue_workflow';

    /**
    * The attributes that are mass assignable.
    *
    * @var mixed
    */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
