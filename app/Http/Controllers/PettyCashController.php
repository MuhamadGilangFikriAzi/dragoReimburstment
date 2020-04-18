<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PettyCash;

class PettyCashController extends Controller
{
    public function index()
    {
        $query = PettyCash::query();
        $masuk = PettyCash::where('tipe', 'masuk')->sum('total');
        $keluar = PettyCash::where('tipe', 'keluar')->sum('total');

        if (request()->name) {
            $query->where('name', 'LIKE', '%' . request()->name . '%');
        }

        if (request()->code) {
            $query->where('code', 'LIKE', '%' . request()->code . '%');
        }

        $pettyCash = $query->paginate(10);
        $data['sum'] = $masuk - $keluar;
        $data['pettyCash'] = $pettyCash;
        $data['pageTitle'] = 'Petty Cash';

        return view('pettyCash.index', $data);
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        PettyCash::insert($data);

        return redirect()->back()->with(['success' => 'Data Berhasil Disimpan']);
    }
}
