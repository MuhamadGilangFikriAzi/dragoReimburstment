<?php

namespace App\Exports;

use App\Models\Reimbursement;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class ReimburstExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct(array $data)
    {
        $this->start = $data['start'];
        $this->end = $data['end'];
    }

    public function view(): View
    {
        $data['data'] = Reimbursement::whereBetween('tanggal', [$this->start, $this->end])->where('status', 'Diterima')->get();
        $data['start'] = $this->start;
        $data['end'] = $this->end;
        return view('report.view', $data);
    }
    // public function headings(): array
    // {
    //     return [
    //         'id',
    //         '#',
    //         'User',
    //         'Tipe pengembalian',
    //         'Asal dana',
    //         'Tanggal',
    //         'Status',
    //         'Total asal dana',
    //         'Total'
    //     ];
    // }

}
