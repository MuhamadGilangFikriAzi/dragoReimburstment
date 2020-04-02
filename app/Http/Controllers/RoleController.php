<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::query()->get();
        $permission = Permission::query()->get();
        return view('role.index',compact('role','permission'));
    }

    public function create()
    {
       return view('role.create');
    }

    public function store(Request $request)
    {
    	$role = Role::create(['name' => $request->name]);
    	return redirect('/role');
    }

    public function show(Role $role)
    {	
    	return view('role.show',compact('role'));
    }

    public function edit(Role $role)
    {
        $permission = Permission::all();
    	return view('role.edit',compact('permission','role'));
    }

    public function update(Request $request, $id)
    {
    	$data = request()->validate(
    		['name' => 'required' ,]);

    	$role = Role::find($id);

    	$role->update($data);
    	return redirect('/role');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect('/role');
    }

    public function createRoleHasPermission()
    {
        $role = Role::query()->get();
        $permission = Permission::query()->get();

        return view('role.createRoleHasPermission',compact('role','permission'));
    }

    public function storeRoleHasPermission(Request $request)
    {
        $role = Role::findOrFail($request->role);
        $permission = Permission::findOrFail($request->permission);

        $role->givePermissionTo($permission);

        return redirect('/role');
    }
}
