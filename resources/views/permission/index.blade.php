@extends('layouts.app')

@section('content')
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
            <div class="card-header"><b>Permission</b>
                <button type="button" class="btn btn-link btn-sm float-right" data-toggle="modal" data-target="#add_permission"><i class="fas fa-plus"></i>&nbsp;Add Permission</button>
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
                    @foreach($permissions as $key => $value)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->guard_name }}</td>
                        <td>
                            @forelse($value->permissions as $permission)
                            <span class="badge badge-pill badge-success">{{$permission->name}}</span>
                            @if($loop->iteration%4 == 0)
                            <br>
                            @endif
                            @empty
                            @endforelse
                        </td>
                        <td>
                            <div>
                                <a href="{{ route('role.show',$value->id)}}" class="btn btn-link btn-sm" data-toggle="tooltip" title="lihat detail">View</a>
                                <a href="{{ route('role.delete',$value->id)}}" class="btn btn-link btn-sm text-danger" data-toggle="tooltip" title="Hapus data">Delete</a>
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
<div class="modal fade" id="add_permission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Add Permission</h4>
                <button type="button" class="close text-right" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('permission.store')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="permission" class="form-control form-control-sm">
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
@endsection
