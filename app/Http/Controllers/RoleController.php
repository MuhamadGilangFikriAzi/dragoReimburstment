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
        // dd($role->first()->permissions);
        $permission = Permission::query()->get();
        return view('role.index', compact('role', 'permission'));
    }

    public function create()
    {
        return view('role.create');
    }

    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        return redirect('/role')->with(['success' => 'Data has been saved']);;
    }

    public function show(Role $role)
    {
        // dd($role->permissions);
        $permission = Permission::all()->pluck('name', 'id');
        return view('role.show', compact('role', 'permission'));
    }

    public function edit(Role $role)
    {
        $permission = Permission::all();
        return view('role.edit', compact('permission', 'role'));
    }

    public function update(Request $request, $id)
    {
        $data = request()->validate(
            ['name' => 'required',]
        );

        $role = Role::find($id);

        $role->update($data);
        return redirect(route('role'));
    }

    public function delete(Role $role)
    {
        $role->delete();
        return redirect()->back()->with(['danger' => 'Data has been deleted']);
    }

    public function hasPermission(Request $request)
    {
        $role = Role::find($request->id);
        $permission = $request->permission;
        if ($request->checked == "true") {
            $role->givePermissionTo($permission);
        } else {
            $role->revokePermissionTo($permission);
        }
        return with(['success' => 'Data Berhasil Disimpan']);
    }

    public function hasPermissionstore(Request $request)
    {
        $role = Role::findOrFail($request->role);
        $permission = Permission::findOrFail($request->permission);

        $role->givePermissionTo($permission);

        return redirect('/role');
    }
}
