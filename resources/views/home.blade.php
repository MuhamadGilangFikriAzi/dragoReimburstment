@extends('layouts.app')

@section('content')
<style>
	/*Boxes*/
	.box > .icon 
	{
		background-color: ;
		text-align: center; 
		position: relative;
	}
	.box > .icon > .image 
	{
		position: relative;  
		margin: auto; 
		width: 75px; 
		height: 75px; 
		border: 8px solid white; 
		line-height: 75px; 
		border-radius: 50%; 
		background: #314a79; 
		vertical-align: middle; 
	}
	.box > .icon:hover > .image 
	{
		background: grey; 
	}
	.box > .icon > .image > i 
	{
		font-size: 36px !important;
		color: #fff !important;
	}
	.box > .icon:hover > .image > i
	{ 
		color: black !important; 
	}
	.box > .icon > .info 
	{
		margin-top: -20px; 
		background: rgba(0, 0, 0, 0.04); 
		border: 1px solid #e0e0e0; 
		padding: 10px 0 8px 0; 
	}
	.box > .icon:hover > .info
	{ 
		background: rgba(0, 0, 0, 0.04); 
		border-color: #e0e0e0; 
		color: grey;
	} 
</style>

<!-- content -->
	<div class="container">
		<div class="row">
				<div class="col-xs-12 col-sm-6 col-lg-6">
					<div class="card my-2">
						<div class="box">							
							<div class="icon">
								<div class="info">
										<h6 class=" title my-2">TOTAL REIMBURSEMENT</h6>
										<h3 class="text-center"><b>{{ $data }}</b></h3>
										<h6>Total:<b> Rp. {{ number_format($sumall,2,",",".") }}</b></h6><hr>
										<a href="{{ route('allreimburstement') }}"><i>View Details</i></a>
								</div>
							</div>
						</div>
					</div> 
				</div>
				<div class="col-xs-12 col-sm-6 col-lg-6">
					<div class="card my-2">
						<div class="box">							
							<div class="icon">
								<div class="image">
									<i class="fa fa-strikethrough" aria-hidden="true"></i>
								</div>
								<div class="info">
										<h6 class="title my-2">TOTAL REIMBURSEMENT IN THIS MONTH</h6>
										<h3 class="text-center"><b>{{ $countmonth }}</b></h3>
										<h6>Total:<b> Rp. {{ number_format($sum,2,",",".") }}</b></h6><hr>
										<a href="{{route('total')}}"><i>View Details</i></a>
								</div>
							</div>
						</div> 
					</div>
				</div>
		</div>
	</div>
			  <!-- Main content -->
    <section class="content">
      	<div class="container-fluid">
        	<div class="row">
          		<div class="col-md-6">
            		<div class="card">
              			<div class="card-header">
               				 <h3 class="card-title">list of the last 5 transactions</h3>
              			</div>
              	
              			<div class="card-body">
							<div class="table-responsive">
							   	<table class="table table-bordered table-striped">
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
						                      @foreach( $post as $key => $p )
						                      <tr>
						                        <td><b>{{ $key+1 }}</b></td>
						                        <td>{{ $p->title}}</td>
						                        <td>{{ $p->user['name']}}</td>
						                        <td>{{ $p->date}}</td>
						                        <td>{{number_format($p->total,2,",",".")}}</td>
						                      </tr>
						                      @endforeach
						                    </tbody>
					            </table>
				            </div>            
						</div>
              		</div>
            	</div>
			</div>
		</div>
	</section>

@endsection