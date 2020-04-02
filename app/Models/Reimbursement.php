<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reimbursement extends Model
{
    
	protected $table = "reimburse";
	public $timestamps = false;
	protected $guarded = [];

	public function user()
	{
		return $this->belongsTo('App\Models\UserModel','user_id','id');
	}
}
