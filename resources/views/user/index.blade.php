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
            @elseif($message = Session::get('danger'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
            @endif
            <div class="card">
                <div class="card-header text-left"><b>{{$pageTitle}}</b></div>

                <div class="text-right mx-4 my-2">
                    {{-- <a href="{{ route('trash')}}">
                        <button type="button" class="btn btn-outline-dark">Trash</button>
                    </a> --}}
                    {{-- <a href="{{ route('user.trash') }}" class="btn btn-sm btn-link">Trash</a> --}}
                    <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#add_user"><i class="fas fa-plus"></i>&nbsp;Tambah user</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-striped table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <td><b>No</b></td>
                                    <td><b>Nama</b></td>
                                    <td><b>Email</b></td>
                                    <td><b>Role</b></td>
                                    <td><b>Action</b></td>
                                </tr>
                            </thead>
                            <tbody class="table-sm">
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="text" name="name" class="form-control form-control-sm">
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <a href="{{route($urlIndex)}}" class="btn btn-sm btn-outline-dark mr-2">Reset</a>
                                        <input type="submit" value="Search" name="submit" class="btn btn-sm btn-outline-dark">
                                    </td>
                                </tr>
                                @forelse($data as $key => $value)
                                <tr>
                                    <td><b>{{ $key+1 }}</b></td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td></td>
                                    <td>
                                        <div>
                                        <a href="{{ route($urlShow, $value->id)}}" class="btn btn-link btn-sm" data-toggle="tooltip" title="lihat detail">View</a>
                                        <a href="{{ route($urlEdit, $value->id)}}" class="btn btn-link btn-sm" data-toggle="tooltip" title="Ubah data">Edit</a>
                                        <a href="{{ route($urlDelete,$value->id)}}" class="btn btn-link btn-sm text-danger" data-toggle="tooltip" title="Hapus data">Delete</a>
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
                                        {{ $data->links() }}
                                    </td>
                                    <td colspan="1" style="color: grey; font-family: sans-serif;">
                                        Total entries {{ $count }}
                                    </td>
                                </tfoot>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Tambah User</h4>
                <button type="button" class="close text-right" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route($urlStore)}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" >
                    </div>
                    @if($errors->has('nama'))
                        <span class="text-danger">{{ $errors->first('nama') }}</span>
                    @endif

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Email</label>
                        <input type="email" name="email" class="form-control" >
                    </div>
                    @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info pull-right btn-save">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

    </section>

    {{-- <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-left"><b>List User</b></div>
                <div class="card-body">
                    <div class="text-left">
                        <div class="">
                            <a href="{{ route('user.trash') }}" class="btn btn-outline-dark">Trash</a>
                            <a href="{{ route('user.store') }}" class="btn btn-outline-dark">Add Data</a>
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
    </div> --}}
@endsection
