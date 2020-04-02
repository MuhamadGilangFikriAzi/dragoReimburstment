@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>Result</b></div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                
                    <form action="" method="get">
                    @csrf
                    <div class="table-responsive">
                         <table class="table table-striped table-bordered">
                            <tr class=" text-center">
                                <td>#</td>
                                <td>Title</td>
                                <td>User</td>
                                <td>Date</td>
                                <td>Total</td>
                            </tr>

                            @foreach($filtered as $key => $l)
                             <tr>
                                 <td>{{ $key +1 }}</td>
                                 <td>{{ $l->title }}</td>
                                 <td>{{ $l->user['name'] }}</td>
                                 <td>{{ $l->date }}</td>
                                 <td>{{ number_format($l->total,2,",",".") }}</td>
                             </tr>

                            @endforeach
                            <tr>
                                <td colspan="4">Jumlah</td>
                                <td class="text-right"><b>Rp. {{ number_format($sum,2,",",".")}}</b></td>
                            </tr>
                        </table>
                    </div>
                    </form>
                 </div>
            </div>
        </div>
    </div>

@endsection
