<?php

namespace Bantenprov\VueWorkflow\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Emadadly\LaravelUuid\Uuids;

class TransitionState extends Model
{
    use SoftDeletes;
    use Uuids;
    
    public $fillable = ['content_id','current_state','history_id'];

}