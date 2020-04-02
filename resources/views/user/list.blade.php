@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-left"><b>List User</b></div>
                <div class="card-body">
                    <div class="text-left">
                        <div class="">
                            <a href="{{ route('trash_user') }}" class="btn btn-outline-dark">Trash</a>
                            <a href="{{ route('add_data') }}" class="btn btn-outline-dark">Add Data</a>
                        </div>
                        <div class="col text-right">
                            <form action="" method="get">
                                <input type="text" name="name">
                                <input type="submit" value="Search" class="btn btn-dark">
                            </form>
                        </div>
                    </div>
                <form>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td><b>No</b></td>
                                    <td><b>Nama</b></td>
                                    <td><b>Email</b></td>
                                    <td><b>Action</b></td>
                                </tr>
                            </thead>
                           
                            <tbody>
                                @forelse($list as $key => $l)
                                <tr>
                                    <td><b>{{ $key+1 }}</b></td>
                                    <td>{{ $l->name }}</td>
                                    <td>{{ $l->email }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ url('user/show/'.$l->id.'') }}">
                                               <button type="button" class="btn btn-danger">Show</button>
                                            </a>
                                            <a href="{{ url('user/edit/'.$l->id.'') }}">
                                                <button type="button" class="btn btn-success">Edit</button>
                                            </a>
                                            <a href="{{ url('user/delete/'.$l->id.'') }}">
                                                <button type="button" class="btn btn-info">Delete</button>
                                            </a>
                                            <a href="{{ url('user/givePermission/'.$l->id.'') }}">
                                                <button type="button" class="btn btn-primary">Add Model Permission</button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No data evailable</td>
                                </tr>
                                
                                @endforelse 
                            </tbody>
                            <tfoot>
                                <td colspan="3">
                                    {{ $list->links() }}
                                </td>
                                <td colspan="1" style="color: grey; font-family: sans-serif;">
                                    Total entries {{ $data }}
                                </td>
                            </tfoot>
                        </table>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
