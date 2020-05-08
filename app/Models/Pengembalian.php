<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';
    protected $guarded = [];

    public function user()
    {
        return $this->HasOne('App\User', 'id', 'id_user');
    }

    public function detail()
    {
        return $this->hasMany('App\Models\PengembalianDetail', 'id_pengembalian');
    }
}
