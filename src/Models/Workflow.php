<?php

namespace Bantenprov\VueWorkflow\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Emadadly\LaravelUuid\Uuids;

class Workflow extends Model
{
    use SoftDeletes;
    use Uuids;
    
    public $fillable = ['content_id','content_type','name','label'];    

    public function getWorkflowType()
    {
        return $this->hasOne('Bantenprov\VueWorkflow\Models\WorkflowType','workflow_id');
    }
}