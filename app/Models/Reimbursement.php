<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reimbursement extends Model
{

    protected $table = "reimburstment";
    public $timestamps = false;
    protected $guarded = [];

    public function user()
    {
        return $this->HasOne('App\User', 'id', 'id_user');
    }

    public function detail()
    {
        return $this->hasMany('App\Models\ReimburstmentDetail', 'id_reimburstment');
    }
}
