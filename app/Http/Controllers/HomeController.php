<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reimbursement;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use Image;

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
        // $role = Role::findById(2);
        // return auth()->user()->removeRole($role);
        // auth()->user()->assignRole('admin');

        // $role = Role::create(['name' => 'HRD']);
        // $permission = Permission::create(['name' => 'update post']);

        // $permission->assignRole($role);


        // $role = Role::findById(1);
        // $permission = Permission::findById(1);

        // $role->revokePermissionTo($permission);


        // auth()->user()->givePermissionTo('edit post');
        // return auth()->user()->permissions;

        // //mengambil seluruh data

        $all = Reimbursement::all();
        //menjumlahkan seluruh isi dari table total
        $sumall = $all->sum('total');
        //Menjumlahkan seluruh data yg ada
        $data = $all->count();
        $currentMonth = date('m');
        //mengambil data berdasarkan bulan ini
        $month = Reimbursement::whereRaw('MONTH(tanggal) = ?', [$currentMonth])->get();
        //menjumlahkan seluruh isi dari table total berdasarkan bulan ini
        $sum = $month->sum('total');
        //menghitung jumlah data yang ada pada bulan ini
        $countmonth = $month->count();

        $post = Reimbursement::orderBy('tanggal', 'DESC')->limit(5)->get();
        $sumpost = $post->sum('total');
        return view('home.dashboard', compact('month', 'countmonth', 'data', 'sum', 'sumall', 'post', 'sumpost'));
    }

    public function edit(User $id)
    {
        $data['thisRole'] = $id->roles->first()->id;
        $data['pageTitle'] = 'Edit user';
        $data['role'] = Role::pluck('name', 'id');
        $data['urlUpdate'] = $this->update;
        $data['urlIndex'] = $this->index;
        $data['data'] = $id;

        return view('home.edit_profile', $data);
    }

    public function update(Request $request, $id)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'sometimes|nullable',
            'role_id' => 'sometimes|nullable'
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

        if (!empty($request->photo)) {
            $path = public_path('/img/user/');
            $originalImage = $request->photo;
            $Image = Image::make($originalImage);
            $Image->resize(540, 360);
            $fileName = time() . $originalImage->getClientOriginalName();
            $Image->save($path . $fileName);
            $data['photo'] = $fileName;
        }

        $user = User::findOrFail($id);

        if ($request->role_id) {
            $role = Role::where('id', $request->role_id)->first();
            $user->syncRoles($role->name);
        }

        User::where('id', $id)->update($data);
        return redirect('/home');
    }
    public function filter()
    {

        $currentMonth = date('m');
        //mengambil data berdasarkan bulan ini
        $month = Reimbursement::whereRaw('MONTH(date) = ?', [$currentMonth])->get();
        //menjumlahkan seluruh isi dari table total berdasarkan bulan ini
        $sum = $month->sum('total');
        //menghitung jumlah data yang ada pada bulan ini
        $countmonth = $month->count();

        return view('reimbursement.filter_reimburse', compact('month', 'sum', 'countmonth'));
    }
}
