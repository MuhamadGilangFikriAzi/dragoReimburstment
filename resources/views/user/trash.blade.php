@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>Trash User</b>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <div class="row">
                            <div class="col">
                                <a href="{{ route('restore_all_user') }}" class="btn btn-outline-dark">Restore All</a>  
                                <a href="{{ route('delete_all_user') }}" class="btn btn-outline-dark">Remove All Permanent</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped ">
                                <thead>
                                    <tr>
                                        <td><b>Name</b></td>
                                        <td><b>Email</b></td>
                                        <td><b>Action</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                      @foreach($trash as $t)
                                        <tr>
                                                <td>{{ $t->name }}</td>
                                                <td>{{ $t->email }}</td>
                                                <td>
                                                    <a href="{{ url('user/restore/'.$t->id.'') }}">
                                                        <button type="button" class="btn btn-danger">Restore</button>
                                                    </a>
                                                    <a href="{{ url('user/del_permanent/'.$t->id.'') }}"> 
                                                        <button type="button" class="btn btn-info">Delete</button>
                                                    </a>
                                                </td>
                                         </tr>
                                     @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col" style="color: grey; font-family: sans-serif;">
                            Total trash: {{ $data }}
                        </div>
                     </div>
                </div>
            </div>
        </div>
</div>
@endsection
