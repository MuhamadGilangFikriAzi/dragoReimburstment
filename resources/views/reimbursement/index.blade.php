@extends('layouts.app')

@section('content')
<section class="content">
<div class="container-fluid">
<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header text-left"><b>Reimbursement</b></div>

			<div class="text-right mx-4 my-2">
				{{-- <a href="{{ route('trash')}}">
					<button type="button" class="btn btn-outline-dark">Trash</button>
                </a> --}}
                <a href="{{ route('reimburstment.create') }}" class="btn btn-sm btn-link"><i class="fas fa-plus"></i>&nbsp;Add Reimburst</a>
			</div>
			<div class="card-body">
				<div class="table-responsive ">
					<table class="table table-striped table-sm">
						<thead class="thead-light">
							<tr>
								<th><b>No</b></th>
                                <th><b>Nama</b></th>
                                <th><b>Tipe pengembalian</b></th>
                                <th><b>Tanggal</b></th>
                                <th><b>Status</b></th>
								<th class="text-right"><b>Total</b></th>
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
                                    <select name="tipe_pengembalian" id="" class="form-control form-control-sm">
                                        <option value="">Pilih tipe...</option>
                                        @foreach ($tipe_pengembalian as $value)
                                            <option @if($value == Request::input('tipe_pengembalian')) selected @endif value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </td>
								<td>
									<input type="date" name="tanggal" class="form-control form-control-sm" value="{{ Request::input('tanggal') }}">
								</td>
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
                                    <a href="{{route('reimburstment')}}" class="btn btn-sm btn-outline-dark mr-2">Reset</a>
									<input type="submit" value="Search" name="submit" class="btn btn-sm btn-outline-dark">
								</td>
                            </tr>
                        </form>
                            @foreach( $list as $key => $value )
                            @php
                                if($value->status == 'Diajukan'){
                                    $badge = 'badge-info';
                                }
                                elseif($value->status == 'Diterima'){
                                    $badge = 'badge-success';
                                }
                                else{
                                    $badge = 'badge-warning';
                                }
                            @endphp
							<tr>
								<td><b>{{ $key +1 }}</b></td>
                                <td>{{ $value->user['name'] }}</td>
                                <td>{{ $value->tipe_pengembalian}}</td>
                                <td>{{ $value->tanggal }}</td>
                                <td>
                                    <span class="badge badge-pill {{$badge}}">{{$value->status}}</span>
                                </td>
								<td class="text-right">{{number_format($value->total,0,",",".")}}</td>
								<td class="text-center">
						 			<div>
                                        <a href="#" class="btn btn-xs btn-flat" data-toggle="collapse" data-target="#detailItem{{$key}}"><i class="fa fa-arrow-down"></i></a>
                                        <a href="{{ route('reimburstment.view',$value->id)}}" class="btn btn-link btn-sm" data-toggle="tooltip" title="lihat detail">View</a>
                                        <a href="{{ route('reimburstment.edit',$value->id)}}" class="btn btn-link btn-sm" data-toggle="tooltip" title="Ubah data">Edit</a>
                                        <a href="{{ route('reimburstment.delete',$value->id)}}" class="btn btn-link btn-sm text-danger" data-toggle="tooltip" title="Hapus data">Delete</a>

										{{-- <a href="{{ url('/reimbursement/show/'.$l->id.'') }} ">
											<button class="btn btn-danger">Show</button>
										</a>
										<a href="{{ url('/reimbursement/edit/'.$l->id.'') }}">
											<button class="btn btn-success">Edit</button>
										</a>
										<a href="{{ url('/reimbursement/destroy/'.$l->id.'') }}">
											<button  class="btn btn-info">Delete</button>
										</a> --}}
									</div>
								</td>
                            </tr>
                            <tr>
                                <td colspan="7" class="p-2">
                                  <div id="detailItem{{$key}}" class="collapse">
                                    <table class="table table-sm table-bordered">
                                        <tr>
                                            <td></th>
                                            <td>Prihal</td>
                                            <td>Digunakan</td>
                                            <td>Foto</td>
                                            <td>Deskripsi</td>
                                        </tr>
                                        @foreach($value->detail as $no => $detail)

                                        @endforeach
                                    </table>
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
                                    Total entries {{ $data }}
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
