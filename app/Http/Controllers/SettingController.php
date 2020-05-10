<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use DB;

class SettingController extends Controller
{
    protected $index = 'setting.index';
    protected $langsung = 'setting.langsung';
    protected $transfer = 'setting.transfer';
    protected $email = 'setting.email';

    public function index()
    {
        $langsung = Setting::where('nama', 'langsung')->get()->first();
        $transfer = Setting::where('nama', 'transfer')->get()->first();
        $email = Setting::where('nama', 'email')->get()->first();

        $data['langsung'] = json_decode($langsung->value);
        $data['transfer'] = json_decode($transfer->value);
        $data['email'] = json_decode($email->value);
        return view('setting.index', $data);
    }

    public function langsung()
    {
        dd('langsung');
    }

    public function transfer()
    {
        dd('transfer');
    }

    public function email()
    {
        dd('email');
    }
}
