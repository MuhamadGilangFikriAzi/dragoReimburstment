<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    protected $table = 'reimburse';

    public function user()
    {
    	return $this->belongsTo('App\Models\UserModel','user_id','id');
    }
}
