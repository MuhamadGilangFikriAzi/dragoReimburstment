@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header"><b>List reimbursement in this month</b></div>
			<div class="card-body">
				<div class="table-responsive">
					<form action="{{route('total')}}" method="get">
						<table  class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>No</th>
										<th>Title</th>
										<th>Name</th>
										<th>Date</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									{?>
									@foreach( $month as $l )
									<tr>
										<td><b><?php echo $no++; ?></b></td>
										<td>{{ $l->title}}</td>
										<td>{{ $l->user['name']}}</td>
										<td>{{ date('d-M-y', strtotime($l->date)) }}</td>
										<td>{{number_format($l->total,2,",",".")}}</td>
									</tr>
									@endforeach
									<?php } ?>
									<tr>
										<td colspan="4">Total :</td>
										<td><b>Rp. {{number_format($sum,2,",",".")}}</b></td>
									</tr>
								</tbody>
						</table>
					</form>
				</div>
			</div>			
		</div>
	</div>
</div>
@endsection