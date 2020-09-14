<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Spatie\Permission\Models\Role;
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
        $data['jenis_kelamin'] = [
            'laki-laki' => 'Laki-laki',
            'perempuan' => 'perempuan'
        ];

        return view('user.index', $data);
    }

    public function store(Request $request)
    {
        $message = [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'email harus diisi',
            // 'jenis_kelamin.required' => 'jenis kelamin harus diisi',
            // 'alamat.required' => 'Alamat harus diisi',
        ];
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            // 'jenis_kelamin' => 'required',
        ], $message);

        DB::beginTransaction();
        try {
            $data = $request->except('_token', 'foto');
            $data['password'] = Hash::make('drago123456');

            if ($request->foto) {
                $path = public_path('/img/user/');
                $originalImage = $request->foto;
                $Image = Image::make($originalImage);
                $Image->resize(840, 859);
                $fileName = time() . $originalImage->getClientOriginalName();
                $Image->save($path . $fileName);

                $data['foto'] = $fileName;
            }
            $user = User::create($data);

            $user->assignRole('User');

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
        $data['jenis_kelamin'] = [
            'laki-laki' => 'Laki-laki',
            'perempuan' => 'perempuan'
        ];
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
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->alamat = $request->alamat;
            $user->bank = $request->bank;
            $user->no_rekening = $request->no_rekening;

            if ($request->password != null) {
                $user->password = Hash::make($request->password);
            }
            if ($request->foto) {
                $path = public_path('/img/user/');
                $originalImage = $request->foto;
                $Image = Image::make($originalImage);
                $Image->resize(840, 859);
                $fileName = time() . $originalImage->getClientOriginalName();
                $Image->save($path . $fileName);

                $user->foto = $fileName;
            } else {
                $user->foto = $request->foto_awal;
            }
            $user->save();

            if ($request->role_id) {
                $role = $user->roles->first()->name;
                $user->removeRole($role);

                $user->assignRole($request->role_id);
            }


            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        return redirect()->route($this->index)->with(['success' => 'User ' . $request->nama . ' berhasil diedit']);
    }

    public function delete(User $user)
    {
        $nama = $user->nama;
        $user->delete();
        return redirect()->route($this->index)->with(['danger' => 'User ' . $nama . ' berhasil dihapus']);
    }
}
