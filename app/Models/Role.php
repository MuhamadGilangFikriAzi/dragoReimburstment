<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = [
    	'name', 'guard_name', 'email', 'password', 'role_id'
    ];

    public function permission()
    {
    	return $this->belongsToMany(Permission::class);
    }
}
