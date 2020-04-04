@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
                <b>Add Reimburst</b>
			</div>

			<div class="card-body">
				@if (session('status'))
				<div class="alert alert-success" role="alert">
					{{ session('status') }}
				</div>
				@endif
				<form action="{{ route('store') }}" method="post" enctype="multipart/form-data">
					@csrf

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label>Name</label>
                                <div class="input-group mb-3">
                                    <select name="user_id" class="custom-select" id="inputGroupSelect01">
                                        <option selected>Choose...</option>
                                        @foreach( $data as $key => $value )
                                        <option value="{{ $value->id }}" @if(Auth::user()->id == $value->id) selected @endif>{{ $value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if($errors->has('user_id'))
                                <span class="text-danger">{{ $errors->first('user_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label>Date</label>
                            <input type="date" class="form-control" name="date" class="form-control">
                            @if($errors->has('date'))
                            <span class="text-danger">{{ $errors->first('date') }}</span>
                            @endif
                          </div>
                          <div>
                              <label>Total</label>
                              <input type="number" name="total" class="form-control" id="total" readonly>
                          </div>
                        </div>
                    </div>

			</div>
        </div>

        <div class="card">
            <div class="card-header">
                Detail Reimburst
                <div class="input-group input-group-sm float-right" style="width: 150px;">
                    <div class="input-group-btn pul">
                      <button type="submit" class="btn btn-default float-right" id="add_detail"><i class="fa fa-plus"></i>&nbsp;Tambah Baris</button>
                    </div>
                  </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <Th>Total</Th>
                            <th>Image</th>
                            <th width="500px">Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="append_detail">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td><input type="number" class="form-control" name="sum" id="sum" readonly></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="text-right">
                    <input class="btn btn-dark" type="reset" name="reset" value="reset">
                    <input class="btn btn-primary" type="submit" name="submit" value="submit">
                </div>
            </div>
        </div>
    </div>
    </form>
</div>


<script type="text/javascript">

      $(document).ready(function() {
        var i = 1;

        $('#add_detail').click(function(e){
          e.preventDefault();

          $('#append_detail').append(
            '<tr class="row_detail">\
              <td><input type="text" class="form-control text-right title" name="Detail['+i+'][title]"></td>\
              <td><input type="number" class="form-control used" name="Detail['+i+'][used]"></td>\
              <td><input type="file" class="form-control image" name="Detail['+i+'][image]"></td>\
              <td><textarea class="form-control description" name="Detail['+i+'][desccription]" rows="3"></textarea></td>\
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
    console.log('masuk');
    sum = 0;
    $('.used').each(function(){
        sum = sum+Number($(this).val());
    });

    $('#sum').val(sum);
    $('#total').val(sum);
}
</script>
@endsection
