<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reimbursement;
use App\Models\ReimburstmentDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReimburstExport;

class ReportController extends Controller
{
    protected $index = 'report.reimburstment.index';
    protected $result = 'report.reimburstment.result';
    protected $exportExcel = 'report.reimburstment.excel';
    protected $exportPdf = 'report.export.pdf';

    public function index()
    {
        $data['urlResult'] = $this->result;

        return view('report.index', $data);
    }

    public function report(Request $request)
    {
        $start = $request->date1;
        $end   = $request->date2;
        $data['date'] = [
            'start' => $start,
            'end' => $end
        ];
        $data['data'] = Reimbursement::whereBetween('tanggal', [$start, $end])->where('status', 'Diterima')->get();
        $data['excel'] = $this->exportExcel;
        $data['pdf'] = $this->exportPdf;

        return view('report.report', $data);
    }

    public function exportExcel(Request $request)
    {
        $data['start'] = $request->start;
        $data['end'] = $request->end;
        return Excel::download(new ReimburstExport($data), 'reimburstment.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $data['start'] = $request->start;
        $data['end'] = $request->end;
        return Excel::download(new ReimburstExport($data), 'reimburstment.pdf', \Maatwebsite\Excel\Excel::DOMPDF);


        // return (new ReimburstExport($data))->download('reimburstment.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function pengembalianIndex()
    {
        dd('masuk');
    }
}
