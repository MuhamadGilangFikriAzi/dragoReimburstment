<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reimbursement;
use App\Models\Pengembalian;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReimburstExport;
use App\Exports\PengembalianExport;

class ReportController extends Controller
{
    protected $index = 'report.reimburstment.index';
    protected $result = 'report.reimburstment.result';
    protected $exportExcel = 'report.reimburstment.excel';
    protected $exportPdf = 'report.export.pdf';
    protected $pengembalianIndex = 'report.pengembalian.index';
    protected $pengembalianResult = 'report.pengembalian.result';
    protected $pengembalianExcel = 'report.pengembalian.excel';
    protected $pengembalianPdf = 'report.pengembalian.pdf';


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
        $data['urlResult'] = $this->pengembalianResult;

        return view('report.pengembalianIndex', $data);
    }

    public function pengembalianReport(Request $request)
    {
        $start = $request->date1;
        $end   = $request->date2;
        $data['date'] = [
            'start' => $start,
            'end' => $end
        ];
        $data['data'] = Pengembalian::whereBetween('tanggal', [$start, $end])->get();
        $data['excel'] = $this->pengembalianExcel;
        $data['pdf'] = $this->pengembalianPdf;

        return view('report.pengembalianReport', $data);
    }

    public function pengembalianExcel(Request $request)
    {
        $data['start'] = $request->start;
        $data['end'] = $request->end;
        return Excel::download(new PengembalianExport($data), 'pengembalian_dana.xlsx');
    }

    public function pengembalianPdf(Request $request)
    {
        $data['start'] = $request->start;
        $data['end'] = $request->end;
        return Excel::download(new PengembalianExport($data), 'pengembalian_dana.pdf', \Maatwebsite\Excel\Excel::DOMPDF);


        // return (new ReimburstExport($data))->download('reimburstment.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
