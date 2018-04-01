<?php

namespace Bantenprov\VueWorkflow\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Emadadly\LaravelUuid\Uuids;

class History extends Model
{
    use SoftDeletes;
    use Uuids;
    

    public $fillable = ['content_type','content_id','workflow_id','workflow_transition_id','from_state','to_state','user_id','message'];

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function workflow()
    {
        return $this->hasOne('Bantenprov\VueWorkflow\Models\Workflow','id','workflow_id');
    }

    public function fromState()
    {
        return $this->hasOne('Bantenprov\VueWorkflow\Models\State','id','from_state');
    }

    public function toState()
    {
        return $this->hasOne('Bantenprov\VueWorkflow\Models\State','id','to_state');
    }
}

