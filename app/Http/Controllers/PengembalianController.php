<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\PengembalianDetail;
use App\User;
use Image, DB, Auth;

class PengembalianController extends Controller
{
    protected $index = 'pengembalian.index';
    protected $create = 'pengembalian.create';
    protected $store = 'pengembalian.store';
    protected $show = 'pengembalian.show';
    protected $edit = 'pengembalian.edit';
    protected $update = 'pengembalian.update';
    protected $delete = 'pengembalian.delete';
    protected $terima = 'pengembalian.terima';
    protected $tolak = 'pengembalian.tolak';

    public function index(Request $request)
    {
        if (Auth::user()->roles()->first()->name == 'Admin') {
            $list = Pengembalian::query()->with('user');
        } else {
            $list = Pengembalian::query()->where('id_user', Auth::user()->id);
        }

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
        if ($request->status) {
            $list = $list->where('status', $request->status);
        }

        $data['pageTitle'] = 'Pengembalian Dana';
        $data['status'] = ['Diajukan', 'Diterima', 'Ditolak'];
        $data['list'] = $list->paginate('10');
        $data['data'] = Pengembalian::all()->count();
        $data['urlIndex'] = $this->index;
        $data['urlCreate'] = $this->create;
        $data['urlShow'] = $this->show;
        $data['urlEdit'] = $this->edit;
        $data['urlDelete'] = $this->delete;
        return view('pengembalian.index', $data);
    }
    public function create()
    {
        $data['page_title'] = "Ajukan Reimburstment";
        $data['data'] = User::all();
        $data['urlIndex'] = $this->index;
        $data['urlStore'] = $this->store;
        $data['asalDana'] = ['Petty Cash', 'Uang Pribadi', 'BCA', 'Cimb Niaga'];
        $data['pageTitle'] = 'Pengembalian Dana';
        return view('Pengembalian.create', $data);
    }

    public function store(Request $request)
    {
        $message = [
            'user_id.required' => 'Nama harus diisi',
            'tanggal.required' => 'Tanggal harus diisi',
            'Detail.*.prihal.required' => 'Prihal harus diisi',
            'Detail.*.digunakan.required' => 'Total harus diisi',
            'Detail.*.foto.required' => 'Foto harus diisi',
            'Detail.*.deskripsi.required' => 'Deskripsi harus diisi'
        ];

        $rules = [
            'user_id' => 'required',
            'tanggal' => 'required',
            'Detail.*.prihal' => 'required',
            'Detail.*.digunakan' => 'required',
            'Detail.*.foto' => 'required',
            'Detail.*.deskripsi' => 'required'
        ];
        $this->validate($request, $rules, $message);

        DB::beginTransaction();
        try {

            $pengembalian = new Pengembalian;
            $pengembalian->id_user = $request->user_id;
            $pengembalian->tanggal = $request->tanggal;
            $pengembalian->status = "Diajukan";
            $pengembalian->total_digunakan = $request->total_digunakan;
            $pengembalian->asal_dana = $request->asal_dana;
            $pengembalian->total_asal_dana = $request->total_asal_dana;
            $pengembalian->total_dikembalikan = $request->total_dikembalikan;
            $pengembalian->save();

            $detail = $request->Detail;
            $path = public_path('/img/bukti/');

            foreach ($detail as $key => $value) {
                $originalImage = $value['foto'];
                $Image = Image::make($originalImage);
                $Image->resize(540, 360);
                $fileName = time() . $originalImage->getClientOriginalName();
                $Image->save($path . $fileName);

                $reDetail = new PengembalianDetail();
                $reDetail->id_pengembalian = $pengembalian->id;
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

        return redirect()->route($this->index)->with(['success' => 'Pengembalian berhasil ditambahkan']);
    }

    public function show(Pengembalian $pengembalian)
    {
        // dd($reimburst);
        $data['data'] = $pengembalian;
        $data['pageTitle'] = 'Pengembalian Dana';
        $data['urlIndex'] = $this->index;
        $data['urlTerima'] = $this->terima;
        $data['urlTolak'] = $this->tolak;
        return view('pengembalian.view', $data);
    }

    public function edit(pengembalian $pengembalian)
    {
        // dd($reimburst->detail);
        $data['pageTitle'] = 'Edit Pengembalian Dana';
        $data['urlIndex'] = $this->index;
        $data['urlUpdate'] = $this->update;
        $data['data'] = $pengembalian;
        $data['user'] = User::pluck('name', 'id');
        $data['count'] = count($pengembalian->detail);
        $data['asalDana'] = ['Petty Cash', 'Uang Pribadi', 'BCA', 'Cimb Niaga'];
        return view('pengembalian.edit', $data);
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        DB::beginTransaction();
        try {
            $pengembalian->detail->each->delete();

            $pengembalian->id_user = $request->user_id;
            $pengembalian->tanggal = $request->tanggal;
            $pengembalian->status = "Diajukan";
            $pengembalian->total_digunakan = $request->total_digunakan;
            $pengembalian->asal_dana = $request->asal_dana;
            $pengembalian->total_asal_dana = $request->total_asal_dana;
            $pengembalian->total_dikembalikan = $request->total_dikembalikan;
            $pengembalian->save();

            $detail = $request->Detail;
            $path = public_path('/img/bukti/');

            foreach ($detail as $key => $value) {
                $pengembalianDetail = new PengembalianDetail();

                if ($value['foto']) {
                    $originalImage = $value['foto'];
                    $Image = Image::make($originalImage);
                    $Image->resize(540, 360);
                    $fileName = time() . $originalImage->getClientOriginalName();
                    $Image->save($path . $fileName);
                    $pengembalianDetail->foto = $fileName;
                } else {
                    $pengembalianDetail->foto = $value['foto_awal'];
                }
                $pengembalianDetail->id_pengembalian = $pengembalian->id;
                $pengembalianDetail->prihal = $value['prihal'];
                $pengembalianDetail->digunakan = $value['digunakan'];
                $pengembalianDetail->deskripsi = $value['deskripsi'];
                $pengembalianDetail->save();
            }

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
        }
        return redirect()->route($this->index);
    }

    public function delete(Pengembalian $pengembalian)
    {
        $pengembalian->detail->each->delete();
        $pengembalian->delete();

        return redirect()->route($this->index);
    }

    public function terima(Pengembalian $pengembalian)
    {
        DB::beginTransaction();
        try {
            $pengembalian->status = 'Diterima';
            $pengembalian->save();

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
        }
        return redirect()->route($this->index)->with(['success' => 'pengembalian dana ' . $pengembalian->user['name'] . ' Diterima']);
    }

    public function tolak(Pengembalian $pengembalian)
    {
        $pengembalian->status = 'Ditolak';
        $pengembalian->save();

        return redirect()->route($this->index)->with(['danger' => 'pengembalian dana ' . $pengembalian->user['name'] . ' Ditolak']);
    }
}
