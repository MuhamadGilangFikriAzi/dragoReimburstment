@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header text-left"><b>Show Schedule</b></div>
			<div class="card">
				<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped">
									<tr>
										<td>Klien</td>
										<td>{{ $id->klien }}</td>
									</tr>
									<tr>
										<td>Date</td>
										<td>{{ date('d-M-y', strtotime($id->date)) }}</td>
									</tr>
									<tr>
										<td>Time</td>
										<td>{{ $id->time }}</td>
									</tr>
									<tr>
										<td>Agenda</td>
										<td>{{ $id->agenda }}</td>
									</tr>
									<tr>
										<td>Participant</td>
										<td>{{ $id->participant }}</td>
									</tr>
							</table>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
