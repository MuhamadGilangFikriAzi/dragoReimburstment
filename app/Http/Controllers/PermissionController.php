<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::query()->get();
        $role = Role::query()->get();

        return view('permission.index', compact('permissions', 'role'));
    }
    public function create()
    {
        return view('permission.create');
    }

    public function store(Request $request)
    {
        $permission = Permission::create(['name' => $request->permission]);

        return redirect('/permission');
    }

    public function show(Permission $permission)
    {
        return view('permission.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        return view('permission.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $data = request()->validate(
            ['name' => 'required']
        );

        $permission = Permission::find($id);
        $permission->update($data);

        return redirect('/permission');
    }

    public function delete(Permission $permission)
    {
        $permission->delete();
        return redirect('/permission');
    }
}
