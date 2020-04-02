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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = User::query();
        $data = User::count();

        $list = User::paginate('5');

        return view('user.list',compact('list','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('user.add_data');
    }
    public function create(Request $request)
    {
        $message = [
            'name.required' => '*Name Must Be Filled',
            'email.required' => '*email Must Must Be Filled',
            'password.required' => '*password Must Be Filled',
        ];
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ],$message);
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
        if(request()->password){
            $data->password = Hash::make($request->password);
        }
            $data->save();
        return redirect('/user/list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $list = User::query();
        if($request->name){
            $list = $list->where('name','like','%'.$request->name.'%');
        }

        $data = User::all()->count();

        $list = $list->paginate('4');
        return view('user.list',compact('list','data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $id)
    {
        return view('user.view_data', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $id)
    {
        $role = Role::query()->get();
        return view('user.user_edit',compact('id','role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {  
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'sometimes|nullable',
            'role_id' =>'sometimes|nullable'
        ]);

        if($request->password != null){
            $data = [
                'name' => $data['name'],
                'email'=> $data['email'],
                'password'=> bcrypt($data['password'])
            ];
        }else{
            unset($data['password']);
        }

        $user = User::findOrFail($id);

        if($request->role_id)
        {
            $role = Role::where('id',$request->role_id)->first();
            $user->syncRoles($role->name);
        }

        User::where('id', $id)->update($data);
        return redirect('/user/list');
        // $this->validate($request, ['name' => 'required', 'email' => 'required']);

        // $user = request()->except('_token','id','created_at');

        // $user = User::findOrFail($id);
        

        // if(!empty($request->input('password'))) {
        //     $password = bcrypt($request->input('password'));
        //     $user->password = $password;
        //     $user->name     = $request->name;
        //     $user->email    = $request->email;
        //     $user->save();
        // }
        //     $user->update($request->all());
        //     return redirect('/user/list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $id)
    {
        $id->delete();
        return redirect('/user/list');
    }

    public function trash()
    {
        $trash = User::onlyTrashed()->get();
        $data = $trash->count();
        return view('user.trash',compact('trash','data'));
    }

    public function restore($id)
    {
        $restore = User::onlyTrashed()->where('id',$id);
        $restore->restore();

        return redirect('user/list');
    }

    public function delete($id)
    {
        $restore = User::onlyTrashed()->where('id',$id);
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
        return view('user.editRole',compact('id','roles'));
    }

    public function updateRole(Request $request, $id)
    {
         $data = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'sometimes|nullable',
            'role_id' => 'sometimes|nullable',
        ]);

        if($request->password != null){
            $data = [
                'name' => $data['name'],
                'email'=> $data['email'],
                'password'=> bcrypt($data['password']),
            ];
        }
        else {
            unset($data['password']);
        }

        $user = User::findOrFail($id);

        if($request->role_id)
        {
            $role = Role::where('id',$request->role_id)->first();
            $user->syncRoles($role->name);
        }

        User::where('id', $id)->update($data);
        return redirect('/user/indexRole');
    }

    public function givePermission(User $id)
    {
        $permission = Permission::query()->get();
        return view('user.model_permission',compact('id','permission'));
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
