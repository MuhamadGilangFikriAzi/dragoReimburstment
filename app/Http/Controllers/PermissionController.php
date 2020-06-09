<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    protected $index = 'permission.index';
    protected $store = 'permission.store';
    protected $delete = 'permission.delete';

    public function index()
    {
        $data['permissions'] = Permission::query()->get();
        $data['role'] = Role::query()->get();
        $data['urlDelete'] = $this->delete;
        $data['urlStore'] = $this->store;

        return view('permission.index', $data);
    }

    public function store(Request $request)
    {
        $permission = Permission::create(['name' => $request->permission]);

        return redirect()->route($this->index)->with(['success' => 'Permission ' . $request->permission . ' berhasil ditambahkan']);
    }

    public function delete(Permission $permission)
    {
        $nama = $permission->name;
        $permission->delete();
        return redirect()->route($this->index)->with(['danger' => 'Permission ' . $nama . ' telah dihapus']);
    }
}
