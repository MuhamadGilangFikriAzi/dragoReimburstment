<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Image, DB;

class userController extends Controller
{
    protected $index = 'user.index';
    protected $create = 'user.create';
    protected $store = 'user.store';
    protected $show = 'user.show';
    protected $edit = 'user.edit';
    protected $update = 'user.update';
    protected $delete = 'user.delete';

    public function index()
    {
        $data['count'] = User::count();
        $data['pageTitle'] = 'User Index';
        $data['data'] = User::paginate('10');
        $data['urlIndex'] = $this->index;
        $data['urlStore'] = $this->store;
        $data['urlEdit'] = $this->edit;
        $data['urlShow'] = $this->show;
        $data['urlDelete'] = $this->delete;

        return view('user.index', $data);
    }

    public function create()
    {
        $data['pageTitle'] = 'Tambah User';
        $data['urlIndex'] = $this->index;
        $data['urlStore'] = $this->store;

        return view('user.create', $data);
    }

    public function store(Request $request)
    {
        $message = [
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'email harus diisi',
        ];
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required',
        ], $message);

        DB::beginTransaction();
        try {
            $data = new User;
            $data->name = $request->nama;
            $data->email = $request->email;
            $data->password = Hash::make('drago123456');
            $data->save();

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
        }

        return redirect()->route($this->index)->with(['success' => 'User ' . $request->nama . ' berhasil dibuat']);
    }

    public function show(User $id)
    {
        return view('user.view_data', compact('id'));
    }


    public function edit(User $user)
    {
        $data['thisRole'] = $user->roles->first()->id;
        $data['pageTitle'] = 'Edit user';
        $data['role'] = Role::pluck('name', 'id');
        $data['urlUpdate'] = $this->update;
        $data['urlIndex'] = $this->index;
        $data['data'] = $user;
        return view('user.edit', $data);
    }

    public function update(Request $request, User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'sometimes|nullable',
        ]);

        DB::beginTransaction();
        try {

            $user->name = $request->name;
            $user->email = $request->email;
            $user->no_rekening = $request->no_rekening;

            if ($request->password != null) {
                $user->password = Hash::make($request->password);
            }
            if ($request->foto) {
                $path = public_path('/img/user/');
                $originalImage = $request->foto;
                $Image = Image::make($originalImage);
                $Image->resize(540, 360);
                $fileName = time() . $originalImage->getClientOriginalName();
                $Image->save($path . $fileName);

                $user->foto = $fileName;
            } else {
                $user->foto = $request->foto_awal;
            }
            $user->save();

            $user->assignRole($request->role_id);

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
        }

        return redirect()->route($this->index)->with(['success' => 'User ' . $request->nama . ' berhasil diedit']);
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
