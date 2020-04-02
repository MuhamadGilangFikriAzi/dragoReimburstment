@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><b>Reimburse In This Month</b></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form>
                        @csrf
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Proof</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                {?>
                                @foreach( $month as $l )
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>{{ $l->title }}</td>
                                    <td>{{ $l->date }}</td>
                                    <td>{{ $l->staff }}</td>
                                    <td>{{number_format($l->total,0,",",".")}}</td>
                                    <td><img src="{{ asset('img/reimburstment/'.$l->proof) }}" alt="..." class="img-thumbnail"  data-toggle="modal" data-target="#exampleModal" style="width: 130px; height: 100px;">

                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="{{ asset('img/reimburstment/'.$l->proof) }}" alt="..." class="img-thumbnail" style="width: 500px; height: 500px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div></td>
                                </tr>
                                @endforeach
                                <?php } ?>
                                <tr>
                                    <td colspan="4">Total :</td>
                                    <td>{{number_format($sum,0,",",".")}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
