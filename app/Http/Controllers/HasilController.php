<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        return view('report/report');
    }

    public function result(Request $request)
    {
        $start = $request->date1;
        $end   = $request->date2;     
        $filtered = Hasil::whereBetween('date', [$start, $end])->get();         //dd($filtered->count());
        $sum = $filtered->sum('total');
   
        return view('report/result', compact('filtered','sum')); 
    }
}
