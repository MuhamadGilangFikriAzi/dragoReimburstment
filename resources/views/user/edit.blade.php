@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ $pageTitle }}</h5>
                    <div class="header-elements float-right">
                        <a href="{{ route($urlIndex) }}" class=" btn-link" ><i class="fas fa-arrow-left"></i>&nbsp;Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route($urlUpdate,$data->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ $data->name }}">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Jenis kelamin</label>
                            <select name="jenis_kelamin" id="" class="form-control">
                                <option value="">...</option>
                                @foreach ($jenis_kelamin as $key => $value)
                                    <option value="{{$key}}" @if($key == $data->jenis_kelamin) selected @endif>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($errors->has('nama'))
                            <span class="text-danger">{{ $errors->first('nama') }}</span>
                        @endif

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Email</label>
                            <input type="email" name="email" class="form-control"  value="{{$data->email}}">
                        </div>
                        @if($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif

                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea name="alamat" id="" class="form-control">{{$data->alamat}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Bank</label>
                            <input type="text" name="bank" class="form-control" value="{{ $data->bank }}">
                        </div>

                        <div class="form-group">
                            <label>No Rekening</label>
                            <input type="text" name="no_rekening" class="form-control" value="{{ $data->no_rekening }}">
                        </div>

                        <div class="form-group">
                            <label>Foto</label>
                            <img src="{{ asset('img/user/'.$data->foto) }}" alt="..." class="img-thumbnail"  data-toggle="modal" data-target="#user" style="width: 130px; height: 100px;">

                                <div class="modal fade" id="user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<img src="{{ asset('img/user/'.$data->foto) }}" alt="..." class="img-thumbnail" style="width: 500px; height: 500px;">
											</div>
										</div>
									</div>
								</div>
                            <input type="file" name="foto" class="form-control" >
                            <input type="hidden" name="foto_awal" value="{{$data->foto}}">
                        </div>
                        @role('Super Admin')
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role_id" class="form-control">
                            <option value="">-- Choose Role--</option>
                                @foreach($role as $key => $value)
                                    <option value="{{$key}}" @if($key == $thisRole) selected @endif >{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endrole
                        <div class="text-right">
                            <input class="btn btn-primary" type="submit"  name="submit" value="Save Change">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</section>
@endsection
