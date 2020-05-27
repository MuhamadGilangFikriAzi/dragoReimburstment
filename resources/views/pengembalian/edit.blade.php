@extends('layouts.app')

@section('content')
<section class="content">
<div class="container-fluid">
    <form action="{{ route($urlUpdate, $data->id) }}" method="post" enctype="multipart/form-data">
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

					@csrf
                    @method('PUT')
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label>Nama</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="user" class="form-control" value="{{$data->user['name']}}" readonly>
                                    <input type="hidden" name="id_user" id="user" class="form-control" value="{{$data->id_user}}">
                                </div>
                                @if($errors->has('id_user'))
                                <span class="text-danger">{{ $errors->first('id_user') }}</span>
                                @endif
                            </div>

                            <div class="form-group origin" id="origin">
                                <label>Status</label>
                                <input type="text" name="status" class="form-control" value="{{ $data->status }}" readonly>
                                @if($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                @endif
                            </div>

                            <div class="form-group origin" id="origin">
                                <label>Asal Dana</label>
                                <input type="text" name="asal_dana" class="form-control" value="{{$data->asal_dana}}" readonly>
                            </div>

                            <div class="form-group">
                                <label>Dikembalikan</label>
                                <input type="number" name="total_dikembalikan" class="form-control text-right" id="kembali" readonly value="{{$data->total_dikembalikan}}">
                            </div>

                            <div class="form-group" id="bukti">
                                <div>
                                    @if ($data->tipe_pengembalian == 'transfer')
                                    <label>Bukti Transfer</label><br>
                                        <img src="{{ asset('img/bukti/'.$data->bukti) }}" alt="..." class="img-thumbnail"  data-toggle="modal" data-target="#exampleModal" style="width: 130px; height: 100px;">

                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="{{ asset('img/bukti/'.$data->bukti) }}" alt="..." class="img-thumbnail" style="width: 500px; height: 500px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="bukti_awal" value="{{$data->bukti}}">
                                        <input type="file" class="form-control image" name="bukti">
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" class="form-control" value="{{$data->tanggal}}" readonly>
                                @if($errors->has('tanggal'))
                                <span class="text-danger">{{ $errors->first('tanggal') }}</span>
                                @endif
                            </div>

                            <div class="form-group origin">
                                <label>Tipe Pengembalian</label>

                                @hasanyrole('Super Admin|Admin')
                                    <select name="tipe_pengembalian" class="custom-select" id="tipe_pengembalian">
                                        <option value="">Pilih...</option>
                                        @foreach ($tipePengembalian as $key => $value)
                                            <option value="{{$value}}" @if($value == $data->tipe_pengembalian) selected @endif >{{$value}}</option>
                                        @endforeach
                                    </select>
                                @endhasanyrole
                                @role('User')
                                    <input type="text" name="tipe_pengembalian" class="form-control" readonly value="{{ $data->tipe_pengembalian }}">
                                @endrole
                                @if($errors->has('tipe_pengemblian'))
                                <span class="text-danger">{{ $errors->first('asal_dana') }}</span>
                                @endif
                            </div>




                            <div class="form-group origin">
                                <label>Dana Diberikan</label>
                                <input type="number" class="form-control text-right" name="total_asal_dana" id="awal" value="{{$data->total_asal_dana}}" readonly>
                            </div>

                            <div class="form-group">
                                <label>Total</label>
                                <input type="number" name="total_digunakan" class="form-control text-right" id="total" readonly>
                            </div>
                        </div>
                    </div>

			</div>
        </div>
	</div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Detail Penggunaan Dana
                <div class="input-group input-group-sm float-right" style="width: 150px;">
                    <div class="input-group-btn pul">
                      <button type="submit" class="btn btn-default float-right" id="add_detail"><i class="fa fa-plus"></i>&nbsp;Tambah Detail</button>
                    </div>
                  </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Prihal</th>
                            <Th>Digunakan</Th>
                            <th>Bukti</th>
                            <th width="500px">Deskripsi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="append_detail">
                        @foreach ($data->detail as $key => $detail)
                        <tr class="row_detail">
                            <td><input type="text" class="form-control title" name="Detail[{{$key}}][prihal]" value="{{$detail->prihal}}"></td>
                            <td><input type="number" class="form-control text-right used" name="Detail[{{$key}}][digunakan]" value="{{$detail->digunakan}}"></td>
                            <td>
                                <img src="{{ asset('img/bukti/'.$detail->foto) }}" alt="..." class="img-thumbnail"  data-toggle="modal" data-target="#exampleModal" style="width: 130px; height: 100px;">

								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <input type="hidden" name="Detail[{{$key}}][foto_awal]" value="{{$detail->foto}}">
                                <input type="file" class="form-control image" name="Detail[{{$key}}][foto]">
                            </td>
                            <td><textarea class="form-control description" name="Detail[{{$key}}][deskripsi]" rows="1">{{$detail->deskripsi}}</textarea></td>
                            <td width="25px"><button class="btn btn-xs btn-danger btn-remove btn-flat"><i class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <span class="help-block" style="color: red;"> {!! $errors->first('Detail.*.prihal') !!} </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <span class="help-block" style="color: red;"> {!! $errors->first('Detail.*.digunakan') !!} </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <span class="help-block" style="color: red;"> {!! $errors->first('Detail.*.foto') !!} </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <span class="help-block" style="color: red;"> {!! $errors->first('Detail.*.deskripsi') !!} </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="number" class="form-control" name="sum" id="sum" readonly></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="text-right">
                    <input class="btn btn-primary" type="submit" name="submit" value="Simpan">
                </div>
            </div>

        </div>

    </div>
</form>

</div>
</div>
</section>


<script type="text/javascript">

      $(document).ready(function() {
        var i = 0;
        count();

        $('#tipe_pengembalian').on('change', function(){
            type = $(this).children("option:selected").val();
            if(type == 'transfer'){
                $('#bukti').append('\
                    <div>\
                        <label>Bukti Transfer</label>\
                        <input type="file" class="form-control image" name="bukti">\
                    </div>\
                ');
            }else{
                $('#bukti').children().remove();
            }

        });

        $('#awal').on('change',function() {
            count();
        });

        $('#append_detail').on('change', '.used',function() {
            count();
        });

        $('#append_detail').on('click', '.btn-remove', function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
            count();
        });

        $('#add_detail').click(function(e){
          e.preventDefault();

          $('#append_detail').append(
            '<tr class="row_detail">\
              <td><input type="text" class="form-control text-right title" name="Detail['+i+'][prihal]"></td>\
              <td><input type="number" class="form-control used text-right" name="Detail['+i+'][digunakan]"></td>\
              <td><input type="file" class="form-control image" name="Detail['+i+'][foto]"></td>\
              <td><textarea class="form-control description" name="Detail['+i+'][deskripsi]" rows="1"></textarea></td>\
              <td width="25px"><button class="btn btn-xs btn-danger btn-remove btn-flat"><i class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></button></td>\
            </tr>'
          );
            i++;

            $('#append_detail').on('click', '.btn-remove', function(e){
                e.preventDefault();
                $(this).parent().parent().remove();
                count();
            });

            $('#append_detail').on('change', '.used',function() {
                count();

            });

        });
      });

function count(){
    sum = 0;
    $('.used').each(function(){
        sum = sum+Number($(this).val());
    });

    awal = $('#awal').val();
    digunakan = awal - sum;

    $('#kembali').val(digunakan);
    $('#sum').val(sum);
    $('#total').val(sum);
}
</script>
@endsection
