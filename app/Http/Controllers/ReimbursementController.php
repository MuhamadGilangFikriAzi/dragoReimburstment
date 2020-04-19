<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reimbursement;
use App\Models\ReimburstmentDetail;
use App\User;
use Illuminate\Support\Facades\Hash;
use Image, DB;

class ReimbursementController extends Controller
{

    public function index(Request $request)
    {
        $list = Reimbursement::query()->with('user');

        if ($request->nama) {
            $user = User::where('name', 'like', '%' . $request->nama . '%')->first();
            if ($user != null) {
                $list = $list->where('id_user', $user->id);
            } else {
                $list = $list->where('id_user', 0);
            }
        }

        if ($request->tanggal) {
            $list = $list->where('tanggal', $request->tanggal);
        }
        if ($request->tipe_pengembalian) {
            $list = $list->where('tipe_pengembalian', $request->tipe_pengembalian);
        }
        if ($request->status) {
            $list = $list->where('status', $request->status);
        }
        $data['tipe_pengembalian'] = ['langsung', 'transfer', 'pengembalian'];
        $data['status'] = ['Diajukan', 'Diterima', 'Ditolak'];
        $data['list'] = $list->paginate('4');
        $data['data'] = Reimbursement::all()->count();
        return view('reimbursement.index', $data);
    }

    public function allreimburstement()
    {
        $all = Reimbursement::with('user')->get();
        $sumall = $all->sum('total');
        return view('reimbursement.allreimbursement', compact('sumall', 'all'));
    }

    public function create()
    {
        $data['page_title'] = "Add Reimburstment";
        $data['data'] = User::all();
        $data['return_type'] = array(
            'langsung' => 'Langsung',
            'transfer' => 'Transfer',
            'pengembalian' => 'Pengembalian'
        );
        return view('reimbursement.create', $data);
    }

    public function store(Request $request)
    {
        $message = [
            'user_id.required' => '*Name Must be Filled',
            'tanggal.required' => '*Date Must be Filled'
            // 'Detail.*.price' => 'required',
        ];
        $this->validate($request, [

            'user_id' => 'required',
            'tanggal' => 'required'
            // 'Detail.*.price.required' => 'Harga wajib di input',
        ], $message);
        // dd($request);

        DB::beginTransaction();
        try {
            $reimburst = new Reimbursement;
            $reimburst->id_user = $request->user_id;
            $reimburst->tipe_pengembalian = $request->tipe_pengembalian;
            $reimburst->tanggal = $request->tanggal;
            $reimburst->asal_dana = $request->asal_dana;
            $reimburst->status = "Diajukan";
            $reimburst->total = $request->total;
            $reimburst->save();

            $detail = $request->Detail;
            $path = public_path('/img/bukti/');

            foreach ($detail as $key => $value) {
                $originalImage = $value['foto'];
                $Image = Image::make($originalImage);
                $Image->resize(540, 360);
                $fileName = time() . $originalImage->getClientOriginalName();
                $Image->save($path . $fileName);

                $reDetail = new ReimburstmentDetail;
                $reDetail->id_reimburstment = $reimburst->id;
                $reDetail->prihal = $value['prihal'];
                $reDetail->digunakan = $value['digunakan'];
                $reDetail->foto = $fileName;
                $reDetail->deskripsi = $value['deskripsi'];
                $reDetail->save();
            }

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
        }

        return redirect()->route('reimburstment');
    }

    public function show(Reimbursement $reimburst)
    {
        $data['data'] = $reimburst;
        return view('reimbursement.show', $data);
    }

    public function edit(Reimbursement $id)
    {
        $id->with('user')->get();
        $data = userModel::all();
        return view('reimbursement.edit', compact('id', 'data'));
    }

    public function update(Request $request, $id)
    {
        dd($id);
        $this->validate($request, [
            'title' => 'required',
            'user_id' => 'required',
            'date' => 'required',
            'description' => 'required',
            'total' => 'required',
        ]);

        $data = $request->except('_token');
        $data = Reimbursement::findOrFail($id);
        $data->update($request->all());

        if (!empty($request->proof)) {
            $path = public_path('/img/reimburstment/');
            $originalImage = $request->proof;
            $Image = Image::make($originalImage);
            $Image->resize(540, 360);
            $fileName = time() . $originalImage->getClientOriginalName();
            $Image->save($path . $fileName);
            $data['proof'] = $fileName;
            $data->save();
        }
        return redirect('.reimbursement');
    }

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
        return view('reimbursement.trash_gilang', compact('trash', 'data'));
    }

    public function restore_all()
    {
        $restore = Reimbursement::onlyTrashed();
        $restore->restore();

        return redirect('/reimbursement/trash');
    }

    public function restore($id)
    {
        $restore = Reimbursement::onlyTrashed()->where('id', $id);
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
        $hapus = Reimbursement::onlyTrashed()->where('id', $id);
        $hapus->forceDelete();

        return redirect('/reimbursement/trash');
    }

    public function total(Request $request)
    {
        $month = Reimbursement::with('user')->get();
        $sum = $month->sum('total');
        return view('reimbursement.total_reimbursement', compact('month', 'sum'));
    }
}
