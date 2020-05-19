@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
<div class="row justify-content-center">
    <div class="col-md-12">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
        @if ($message = Session::get('danger'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
        <div class="card">
            <div class="card-header"><b>Roles</b>
                <button type="button" class="btn btn-link btn-sm float-right" data-toggle="modal" data-target="#add_role"><i class="fas fa-plus"></i>&nbsp;Tambah role</button>
            </div>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

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
                            <span class="badge badge-pill badge-info">{{$permission->name}}</span>
                            @if($loop->iteration%4 == 0)
                            <br>
                            @endif
                            @empty
                            @endforelse
                        </td>
                        <td>
                            <div>
                                <a href="{{ route('role.show',$roles->id)}}" class="btn btn-link btn-sm" data-toggle="tooltip" title="lihat role"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('role.delete',$roles->id)}}" class="btn btn-link btn-sm text-danger" data-toggle="tooltip" title="Hapus role"><i class="fas fa-trash-alt"></i></a>
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
<div class="modal fade" id="add_role" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form tambah role</h4>
                <button type="button" class="close text-right" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('role.store')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control form-control-sm">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info pull-right btn-save">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
    </div>
</section>
@endsection
