@extends('layouts.app')

@section('content')
<div class="row justify-content">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header text-left"><b>Reimbursement</b></div>
			<div class="card">
				<div class="card-header text-left mx-4 my-4"><b>Pencarian</b>
					<form action="" method="get">
						<div class="input-group">
							<input type="text" name="title" placeholder="Search Title" style="width: 34%;" class="form-control mx-2">
							<input type="text" name="staff" placeholder="Search By Name" style="width: 32%">
							<input type="date" name="date" style="width: 30%" class="form-control mx-2">							
						</div>
						<div class="text-right my-2 mx-2">
							<input type="submit" value="Search" name="submit" class="btn btn-dark">
						</div>
					</form>
				
					<div class="card-body text-center">
						<form>
							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th><b>No</b></th>
											<th><b>Title</b></th>
											<th><b>Name</b></th>
											<th><b>Date</b></th>
											<th><b>Description</b></th>
											<th><b>Total</b></th>
											<th><b>Images</b></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										{ ?>
											<tr>
												<td></td>
												<td></td>
											</tr>
											@foreach( $all as $l )
											<tr>
												<td><b><?php echo $no++; ?></b></td>
												<td>{{ $l->title}}</td>
												<td>{{ $l->user['name'] }}</td>
												<td>{{ date('d-M-y', strtotime($l->date)) }}</td>
												<td>{{ $l->description}}</td>
												<td>{{number_format($l->total,2,",",".")}}</td>
												<td>
													<img src="{{ asset('img/proof/'.$l->proof) }}" alt="..." class="img-thumbnail"  data-toggle="modal" data-target="#exampleModal" style="width: 130px; height: 100px;">

													<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
														<div class="modal-dialog" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	<img src="{{ asset('img/proof/'.$l->proof) }}" alt="..." class="img-thumbnail" style="width: 500px; height: 500px;">
																</div>
															</div>
														</div>
													</div>
												</div>

											</td>
										</tr>

											@endforeach

										<?php } ?>

									</tbody>

								</table>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection