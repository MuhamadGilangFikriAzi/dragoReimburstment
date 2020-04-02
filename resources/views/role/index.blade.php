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

                <a class="btn btn-sm btn-dark mb-2 float-right" href="{{ route('create_role') }}" role="button">New Role</a>
                <a class="btn btn-sm btn-dark mb-2 mr-2 float-right" href="{{ route('createRoleHasPermission') }}" role="button">New Role Has Permission</a>

                <table class="table table-striped">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Guard</th>
                        <th>Permission</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    @foreach($role as $key => $roles)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $roles->name }}</td>
                        <td>{{ $roles->guard_name }}</td>
                        <td>
                            @forelse($roles->permissions as $permission)
                            <span class="badge badge-pill badge-success">{{$permission->name}}</span>
                            @if($loop->iteration%4 == 0)
                            <br>
                            @endif
                            @empty
                            @endforelse
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Setting
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('show_role',$roles->id) }}">Show</a>
                                    <a class="dropdown-item" href="{{ route('edit_role',$roles->id) }}">Edit</a>
                                    <a class="dropdown-item" href="{{ route('delete_role',$roles->id) }}">Delete</a>
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
