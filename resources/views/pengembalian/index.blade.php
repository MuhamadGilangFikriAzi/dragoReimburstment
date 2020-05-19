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
                <a href="{{ route($urlCreate) }}" class="btn btn-sm btn-link"><i class="fas fa-plus"></i>&nbsp;Pemberian Dana</a>
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
								<td class="text-center">
                                    <a href="{{route($urlIndex)}}" class="btn btn-sm btn-outline-dark mr-2">Reset</a>
									<input type="submit" value="Search" name="submit" class="btn btn-sm btn-outline-dark">
								</td>
                            </tr>
                        </form>
                            @foreach( $list as $key => $value )
                            @php
                                if($value->status == 'Diberikan'){
                                    $badge = 'badge-info';
                                }
                                else{
                                    $badge = 'badge-success';
                                }
                            @endphp
							<tr>
								<td><b>{{ $key +1 }}</b></td>
                                <td>{{ $value->user['name'] }}</td>
                                <td>{{ $value->tanggal }}</td>
                                <td>{{ $value->asal_dana}}</td>

                                <td>
                                    <span class="badge badge-pill {{$badge}}">{{$value->status}}</span>
                                </td>
								<td class="text-right">{{number_format($value->total_asal_dana,0,",",".")}}</td>
								<td class="text-center">
						 			<div class="btn-group">
                                        @hasanyrole('Super Admin|User')
                                        <a href="{{ route($urlShow,$value->id)}}" class="btn btn-link btn-sm" data-toggle="tooltip" title="lihat Pengembalian dana"><i class="fas fa-eye"></i></a>
                                        @endhasanyrole
                                        @hasanyrole('Super Admin|Admin')
                                            <a href="{{ route($urlEdit,$value->id)}}" class="btn btn-link btn-sm" data-toggle="tooltip" title="edit pengembalian dana"><i class="fas fa-edit"></i></a>
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
							@endforeach
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
</section>
@endsection
