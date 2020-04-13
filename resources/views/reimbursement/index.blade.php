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
			<div class="card-body text-center">
				<div class="table-responsive ">
					<table class="table table-striped table-sm">
						<thead class="thead-light">
							<tr>
								<th><b>No</b></th>
								<th><b>Title</b></th>
								<th><b>Name</b></th>
								<th><b>Date</b></th>
								<th><b>Total</b></th>
								<th><b>Action</b></th>
							</tr>
						</thead>
						<tbody class="table-sm">
							<tr>
								<td></td>
								<td>
									<input type="text" name="title" class="form-control form-control-sm">
								</td>
								<td>
									<input type="text" name="staff" class="form-control form-control-sm">
								</td>
								<td>
									<input type="date" name="date" class="form-control form-control-sm">
								</td>
								<td></td>
								<td>
                                    <a href="{{route('reimburstment')}}" class="btn btn-sm btn-outline-dark mr-2">Reset</a>
									<input type="submit" value="Search" name="submit" class="btn btn-sm btn-outline-dark">
								</td>
							</tr>
							@foreach( $list as $key => $value )
							<tr>
								<td><b>{{ $key +1 }}</b></td>
								<td>{{ $value->title }}</td>
								<td>{{ $value->user['name'] }}</td>
								<td>{{ date('d-m-Y', strtotime($value->date)) }}</td>
								<td>{{number_format($value->total,2,",",".")}}</td>
								<td>
						 			<div>
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
							@endforeach
						</tbody>
						<tfoot>
                                <td colspan="3">
                                    {{ $list->links() }}
                                </td>
                                <td colspan="1" style="color: grey; font-family: sans-serif;">
                                    Total entries {{ $data }}
                                </td>
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
