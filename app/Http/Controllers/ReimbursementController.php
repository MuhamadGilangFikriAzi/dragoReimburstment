<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reimbursement;
use App\Models\ReimburstmentDetail;
use App\Models\Setting;
use App\User;
use Image, DB, Auth, Mail;

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
    protected $sendEmail = 'reimburstment.send.email';

    public function index(Request $request)
    {
        if (Auth::user()->roles()->first()->name == 'Admin' || Auth::user()->roles()->first()->name == 'Super Admin') {
            $list = Reimbursement::query()->with('user');
        } else {
            $list = Reimbursement::query()->where('id_user', Auth::user()->id);
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
        if ($request->tipe_pengembalian) {
            $list = $list->where('tipe_pengembalian', $request->tipe_pengembalian);
        }
        if ($request->status) {
            $list = $list->where('status', $request->status);
        }
        $data['tipe_pengembalian'] = [
            'langsung' => 'Langsung',
            'transfer' => 'Transfer',
        ];
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

    public function create()
    {
        $data['page_title'] = "Ajukan Reimburstment";
        $data['data'] = User::all();
        $data['return_type'] = array(
            'langsung' => 'Langsung',
            'transfer' => 'Transfer'
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
            if ($request->no_rek || $request->bank) {
                $user = User::find($request->user_id);
                if ($request->no_rek) {
                    $user->no_rekening = $request->no_rek;
                }
                if ($request->bank) {
                    $user->bank = $request->bank;
                }
                $user->save();
            }

            $reimburst = new Reimbursement;
            $reimburst->id_user = $request->user_id;
            $reimburst->tipe_pengembalian = $request->tipe_pengembalian;
            $reimburst->tanggal = $request->tanggal;
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
        $data['urlSendEmail'] = $this->sendEmail;
        $data['langsung'] = Setting::where('nama', 'langsung')->get()->first();
        $data['transfer'] = Setting::where('nama', 'transfer')->get()->first();

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
            if ($request->no_rek || $request->bank) {
                $user = User::find($request->user_id);
                if ($request->no_rek) {
                    $user->no_rekening = $request->no_rek;
                }
                if ($request->bank) {
                    $user->bank = $request->bank;
                }
                $user->save();
            }

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

    public function terima(Reimbursement $reimburst, Request $request)
    {
        $message = [
            'asal_dana.required' => 'Asal dana harus diisi'
        ];

        $rules = [
            'asal_dana' => 'required',
        ];
        $this->validate($request, $rules, $message);
        DB::beginTransaction();
        try {
            $reimburst->asal_dana = $request->asal_dana;
            $reimburst->status = 'Diterima';
            $reimburst->save();

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

    public function getUser(Request $request)
    {
        $user = User::find($request->id_user);

        $data = array(
            'bank' => $user->bank,
            'no_rek' => $user->no_rekening
        );
        return response()->json($data, 200);
    }

    public function sendEmail(Reimbursement $reimburst, Request $request)
    {
        try {
            $setting = Setting::where('nama', 'email')->get()->first();
            foreach (json_decode($setting->value) as $key => $value) {
                $email = $value;

                Mail::send('reimbursement.email', ['nama' => 'admin', 'pesan' => 'Coba', 'data' => $reimburst], function ($message) use ($email) {
                    $message->subject('Pengajuan Reimburstment');
                    $message->from('admin@gmail.com', 'Admin');
                    $message->to($email);
                });
            }

            return back()->with('alert-success', 'Berhasil Kirim Email');
        } catch (Exception $e) {
            return response(['status' => false, 'errors' => $e->getMessage()]);
        }
    }
}
