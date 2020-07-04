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
                @hasanyrole('Super Admin|Admin')
                <button type="button" class="btn btn-link btn-sm float-right" data-toggle="modal" data-target="#add_role"><i class="fas fa-plus"></i>&nbsp;Pemberian dana</button>
                @endhasanyrole
			</div>
			<div class="card-body">
				<div class="table-responsive ">
					<table class="table table-striped table-sm">
						<thead class="thead-light">
							<tr>
								<th><b>No</b></th>
                                <th><b>Nama</b></th>
                                <th><b>Tanggal</b></th>
                                <th><b>Asal Dana</b></th>
                                <th><b>Status</b></th>
                                <th><b>Tipe Pengembalian Dana</b></th>
								<th class="text-right"><b>Pemberian Dana</b></th>
								<th class="text-center"><b>Action</b></th>
							</tr>
						</thead>
						<tbody class="table-sm">
                            <form action="#" method="get">
							<tr>
								<td></td>
								<td>
									<input type="text" name="nama" class="form-control form-control-sm" value="{{ Request::input('nama') }}">
                                </td>
								<td>
									<input type="date" name="tanggal" class="form-control form-control-sm" value="{{ Request::input('tanggal') }}">
                                </td>
                                <td></td>
								<td>
                                    <select name="status" id="" class="form-control form-control-sm">
                                        <option value="">Pilih status...</option>
                                        @foreach ($status as $value)
                                            <option @if($value == Request::input('status')) selected  @endif value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
								<td class="text-center">
                                    <div class="btn-group">
                                    <a href="{{route($urlIndex)}}" class="btn btn-sm btn-outline-dark mr-2">Reset</a>
                                    <input type="submit" value="Search" name="submit" class="btn btn-sm btn-outline-dark">
                                </div>
								</td>
                            </tr>
                        </form>
                            @forelse( $list as $key => $value )
                            @php
                                if($value->status == 'Diberikan'){
                                    $badge = 'badge-secondary';
                                }
                                elseif($value->status == 'Dikembalikan'){
                                    $badge = 'badge-info';
                                }else{
                                    $badge = 'badge-success';
                                }
                            @endphp
							<tr>
								<td><b>{{ $key +1 }}</b></td>
                                <td>{{ $value->user['name'] }}</td>
                                <td>{{ date('d-m-Y',strtotime($value->tanggal)) }}</td>
                                <td>{{ $value->asal_dana}}</td>
                                <td>
                                    <span class="badge badge-pill {{$badge}}">{{$value->status}}</span>
                                </td>
                                <td>{{ $value->tipe_pengembalian }}</td>
								<td class="text-right">{{number_format($value->total_asal_dana,0,",",".")}}</td>
								<td class="text-center">
						 			<div class="btn-group">
                                        <a href="{{ route($urlShow,$value->id)}}" class="btn btn-link btn-sm" data-toggle="tooltip" title="lihat Pengembalian dana"><i class="fas fa-eye"></i></a>
                                        @if ($value->tipe_pengembalian == 'transfer' && $value->status != 'Diterima')
                                            @hasanyrole('Super Admin|User')
                                                <a href="{{ route($urlEdit,$value->id)}}" class="btn btn-link btn-sm" data-toggle="tooltip" title="edit pengembalian dana"><i class="fas fa-edit"></i></a>
                                            @endhasanyrole
                                        @elseif($value->tipe_pengembalian == null)
                                            @hasanyrole('Super Admin|Admin')
                                                <a href="{{ route($urlEdit,$value->id)}}" class="btn btn-link btn-sm" data-toggle="tooltip" title="edit pengembalian dana"><i class="fas fa-edit"></i></a>
                                            @endhasanyrole
                                        @elseif($value->tipe_pengembalian == 'langsung' && $value->status != 'Diterima')
                                            @hasanyrole('Super Admin|Admin')
                                                <a href="{{ route($urlEdit,$value->id)}}" class="btn btn-link btn-sm" data-toggle="tooltip" title="edit pengembalian dana"><i class="fas fa-edit"></i></a>
                                            @endhasanyrole
                                        @endif
                                        @hasanyrole('Super Admin|Admin')
                                            <form action="{{route($urlDelete,$value->id)}}" method="POST" class="formDelete">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-link text-danger" title="Hapus pengembalian dana"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                        @endhasanyrole
                                        {{-- <a href="{{ route($urlDelete,$value->id)}}" class="btn btn-link btn-sm text-danger" data-toggle="tooltip" title="Hapus data">Hapus</a> --}}
									</div>
								</td>
                            </tr>
							@empty
                            <tr>
                                <td colspan="8" class="text-center"> Tidak Ada Pengembalian Dana</td>
                            </tr>
                            @endforelse
						</tbody>
						<tfoot>
                            <tr>
                                <td colspan="6">
                                    {{ $list->links() }}
                                </td>
                                <td style="color: grey; font-family: sans-serif;">
                                    Total entries {{ count($list) }}
                                </td>
                            </tr>
                            </tfoot>

					</table>

				</div>
			</div>
		</div>
	</div>
</div>
</div>

<div class="modal fade" id="add_role" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form pemberian</h4>
                <button type="button" class="close text-right" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route($urlStore)}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Nama</label>
                        <div class="input-group mb-3">
                            <select name="id_user" class="custom-select" id="user">
                                <option selected>Pilih...</option>
                                @foreach( $data as $key => $value )
                                <option value="{{ $value->id }}" @if(Auth::user()->id == $value->id) selected @endif>{{ $value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($errors->has('id_user'))
                        <span class="text-danger">{{ $errors->first('id_user') }}</span>
                        @endif
                    </div>

                    <div class="form-group origin" id="origin">
                        <label>Asal Dana</label>
                        <select name="asal_dana" class="custom-select" id="origin_funds">
                            <option value="">Pilih...</option>
                            @foreach (json_decode($asalDana->value) as $key => $value)
                                <option value="{{$value}}">{{$value}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('asal_dana'))
                        <span class="text-danger">{{ $errors->first('asal_dana') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" class="form-control">
                        @if($errors->has('tanggal'))
                            <span class="text-danger">{{ $errors->first('tanggal') }}</span>
                        @endif
                    </div>

                    <div class="form-group origin">
                        <label>Dana Diberikan</label>
                        <input type="number" class="form-control" name="total_asal_dana" id="awal">
                    </div>

                    <input type="hidden" name="status" value="Diberikan">
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
@endsection
