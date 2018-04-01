<?php

namespace Bantenprov\VueWorkflow\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Emadadly\LaravelUuid\Uuids;

class Transition extends Model
{
    use SoftDeletes;
    use Uuids;
    
    public $table = 'workflow_transition';

    public $fillable = ['workflow_id','name','label','message','from','to'];

    public function getWorkflow(){
        return $this->belongsTo('Bantenprov\VueWorkflow\Models\Workflow','workflow_id');
    }

    public function state()
    {
        return $this->belongsTo('Bantenprov\VueWorkflow\Models\State','to','id');
    }

    public function stateFrom()
    {
        return $this->belongsTo('Bantenprov\VueWorkflow\Models\State','from','id');
    }

    public function stateTo()
    {
        return $this->belongsTo('Bantenprov\VueWorkflow\Models\State','to','id');
    }

    public function vueGuard()
    {
        return $this->hasOne('Bantenprov\VueGuard\Models\VueGuardModel','transition_id');
    }
}
