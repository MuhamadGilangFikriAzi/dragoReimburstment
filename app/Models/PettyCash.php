<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    protected $table = 'petty_cash';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'id_user');
    }
}
