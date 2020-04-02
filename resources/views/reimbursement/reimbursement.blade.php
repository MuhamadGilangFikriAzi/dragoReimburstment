@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header text-left"><b>Reimbursement</b></div>

			<div class="text-right mx-4 my-2">
				<a href="{{ route('trash')}}">
					<button type="button" class="btn btn-outline-dark">Trash</button>
				</a>
				<a href="{{ route('create')}}">
					<button type="button" class="btn btn-outline-dark">Add Reinmbursement</button>
				</a>		
			</div>
			<div class="card-body text-center">
				<div class="table-responsive ">
					<table class="table table-striped">
						<thead>
							<tr>
								<th><b>No</b></th>
								<th><b>Title</b></th>
								<th><b>Name</b></th>
								<th><b>Date</b></th>
								<th><b>Total</b></th>
								<th><b>Action</b></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
								<td>
									<input type="text" name="title" class="form-control">
								</td>
								<td>
									<input type="text" name="staff" class="form-control">
								</td>
								<td>
									<input type="date" name="date" class="form-control">		
								</td>
								<td></td>
								<td>
									<input type="submit" value="Search" name="submit" class="btn btn-outline-dark">
								</td>
							</tr>
							@foreach( $list as $key => $l )
							<tr>
								<td><b>{{ $key +1 }}</b></td>
								<td>{{ $l->title }}</td>
								<td>{{ $l->user['name'] }}</td>
								<td>{{ date('d-m-Y', strtotime($l->date)) }}</td>
								<td>{{number_format($l->total,2,",",".")}}</td>
								<td>
						 			<div>	
										<a href="{{ url('/reimbursement/show/'.$l->id.'') }} ">
											<button class="btn btn-danger">Show</button>
										</a>
										<a href="{{ url('/reimbursement/edit/'.$l->id.'') }}">
											<button class="btn btn-success">Edit</button>
										</a>
										<a href="{{ url('/reimbursement/destroy/'.$l->id.'') }}"> 
											<button  class="btn btn-info">Delete</button>
										</a>
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
@endsection