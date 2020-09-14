<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    
	protected $table = 'schedule';
    protected $guarded = [];
    public $timestamps = false;
    protected $dates = ['deleted_at'];

    public function meeting_report()
    {
    	return $this->hasOne('App\meeting_report','id');
    }
}
