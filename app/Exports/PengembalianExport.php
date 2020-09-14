<?php

namespace App\Exports;

use App\Models\Pengembalian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PengembalianExport implements FromView, ShouldAutoSize
{
    public function __construct(array $data)
    {
        $this->start = $data['start'];
        $this->end = $data['end'];
    }

    public function view(): View
    {
        $data['data'] = Pengembalian::whereBetween('tanggal', [$this->start, $this->end])->get();
        $data['start'] = $this->start;
        $data['end'] = $this->end;
        return view('report.pengembalianView', $data);
    }
}
