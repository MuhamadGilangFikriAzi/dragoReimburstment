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
                    <b>Laporan Reimburstment</b>
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
                                <td>Tipe pengembalian</td>
                                <td>Asal dana</td>
                                <td>Tanggal</td>
                                <td>Status</td>
                                <td class="text-right">Total</td>
                            </tr>
                            @php
                                $total = 0;
                            @endphp
                            @forelse($data as $key => $value)
                            @php
                                $total += $value->total;
                            @endphp
                             <tr>
                                <td>{{ $key +1 }}</td>
                                <td>{{ $value->user['name'] }}</td>
                                <td>{{$value->tipe_pengembalian}}</td>
                                <td>{{$value->asal_dana}}</td>
                                <td>{{date('d-m-Y',strtotime($value->tanggal)) }}</td>
                                <td>{{$value->status}}</td>
                                <td class="text-right">Rp. {{ format($value->total) }}</td>
                             </tr>

                             @empty
                             <tr>
                                 <td colspan="8" class="text-center"> Tidak Ada Reimburstment</td>
                             </tr>
                             @endforelse
                            <tr>
                                <td colspan="6" class="text-right">Jumlah : </td>
                                <td class="text-right"><b>Rp. {{ format($total)}}</b></td>
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
