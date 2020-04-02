<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MReport extends Model
{
    use SoftDeletes;
    
    protected $table 	= 'meeting_report';
    protected $guarded 	= [];

    public function schedule()
    {
    	return $this->belongsTo('App\Models\Schedule','schedule_id','id');
    }
}
