@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header text-left"><b>Trash Schedule</b></div>
			<div class="card">
				<div class="text-left mx-4 my-2">
					<a href="{{ route('schedule_restore_all')}}">
						<button type="button" class="btn btn-outline-dark">Restore All Data</button>
					</a>
					<a href="{{ route('schedule_delete_all')}}">
						<button type="button" class="btn btn-outline-dark">Delete All Data</button>
					</a>		
				</div>
				<div class="card-body text-center">
					<form>
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th><b>No</b></th>
										<th><b>Clien</b></th>
										<th><b>Date</b></th>
										<th><b>Time</b></th>
										<th><b>Agenda</b></th>
										<th><b>Participant</b></th>
										<th><b>Action</b></th>
									</tr>
								</thead>
								<tbody>
									@foreach($data as $key => $a)
										<tr>
											<td><b>{{ $key+1 }}</b></td>
											<td>{{ $a->klien }}</td>
											<td>{{ $a->date }}</td>
											<td>{{ $a->time }}</td>
											<td>{{ $a->agenda }}</td>
											<td>{{ $a->participant }}</td>
											<td>
												<div>
													<a href="{{ url('/schedule/trash/restore/'.$a->id.'') }}">
														<button type="button" class="btn btn-danger">Restore</button>
													</a>
													<a href="{{ url('/schedule/trash/delete/'.$a->id.'') }}">
														<button type="button" class="btn btn-info">Delete</button>
													</a>
												</div>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection