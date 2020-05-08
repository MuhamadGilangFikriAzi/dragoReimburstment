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
                    <a href="{{ route($urlIndex) }}" class="btn-link" ><i class="fas fa-arrow-left"></i>&nbsp;Kembali</a>
                </div>
			</div>

			<div class="card-body">
				@if (session('status'))
				<div class="alert alert-success" role="alert">
					{{ session('status') }}
				</div>
				@endif

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="" class="form-control" readonly value="{{$data->user['name']}}" >
                            </div>
                            <div class="form-group">
                                <label>Asal Dana</label>
                                <input type="text" name="" class="form-control" readonly value="{{$data->asal_dana}}" >
                            </div>

                            <div class="form-group">
                                <label>Dikembalikan</label>
                            <input type="number" name="total_dikembalikan" class="form-control text-right" id="kembali" readonly value="{{$data->total_dikembalikan}}">
                            </div>
                        </div>

                        <div class="col">
                          <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" readonly class="form-control" value="{{$data->tanggal}}">
                        </div>

                        <div class="form-group origin">
                            <label>Awal Dana</label>
                            <input type="number" class="form-control text-right" name="total_asal_dana" id="awal" value="{{$data->total_asal_dana}}" readonly>
                            </div>

                          <div class="form-group">
                              <label>Digunakan</label>
                                <input type="number" name="total_digunakan" class="form-control text-right" id="total" value="{{$data->total_digunakan}}" readonly>
                          </div>
                    </div>
                </div>
			</div>
        </div>
	</div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Detail Reimburstment
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Prihal</th>
                            <Th class="text-right">Total</Th>
                            <th>Bukti</th>
                            <th width="500px">Deskripsi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="append_detail">
                        @foreach ($data->detail as $key => $detail)
                        <tr class="row_detail">
                            <td><input type="text" class="form-control title" name="Detail[{{$key}}][prihal]" value="{{$detail->prihal}}" readonly></td>
                            <td><input type="number" class="form-control text-right used" name="Detail[{{$key}}][digunakan]" value="{{$detail->digunakan}}" readonly></td>
                            <td>
                                <img src="{{ asset('img/bukti/'.$detail->foto) }}" alt="..." class="img-thumbnail"  data-toggle="modal" data-target="#exampleModal{{$key}}" style="width: 130px; height: 100px;">

                                <div class="modal fade" id="exampleModal{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
												</div>
												<div class="modal-body">
													<img src="{{ asset('img/bukti/'.$detail->foto) }}" alt="..." class="img-thumbnail" style="width: 500px; height: 500px;">
												</div>
											</div>
										</div>
									</div>
                                </div>
                            </td>
                            <td><textarea class="form-control description" name="Detail[{{$key}}][deskripsi]" rows="3" readonly>{{$detail->deskripsi}}</textarea></td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
                <div class="float-right btn-group">
                    @if ($data->status == 'Diajukan')
                        <form action="{{route($urlTolak,$data->id)}}" method="POST" >
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger" title="Tolak Pengembalian dana">Tolak</button>
                        </form>
                        <form action="{{route($urlTerima,$data->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success ml-1" title="Terima Pengembalian dana">Terima</button>
                        </form>
                        {{-- <a href="{{ route($urlTolak,$data->id) }}" class="btn btn-danger">Tolak</a>
                        <a href="{{ route($urlTerima,$data->id) }}" class="btn btn-success" >Terima</a> --}}
                    @endif
                </div>
            </div>

        </div>

    </div>
</form>

</div>
</div>
</section>
@endsection