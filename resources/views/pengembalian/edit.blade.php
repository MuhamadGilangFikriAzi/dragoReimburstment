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
                                    <select name="user_id" class="custom-select" id="user">
                                        <option selected>Pilih...</option>
                                        @foreach( $user as $key => $value )
                                        <option value="{{ $key }}" @if($key == $data->id_user) selected @endif>{{ $value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if($errors->has('user_id'))
                                <span class="text-danger">{{ $errors->first('user_id') }}</span>
                                @endif
                            </div>

                            <div class="form-group origin" id="origin">
                                <label>Asal Dana</label>
                                <select name="asal_dana" class="custom-select" id="origin_funds">
                                    <option value="">Pilih...</option>
                                    @foreach ($asalDana as $value)
                                        <option value="{{$value}}" @if($value == $data->asal_dana) selected @endif >{{$value}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('asal_dana'))
                                <span class="text-danger">{{ $errors->first('asal_dana') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Dikembalikan</label>
                            <input type="number" name="total_dikembalikan" class="form-control text-right" id="kembali" readonly value="{{$data->total_dikembalikan}}">
                            </div>
                        </div>

                        <div class="col">
                          <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" class="form-control" value="{{$data->tanggal}}">
                            @if($errors->has('tanggal'))
                            <span class="text-danger">{{ $errors->first('tanggal') }}</span>
                            @endif
                          </div>

                          <div class="form-group origin">
                            <label>Awal Dana</label>
                            <input type="number" class="form-control text-right" name="total_asal_dana" id="awal" value="{{$data->total_asal_dana}}">
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
                Detail Pengembalian
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
                    <input class="btn btn-dark" type="reset" name="reset" value="reset">
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

            $( "#append_detail" ).on('change','.description', function() {
                row = $(this);
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
