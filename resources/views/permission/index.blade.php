@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><b>Roles</b></div>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <a class="btn btn-sm btn-dark mb-2 float-right" href="{{ route('create_permission') }}" role="button">New</a>

                <table class="table table-striped">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Guard</th>
                        <th>Role</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    @foreach($permission as $key => $value)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->guard_name }}</td>
                        <td> 
                            @forelse($value->roles as $role)
                            <span class="badge badge-pill badge-success">{{$role->name}}</span>
                            @if($loop->iteration%4 == 0)
                            <br>
                            @endif
                            @empty
                            @endforelse
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Setting
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('show_permission',$value->id) }}">Show</a>
                                    <a class="dropdown-item" href="{{ route('edit_permission',$value->id) }}">Edit</a>
                                    <a class="dropdown-item" href="{{ route('delete_permission',$value->id) }}">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
