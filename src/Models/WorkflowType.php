<?php

namespace Bantenprov\VueWorkflow\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Emadadly\LaravelUuid\Uuids;

class WorkflowType extends Model
{
    use SoftDeletes;
    use Uuids;
    
    public $fillable = ['workflow_id', 'workflow_type', 'content_type'];

    public function getWorkflow()
    {
        return $this->hasOne('Bantenprov\VueWorkflow\Models\Workflow','workflow_id');
    }
}
