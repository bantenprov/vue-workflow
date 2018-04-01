<?php

namespace Bantenprov\VueWorkflow\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Emadadly\LaravelUuid\Uuids;

class WorkflowGuard extends Model
{
    use SoftDeletes;
    use Uuids;

    public $fillable = ['permission_id', 'workflow_id', 'transition_id', 'name', 'label'];
}
