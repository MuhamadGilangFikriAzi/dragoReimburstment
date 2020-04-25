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
                                    <td><span class="badge badge-pill badge-secondary">{{$value->roles->first()->name}}</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#show{{$key}}">Lihat</button>
                                            <a href="{{ route($urlEdit, $value->id)}}" class="btn btn-link btn-sm" data-toggle="tooltip" title="Ubah data">Edit</a>
                                            <form action="{{route($urlDelete,$value->id)}}" method="POST" class="formDelete">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-link text-red">Hapus</button>
                                            </form>
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
                        <label for="recipient-name" class="col-form-label">Jenis kelamin</label>
                        <select name="jenis_kelamin" id="" class="form-control">
                            <option value="">...</option>
                            @foreach ($jenis_kelamin as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
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

                    <div class="form-group">
                        <label for="">Alamat</label>
                        <textarea name="alamat" id="" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">No Rekening</label>
                        <input type="number" name="no_rekening" class="form-control" >
                    </div>
                    @if($errors->has('no_rekening'))
                        <span class="text-danger">{{ $errors->first('no_rekening') }}</span>
                    @endif

                    <div class="form-group">
                        <label for="">Foto</label>
                        <input type="file" name="foto" id="" class="form-control">
                    </div>
                    @if($errors->has('foto'))
                        <span class="text-danger">{{ $errors->first('foto') }}</span>
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


@foreach ($data as $key => $value)
<div class="modal fade" id="show{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">lihat User </h4>
                <button type="button" class="close text-right" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{$value->name}}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Jenis kelamin</label>
                        <input type="text" name="" class="form-control" value="{{$value->jenis_kelamin}}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{$value->email}}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="">Alamat</label>
                        <textarea name="alamat" id="" class="form-control" readonly>{{$value->alamat}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">No Rekening</label>
                        <input type="number" name="no_rekening" class="form-control" value="{{$value->no_rekening}}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="">Foto</label>
                        <img src="{{ asset('img/user/'.$value->foto) }}" alt="..." class="img-thumbnail"  data-toggle="modal" data-target="#user{{$key}}" style="width: 130px; height: 100px;">

                                <div class="modal fade" id="user{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<img src="{{ asset('img/user/'.$value->foto) }}" alt="..." class="img-thumbnail" style="width: 500px; height: 500px;">
											</div>
										</div>
									</div>
								</div>
                    </div>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

@endforeach
</section>

@endsection
