@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header text-left"><b>Schedule</b></div>
			<div class="card">
				<div class="text-right mx-4 my-2">
					<a href="{{ route('schedule_trash')}}">
						<button type="button" class="btn btn-outline-dark">Trash</button>
					</a>
					<a href="{{ route('schedule_add')}}">
						<button type="button" class="btn btn-outline-dark">Add Schedule</button>
					</a>		
				</div>
				<div class="card-body text-center">
					<form>
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th><b>No</b></th>
										<th><b>Client</b></th>
										<th><b>Date</b></th>
										<th><b>Agenda</b></th>
										<th><b>Action</b></th>
									</tr>
								</thead>
								<tbody>
										<tr>
											<td></td>
											<td>
												<input type="text" name="client"  class="form-control">
											</td>
											<td>
												<input type="date" name="date"  class="form-control">
											</td>
											<td>
												<input type="text" name="agenda"  class="form-control">
											</td>
											<td>
												<input type="submit" value="Search" name="submit" class="btn btn-outline-dark">
											</td>
										</tr>
									@foreach($all as $key => $a)
										<tr>
											<td><b>{{ $key+1 }}</b></td>
											<td>{{ $a->klien }}</td>
											<td>{{ date('d-m-Y', strtotime($a->date)) }}</td>
											<td>{{ $a->agenda }}</td>
											<td>
												<div>

													<a href="{{ url('schedule/show/'.$a->id.'') }}">
														<button type="button" class="btn btn-danger">Show</button>
													</a>

													<a href="{{ url('/schedule/edit/'.$a->id.'') }}">
														<button type="button" class="btn btn-success">Edit</button>
													</a>

													<a href=" {{ url('/schedule/destroy/'.$a->id.'') }}"> 
														<button type="button" class="btn btn-info">Hapus</button>
													</a>

												</div>
											</td>
										</tr>
										@endforeach
									</tbody>
									<tfoot>
										<td>
											{{ $all->links() }}
										</td>
										<td colspan="3" class="text-right" style="color: grey; font-family: sans-serif;">
											Total Entries: {{ $data }}		
										</td>
									</tfoot>
							</table>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection