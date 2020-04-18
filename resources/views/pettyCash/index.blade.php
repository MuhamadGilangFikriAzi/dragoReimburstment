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
        @endif
		<div class="card">
            <div class="card-header text-left"><b>{{$pageTitle}}</b></div>

			<div class="text-right mx-4 my-2">
				{{-- <a href="{{ route('trash')}}">
					<button type="button" class="btn btn-outline-dark">Trash</button>
                </a> --}}
                <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#add_petty_cash"><i class="fas fa-plus"></i>&nbsp;Tambah Petty Cash</button>
                {{-- <a href="" class="btn btn-sm btn-link"><i class="fas fa-plus"></i>&nbsp;Add Petty Cash</a> --}}
			</div>
			<div class="card-body">
				<div class="table-responsive ">
					<table class="table table-striped table-sm">
						<thead class="thead-light">
							<tr>
								<th><b>No</b></th>
								<th><b>Nama</b></th>
								<th><b>Tanggal</b></th>
                                <th><b>Tipe</b></th>
                                <th><b>Deskripsi</b></th>
                                <th class="text-right"><b>Dana</b></th>
							</tr>
						</thead>
						<tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach($pettyCash as $key => $value)
							<tr>
                                <td><b>{{$key+1}}</b></td>
                                <td>{{$value->user['name']}}</td>
                                <td>{{$value->tanggal}}</td>
                                <td>{{$value->tipe}}</td>
                                <td>{{$value->deskripsi}}</td>
                                <td class="text-right">{{ number_format($value->total,0,',','.') }}</td>
							</tr>
							@endforeach
						</tbody>
						<tfoot>
                            <tr>
                                <td colspan="5"></td>
                                <td class="text-right">Jumlah : {{ number_format($sum,0,',','.') }}</td>
                            </tr>
                        <tr>
                            <td colspan="3" class="float-left">
                                {{ $pettyCash->links() }}
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

<div class="modal fade" id="add_petty_cash" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Tambah Petty Cash</h4>
                <button type="button" class="close text-right" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('pettyCash.store')}}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="tipe" value="masuk">
                    <input type="hidden" name="deskripsi" value="Add petty cash by {{ Auth::user()->name }}">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Total</label>
                        <input type="number" name="total" class="form-control" id="recipient-name">
                    </div>

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
