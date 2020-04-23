@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><b>Show Data</b></div>
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form action="" method="post">
                @csrf
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td>Name</td>
                                <td>{{ $id->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $id->email }}</td>
                            </tr>
                            <tr>
                                <td>Created At</td>
                                <td>{{ $id->created_at  }}</td>
                            </tr>
                            <tr>
                                <td>Foto</td>
                                <td>
                                     <img src="{{ asset('img/user/'.$id->photo) }}" alt="..." class="img-thumbnail"  data-toggle="modal" data-target="#exampleModal" style="width: 130px; height: 100px;">

                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">           
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="{{ asset('img/user/'.$id->photo) }}" alt="..." class="img-thumbnail" style="width: 500px; height: 500px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
