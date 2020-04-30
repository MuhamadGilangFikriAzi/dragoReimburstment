<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reimbursement;
use App\Models\ReimburstmentDetail;
use App\Models\PettyCash;
use App\User;
use Image, DB;

class ReimbursementController extends Controller
{

    protected $index = 'reimburstment.index';
    protected $create = 'reimburstment.create';
    protected $store = 'reimburstment.store';
    protected $show = 'reimburstment.show';
    protected $edit = 'reimburstment.edit';
    protected $update = 'reimburstment.update';
    protected $delete = 'reimburstment.delete';
    protected $terima = 'reimburstment.terima';
    protected $tolak = 'reimburstment.tolak';

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
        $data['list'] = $list->paginate('10');
        $data['data'] = Reimbursement::all()->count();
        $data['urlIndex'] = $this->index;
        $data['urlCreate'] = $this->create;
        $data['urlShow'] = $this->show;
        $data['urlEdit'] = $this->edit;
        $data['urlDelete'] = $this->delete;
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
        $data['page_title'] = "Ajukan Reimburstment";
        $data['data'] = User::all();
        $data['return_type'] = array(
            'langsung' => 'Langsung',
            'transfer' => 'Transfer',
            'pengembalian' => 'Pengembalian'
        );
        $data['urlIndex'] = $this->index;
        $data['urlStore'] = $this->store;
        $data['pageTitle'] = 'Ajukan Reimburstment';
        return view('reimbursement.create', $data);
    }

    public function store(Request $request)
    {
        $message = [
            'user_id.required' => 'Nama harus diisi',
            'tanggal.required' => 'Tanggal harus diisi',
            'tipe_pengembalian.required' => 'Tipe pengembalian harus diisi',
            'asal_dana.required' => 'Asal dana harus diisi',
            'Detail.*.prihal.required' => 'Prihal harus diisi',
            'Detail.*.digunakan.required' => 'Total harus diisi',
            'Detail.*.foto.required' => 'Foto harus diisi',
            'Detail.*.deskripsi.required' => 'Deskripsi harus diisi'
        ];

        $rules = [
            'user_id' => 'required',
            'tanggal' => 'required',
            'tipe_pengembalian' => 'required',
            'Detail.*.prihal' => 'required',
            'Detail.*.digunakan' => 'required',
            'Detail.*.foto' => 'required',
            'Detail.*.deskripsi' => 'required'
        ];
        $this->validate($request, $rules, $message);
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
            if ($request->tipe_pengembalian == "pengembalian") {
                $reimburst->total_asal_dana = $request->digunakan;
            }
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

        return redirect()->route($this->index);
    }

    public function show(Reimbursement $reimburst)
    {
        // dd($reimburst);
        $data['data'] = $reimburst;
        $data['pageTitle'] = 'Pengajuan Reimburstment';
        $data['urlIndex'] = $this->index;
        $data['urlTerima'] = $this->terima;
        $data['urlTolak'] = $this->tolak;
        return view('reimbursement.view', $data);
    }

    public function edit(Reimbursement $reimburst)
    {
        // dd($reimburst->detail);
        $data['pageTitle'] = 'Edit Pengajuann Reimburstment';
        $data['urlIndex'] = $this->index;
        $data['urlUpdate'] = $this->update;

        $data['data'] = $reimburst;
        $data['user'] = User::pluck('name', 'id');
        $data['count'] = count($reimburst->detail);
        $data['return_type'] = array(
            'langsung' => 'Langsung',
            'transfer' => 'Transfer',
            'pengembalian' => 'Pengembalian'
        );
        $data['langsung'] = array(
            'petty cash' => 'Petty Cash',
            'uang pribadi' => 'Uang Pribadi'
        );
        $data['transfer'] = array(
            'BCA' => 'BCA',
            'Cimb Niaga' => 'cimb Niaga'
        );

        return view('reimbursement.edit', $data);
    }

    public function update(Request $request, Reimbursement $reimburst)
    {
        // $this->validate($request, [
        //     'title' => 'required',
        //     'user_id' => 'required',
        //     'date' => 'required',
        //     'description' => 'required',
        //     'total' => 'required',
        // ]);

        DB::beginTransaction();
        try {
            $reimburst->detail->each->delete();

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
                if (!isset($value['foto'])) {
                    $fileName = $value['foto_awal'];
                } else {
                    $originalImage = $value['foto'];
                    $Image = Image::make($originalImage);
                    $Image->resize(540, 360);
                    $fileName = time() . $originalImage->getClientOriginalName();
                    $Image->save($path . $fileName);
                }

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
        return redirect()->route($this->index);
    }

    public function delete(Reimbursement $reimburst)
    {
        $reimburst->detail->each->delete();
        $reimburst->delete();

        return redirect()->route($this->index);
    }

    public function terima(Reimbursement $reimburst)
    {
        DB::beginTransaction();
        try {
            $reimburst->status = 'Diterima';
            $reimburst->save();

            if ($reimburst->tipe_pengembalian == "pengembalian") {
                $pettyCash = new PettyCash;
                $pettyCash->id_user = $reimburst->id_user;
                $pettyCash->tanggal = date('Y-m-d');
                $pettyCash->tipe = 'masuk';
                $pettyCash->total = $reimburst->total;
                $pettyCash->deskripsi = 'Menerima pengembalian ' . $reimburst->user['name'];
                $pettyCash->save();
            } elseif ($reimburst->tipe_pengembalian == "langsung" && $reimburst->asal_dana == "petty cash") {
                $pettyCash = new PettyCash;
                $pettyCash->id_user = $reimburst->id_user;
                $pettyCash->tanggal = date('Y-m-d');
                $pettyCash->tipe = 'keluar';
                $pettyCash->total = $reimburst->total;
                $pettyCash->deskripsi = 'Menerima pengajuan reimburstment ' . $reimburst->user['name'];
                $pettyCash->save();
            }

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
        }
        return redirect()->route($this->index)->with(['success' => 'Pengajuan Reimburstment ' . $reimburst->user['name'] . ' Diterima']);
    }

    public function tolak(Reimbursement $reimburst)
    {
        $reimburst->status = 'Ditolak';
        $reimburst->save();

        return redirect()->route($this->index)->with(['danger' => 'Pengajuan Reimburstment ' . $reimburst->user['name'] . ' Ditolak']);
    }

    public function total(Request $request)
    {
        $month = Reimbursement::with('user')->get();
        $sum = $month->sum('total');
        return view('reimbursement.total_reimbursement', compact('month', 'sum'));
    }
}
