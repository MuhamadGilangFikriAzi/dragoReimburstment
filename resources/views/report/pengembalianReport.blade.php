@extends('layouts.app')

@section('content')
@php
    function format($n)
    {
        return number_format($n,0,',','.');
    }
@endphp
<section class="content">
    <div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>Laporan Pengembalian Dana </b>
                    <a href="{{route($excel,$date)}}" class="btn btn-link float-right"><i class="fas fa-file-excel"></i>Download Excel</a>
                    {{-- <a href="{{route($pdf,$date)}}" class="btn btn-link float-right"><i class="fas fa-file-pdf"></i>Download Pdf</a> --}}
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form action="" method="get">
                    @csrf
                    <div class="table-responsive">
                         <table class="table table-hover">
                            <tr>
                                <td>No</td>
                                <td>Nama</td>
                                <td>Tanggal</td>
                                <td>Asal dana</td>
                                <td>Status</td>
                                <td>Tipe pengembalian</td>
                                <td class="text-right">Total asal dana</td>
                                <td class="text-right">Digunakan</td>
                                <td class="text-right">Dikembalikan</td>
                            </tr>
                            @php
                                $total_asal_dana = 0;
                                $total_digunakan = 0;
                                $total_dikembalikan = 0;
                            @endphp
                            @forelse($data as $key => $value)
                            @php
                                $total_asal_dana += $value->total_asal_dana;
                                $total_digunakan += $value->total_digunakan;
                                $total_dikembalikan += $value->total_dikembalikan;
                            @endphp
                             <tr>
                                <td>{{ $key +1 }}</td>
                                <td>{{ $value->user['name'] }}</td>
                                <td>{{date('d-m-Y',strtotime($value->tanggal)) }}</td>
                                <td>{{$value->asal_dana}}</td>
                                <td>{{$value->status}}</td>
                                <td>{{$value->tipe_pengembalian}}</td>
                                <td class="text-right">{{ format($value->total_asal_dana) }}</td>
                                <td class="text-right">{{ format($value->total_digunakan) }}</td>
                                <td class="text-right">{{ format($value->total_dikembalikan) }}</td>
                             </tr>
                             @empty
                             <tr>
                                 <td colspan="9" class="text-center"> Tidak Ada Pengembalian Dana</td>
                             </tr>
                             @endforelse
                             <tr>
                                 <td colspan="6" class="text-right">Jumlah : </td>
                                 <td class="text-right">{{ format($total_asal_dana) }}</td>
                                 <td class="text-right">{{ format($total_digunakan) }}</td>
                                 <td class="text-right">{{ format($total_dikembalikan) }}</td>
                             </tr>
                        </table>
                    </div>
                    </form>
                 </div>
            </div>
        </div>
    </div>
    </div>
</section>

@endsection
