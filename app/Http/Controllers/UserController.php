<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Image;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class userController extends Controller
{
    public function index()
    {
        $list = User::query();
        $data = User::count();
        $pageTitle = 'User Index';

        $list = User::paginate('5');

        return view('user.index', compact('list', 'data', 'pageTitle'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $message = [
            'name.required' => '*Name Must Be Filled',
            'email.required' => '*email Must Must Be Filled',
            'password.required' => '*password Must Be Filled',
        ];
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ], $message);
        $data = $request->except('_token');

        $data = new User;
        $data->name = $request->name;
        $data->email = $request->email;

        // if(request()->photo){

        //     $path = public_path('/img/user/');
        //     $originalImage= $request->photo;
        //     $Image = Image::make($originalImage);
        //     $Image->resize(540,360);
        //     $fileName = time().$originalImage->getClientOriginalName();
        //     $Image->save($path.$fileName);
        //     $data->photo = $fileName;

        // }
        if (request()->password) {
            $data->password = Hash::make($request->password);
        }
        $data->save();
        return redirect('/user/list');
    }

    // public function store(Request $request)
    // {
    //     $list = User::query();
    //     if ($request->name) {
    //         $list = $list->where('name', 'like', '%' . $request->name . '%');
    //     }

    //     $data = User::all()->count();

    //     $list = $list->paginate('4');
    //     return view('user.list', compact('list', 'data'));
    // }

    public function show(User $id)
    {
        return view('user.view_data', compact('id'));
    }


    public function edit(User $id)
    {
        $role = Role::query()->get();
        return view('user.user_edit', compact('id', 'role'));
    }

    public function update(Request $request, User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'sometimes|nullable',
            'role_id' => 'sometimes|nullable'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();

        $user->syncRoles($role->name);

        return redirect('/user/list');
    }

    public function destroy(User $id)
    {
        $id->delete();
        return redirect('/user/list');
    }

    public function trash()
    {
        $trash = User::onlyTrashed()->get();
        $data = $trash->count();
        return view('user.trash', compact('trash', 'data'));
    }

    public function restore($id)
    {
        $restore = User::onlyTrashed()->where('id', $id);
        $restore->restore();

        return redirect('user/list');
    }

    public function delete($id)
    {
        $restore = User::onlyTrashed()->where('id', $id);
        $restore->forceDelete();

        return redirect('user/trash');
    }

    public function restore_all()
    {
        $restore = User::onlyTrashed();
        $restore->restore();

        return redirect('user/list');
    }

    public function delete_all()
    {
        $restore = User::onlyTrashed();
        $restore->forceDelete();

        return redirect('user/trash');
    }

    public function editRole(User $id)
    {
        $roles = Role::query()->get();
        return view('user.editRole', compact('id', 'roles'));
    }

    public function updateRole(Request $request, $id)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'sometimes|nullable',
            'role_id' => 'sometimes|nullable',
        ]);

        if ($request->password != null) {
            $data = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ];
        } else {
            unset($data['password']);
        }

        $user = User::findOrFail($id);

        if ($request->role_id) {
            $role = Role::where('id', $request->role_id)->first();
            $user->syncRoles($role->name);
        }

        User::where('id', $id)->update($data);
        return redirect('/user/indexRole');
    }

    public function givePermission(User $id)
    {
        $permission = Permission::query()->get();
        return view('user.model_permission', compact('id', 'permission'));
    }

    //untuk memasukkan ke model has permission
    public function storegivePermission(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $permission = Permission::findOrFail($request->permission);

        $user->givePermissionTo($permission);

        return redirect('/user');
    }
}
