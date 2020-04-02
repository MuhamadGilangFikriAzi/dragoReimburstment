@extends('layouts.app')

@section('content') 
	<div class="row justify-content-center">
        <div class="col-md-12">
	        <div class="card">
	        	<div class="card-header">
	        		<b>Trash Reimbursement</b>
	        	</div>
	            <div class="card">
	                <div class="card-body">
	                    @if (session('status'))
	                    <div class="alert alert-success" role="alert">
	                        {{ session('status') }}
	                    </div>
	                    @endif

	                    <div class="row">
	                        <div class="col">
	                            <a href="{{ route('restore_all') }}" class="btn btn-outline-dark">Restore All</a>  
	                            <a href="{{ route('delete_all') }}" class="btn btn-outline-dark">Remove All Permanent</a>
	                        </div>
		                    </div>
			                   	
			                <div class="table-responsive">   	
			                    <table class="table table-striped ">
			                        <thead>
			                            <tr>
			                                <th><b>No</b></th>
											<th><b>Title</b></th>
											<th><b>Name</b></th>
											<th><b>Date</b></th>
											<th><b>Total</b></th>
											<th><b>Description</b></th>
											<th><b>Image</b></th>
											<th><b>Action</b></th>
			                            </tr>
			                        </thead>
			                        <tbody>
			        
			                           <?php
										$no = 1;
										{?>
					
										@foreach( $trash as $l )
										<tr>
											<td><b><?php echo $no++; ?></b></td>
											<td>{{ $l->title}}</td>
											<td>{{ $l->user['name']}}</td>
											<td>{{ $l->date}}</td>
											<td>{{ number_format($l->total,2,",",".") }}</td>
											<td>{{ $l->description}}</td>
											<td>
												<img src="{{ asset('img/reimburstment/'.$l->proof) }}" alt="..." class="img-thumbnail" style="width: 130px; height: 100px;">
											</td>
											<td>
												<div>
													<a href="{{ url('/reimbursement/trash/restore/'.$l->id.'')}}">
														<button type="button" class="btn btn-danger">Restore</button>
													</a>
													<a href="{{ url('/reimbursement/trash/delete/'.$l->id.'')}}"> 
														<button type="button" class="btn btn-info">Delete</button>
													</a>
												</div>
											</td>
										</tr>
										@endforeach

										<?php } ?>

									</tbody>
			                    </table>
			               </div>
	                        <div class="col my-3" style="color: grey; font-family: sans-serif;">
	                            Total Trash: {{ $data }}
	                        </div>
					</div>
	            </div>
        	</div>
        </div>
    </div>
 @endsection