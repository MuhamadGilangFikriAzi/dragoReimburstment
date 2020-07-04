<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reimbursement;
use Spatie\Permission\Models\Role;
use App\Models\Pengembalian;
use App\User;
use Image, Auth;

class HomeController extends Controller
{
    protected $index = 'home.index';
    protected $edit = 'home.edit';
    protected $update = 'home.update';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['ditolak'] = count(Reimbursement::where('status', 'Ditolak')->get());
        $data['diterima'] = count(Reimbursement::where('status', 'Diterima')->get());
        $data['diajukan'] = count(Reimbursement::where('status', 'Diajukan')->get());
        $data['totalDiterima'] = Reimbursement::where('status', 'Diterima');
        $data['bulanIni'] = Reimbursement::where('status', 'Diterima')->whereRaw('MONTH(tanggal) = ?', date('m'));
        $data['limit'] = Reimbursement::orderBy('id', 'DESC')->limit(5)->get();
        $data['user']  = Reimbursement::where('id_user', Auth::user()->id)->get();
        $data['total_asal_dana'] = Pengembalian::all()->sum('total_asal_dana');
        $data['total_dikembalikan'] = Pengembalian::all()->sum('total_dikembalikan');

        return view('home.dashboard', $data);
    }

    public function edit(User $user)
    {
        $data['thisRole'] = $user->roles->first()->id;
        $data['pageTitle'] = 'Edit user';
        $data['role'] = Role::pluck('name', 'id');
        $data['urlUpdate'] = $this->update;
        $data['urlIndex'] = $this->index;
        $data['data'] = $user;

        return view('home.edit_profile', $data);
    }

    public function update(Request $request, User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'sometimes|nullable',
        ]);

        if ($request->password != null) {
            $user['password'] = bcrypt($data['password']);
        }

        if (!empty($request->foto)) {
            $path = public_path('/img/user/');
            $originalImage = $request->foto;
            $Image = Image::make($originalImage);
            $Image->resize(840, 859);
            $fileName = $user->name . time();
            $Image->save($path . $fileName);
            $user['foto'] = $fileName;
        }
        $user['name'] = $request->name;
        $user['email'] = $request->email;
        $user['bank'] = $request->bank;
        $user['no_rekening'] = $request->no_rekening;
        $user->save();

        if ($request->role_id) {
            $role = Role::where('id', $request->role_id)->first();
            $user->syncRoles($role->name);
        }

        return redirect('/home');
    }
}
