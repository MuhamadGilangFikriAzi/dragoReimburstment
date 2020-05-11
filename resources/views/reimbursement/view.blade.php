@extends('layouts.app')

@section('content')
<section class="content">
<div class="container-fluid">
    <div class="row justify-content-center">

	<div class="col-md-12">
        @if($errors->has('asal_dana'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $errors->first('asal_dana') }}</strong>
            </div>
        @endif
        @if(\Session::has('alert-failed'))
                <div class="alert alert-failed">
                    <div>{{Session::get('alert-failed')}}</div>
                </div>
            @endif
            @if(\Session::has('alert-success'))
                <div class="alert alert-success">
                    <div>{{Session::get('alert-success')}}</div>
                </div>
            @endif
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
                                <label>Tipe Pengembalian</label>
                                <input type="text" name="" class="form-control" readonly value="{{$data->tipe_pengembalian}}" >
                            </div>
                            @if ($data->tipe_pengembalian == 'transfer')
                                <div class="form-group" id="no_rek">
                                    <label>No rekening</label>
                                    <input type="number" class="form-control" name="no_rek" pleaceholder="Masukan no rekening" value="{{$data->user['no_rekening']}}" readonly>
                                </div>
                            @endif


                            @if ($data->tipe_pengembalian == "pengembalian")
                                <div class="form-group">
                                    <label>Awal Dana</label>
                                    <input type="number" name="" class="form-control" id="" readonly value="{{$data->total_asal_dana}}">
                                </div>
                            @endif

                        </div>

                        <div class="col">
                          <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" readonly class="form-control" value="{{$data->tanggal}}">
                        </div>
                        @if ($data->tipe_pengembalian == 'transfer')
                            <div class="form-group">
                                <label>Bank</label>
                                <input type="text" class="form-control" name="tanggal" readonly class="form-control" value="{{$data->user['bank']}}">
                            </div>
                        @endif

                        <div class="form-group">
                            <label>Total</label>
                            <input type="number" name="total" class="form-control text-right" id="total" value="{{$data->total}}" readonly>
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
                <div class="btn-group float-right">
                    @if ($data->status == 'Diajukan')
                        <a href="{{route($urlSendEmail,$data->id)}}" class="btn btn-info"> Kirim Email</a>
                        <form action="{{route($urlTolak,$data->id)}}" method="POST" >
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger ml-1" title="Tolak Pengajuan Reimburstment">Tolak</button>
                        </form>
                        <button type="button" class="btn btn-success ml-1" data-toggle="modal" data-target="#exampleModalCenter" title="Terima reimburstment">
                            Terima
                        </button>


                        {{-- <a href="{{ route($urlTerima,$data->id) }}" class="btn btn-success" >Terima</a> --}}
                    @endif
                </div>
            </div>

        </div>

    </div>
</form>

</div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Terima Pengajuan Reimburstment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route($urlTerima,$data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Asal dana</label>
                        <select name="asal_dana" class="form-control">
                            <option value="">Pilih asal dana</option>
                            @if ($data->tipe_pengembalian == 'langsung')
                                @foreach (json_decode($langsung->value) as $key => $value)
                                    <option value="{{$value}}">{{$value}}</option>
                                @endforeach
                            @else
                                @foreach (json_decode($transfer->value) as $key => $value)
                                    <option value="{{$value}}">{{$value}}</option>
                                @endforeach
                            @endif
                        </select>

                    </div>
                    <div class="btn-group float-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">keluar</button>
                        <button type="submit" class="btn btn-primary ml-1">Terima</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
</section>
@endsection
