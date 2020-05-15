@extends('layouts.app')

@section('content')
<section class="content">
<div class="container-fluid">
    <form action="{{ route($urlStore) }}" method="post" enctype="multipart/form-data">
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

                    <div class="form-col">
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
                            <div class="text-right">
                                <input class="btn btn-dark" type="reset" name="reset" value="reset">
                                <input class="btn btn-primary" type="submit" name="submit" value="Simpan">
                            </div>

                    </div>

                </div>
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
        $('#awal').on('change',function() {
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
