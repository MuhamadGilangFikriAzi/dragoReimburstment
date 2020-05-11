<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use DB;

class SettingController extends Controller
{
    protected $index = 'setting.index';
    protected $edit = 'setting.edit';
    protected $update = 'setting.update';

    public function index()
    {
        $data['pageTitle'] = 'Settings Index';
        $data['urlEdit'] = $this->edit;
        $data['all'] = Setting::all();

        return view('setting.index', $data);
    }

    public function edit(Setting $setting)
    {
        $data['pageTitle'] = 'Edit Setting';
        $data['urlIndex'] = $this->index;
        $data['urlUpdate'] = $this->update;
        $data['data'] = $setting;
        return view('setting.edit', $data);
    }

    public function update(Setting $setting, Request $request)
    {
        $setting->value = json_encode($request->nama);
        $setting->save();

        return redirect()->route($this->index)->with(['success' => 'Edit ' . $setting->nama . ' berhasil']);
    }
}