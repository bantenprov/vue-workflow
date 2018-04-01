<?php

namespace Bantenprov\VueWorkflow\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Emadadly\LaravelUuid\Uuids;

class State extends Model
{
    use SoftDeletes;
    use Uuids;

    public $table = 'workflow_state';

    public $fillable = ['workflow_id','name', 'label', 'description', 'status'];

    public function workflow()
    {
        return $this->belongsTo('Bantenprov\VueWorkflow\Models\Workflow','workflow_id');
    }        
}
