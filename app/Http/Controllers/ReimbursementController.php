<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reimbursement;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Image;

class ReimbursementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $list = Reimbursement::query()->with('user');

        if($request->title){
            $list = $list->where('title', 'like', '%'.$request->title.'%');
        }
        if ($request->staff) {
            $list = $list->where('staff', 'like', '%'.$request->staff.'%');
        }
        if ($request->date) {
            $list = $list->where('date',$request->date);
        }

        $list = $list->paginate('4');
        
        $data = Reimbursement::all()->count();
        return view('reimbursement/reimbursement',compact('list','data'));
    }

    public function allreimburstement()
    {
        $all = Reimbursement::with('user')->get();
        //menjumlahkan seluruh isi dari table total
        $sumall = $all->sum('total');
        return view('reimbursement/allreimbursement', compact('sumall','all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = UserModel::all();
        return view('reimbursement/create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
            'title.required' => '*Title Must be Filled',
            'user_id.required' => '*Name Must be Filled',
            'date.required' => '*Date Must be Filled',
            'description.required' => '*Description Must Be Filled',
            'total.required' => '*Total Must Be Filled',
            'proof.required' => '*Proof Must Be Filled'
        ];
        $this->validate($request,[
            'title' => 'required',
            'user_id' => 'required',
            'date' => 'required',
            'description' => 'required',
            'total' => 'required',
            'proof' => 'required'
        ],$message);
        // dd($request);
        $data = $request->except('_token','submit');

        if(request()->proof){
            $path = public_path('/img/proof/');
            $originalImage= $request->proof;
     
            $Image = Image::make($originalImage);
            $Image->resize(540,360);
            $fileName = time().$originalImage->getClientOriginalName();
            $Image->save($path.$fileName);
            $data['proof'] = $fileName;

        }

        
        Reimbursement::create($data);
        return redirect('/reimbursement');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Reimbursement $id)
    {
        $id->with('user')->get();
        return view('reimbursement/show',compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Reimbursement $id)
    {
        $id->with('user')->get();
        $data = userModel::all();
        return view('reimbursement/edit',compact('id','data'));
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
        dd($id);
        $this->validate($request,[
            'title' => 'required',
            'user_id' => 'required',
            'date' => 'required',
            'description' => 'required',
            'total' => 'required',
        ]);

        $data = $request->except('_token');
        $data = Reimbursement::findOrFail($id);
        $data->update($request->all());

        if(!empty($request->proof)){
            $path = public_path('/img/reimburstment/');
            $originalImage= $request->proof;
            $Image = Image::make($originalImage);
            $Image->resize(540,360);
            $fileName = time().$originalImage->getClientOriginalName();
            $Image->save($path.$fileName);
            $data['proof'] = $fileName;
            $data->save();
        }
        return redirect('/reimbursement');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = Reimbursement::find($id);
        $hapus->delete();
        return redirect('/reimbursement');
    }

    public function trash()
    {
        $trash = Reimbursement::onlyTrashed()->with('user')->get();
        $data = Reimbursement::onlyTrashed()->count();
        return view('reimbursement/trash_gilang',compact('trash','data')); 
    }

    public function restore_all()
    {
        $restore = Reimbursement::onlyTrashed();
        $restore->restore();

        return redirect('/reimbursement/trash');
    }

    public function restore($id)
    {
        $restore = Reimbursement::onlyTrashed()->where('id',$id);
        $restore->restore();

        return redirect('/reimbursement/trash');
    }

    public function delete_all()
    {
        $hapus = Reimbursement::onlyTrashed();
        $hapus->forceDelete();

        return redirect('/reimbursement/trash');
    }

    public function delete($id)
    {
        $hapus = Reimbursement::onlyTrashed()->where('id',$id);
        $hapus->forceDelete();

        return redirect('/reimbursement/trash');
    }

    public function total(Request $request)
    {
        $month = Reimbursement::with('user')->get();
        $sum = $month->sum('total');
        return view('/reimbursement/total_reimbursement', compact('month','sum')); 
    }
}
