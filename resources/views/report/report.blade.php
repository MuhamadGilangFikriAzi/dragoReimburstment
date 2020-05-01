@extends('layouts.app')

@section('content')
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
                                <td>#</td>
                                <td>User</td>
                                <td>Tipe pengembalian</td>
                                <td>Asal dana</td>
                                <td>Tanggal</td>
                                <td>Status</td>
                                <td class="text-right">Total asal dana</td>
                                <td class="text-right">Total</td>
                            </tr>

                            @foreach($data as $key => $value)
                             <tr>
                                <td>{{ $key +1 }}</td>
                                <td>{{ $value->user['name'] }}</td>
                                <td>{{$value->tipe_pengembalian}}</td>
                                <td>{{$value->asal_dana}}</td>
                                <td>{{ $value->tanggal }}</td>
                                <td>{{$value->status}}</td>
                                @if ($value->tipe_pengembalian == 'pengembalian')
                                    <td class="text-right">{{ number_format($value->total_asal_dana,0,",",".") }}</td>
                                @else
                                    <td></td>
                                @endif
                                <td class="text-right">{{ number_format($value->total,0,",",".") }}</td>
                             </tr>
                            @endforeach
                            {{-- <tr>
                                <td colspan="4">Jumlah</td>
                                <td class="text-right"><b>Rp. {{ number_format($sum,2,",",".")}}</b></td>
                            </tr> --}}
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
