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
<section class="content">
	<div class="container-fluid">

            <div class="row mt-4">
                <div class="col-sm-4">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-header text-center">
                            Total Reimburstment Ditolak
                        </div>
                        <div class="card-body text-center">
                        <h1 class="card-text"><b><h1>{{$ditolak}}</h1></b></h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header text-center">
                            Total Pengajuan Reimburstment
                        </div>
                        <div class="card-body text-center">
                        <h1 class="card-text"><b><h1>{{$diajukan}}</h1></b></h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header text-center">
                            Total Reimburstment Diterima
                        </div>
                        <div class="card-body text-center">
                        <h1 class="card-text"><b><h1>{{$diterima}}</h1></b></h1>
                        </div>
                      </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="card bg-light mb-3">
                        <div class="card-header text-center">
                            Total Petty Cash
                        </div>
                        <div class="card-body text-center">
                            <h1 class="card-text">Rp. {{number_format($pettyCash,0,",",".")}}</h1>
                        </div>
                      </div>
                </div>
            </div>

            <div class="row">
				<div class="col-sm-6">
					<div class="card my-2">
						<div class="box">
							<div class="icon">
                                <div class="image">
									<i class="fa fa-strikethrough" aria-hidden="true"></i>
								</div>
								<div class="info">
										<h6 class=" title my-2">TOTAL REIMBURSEMENT DITERIMA</h6>
										<h3 class="text-center"><b>{{ count($totalDiterima->get()) }}</b></h3>
										<h6>Total:<b> Rp. {{ number_format($totalDiterima->sum('total'),2,",",".") }}</b></h6><hr>
										<a href="{{ route('reimburstment.allreimburstement')}}"><i>View Details</i></a>
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
										<h6 class="title my-2">TOTAL REIMBURSEMENT PADA BULAN INI</h6>
										<h3 class="text-center"><b>{{ count($bulanIni->get()) }}</b></h3>
										<h6>Total:<b> Rp. {{ number_format($bulanIni->sum('total'),2,",",".") }}</b></h6><hr>
										<a href="{{route('total')}}"><i>View Details</i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
	        </div>

        	<div class="row">
          		<div class="col-sm-12">
            		<div class="card">
              			<div class="card-header">
               				 <h3 class="card-title">list 5 transaksi terkhir</h3>
              			</div>

              			<div class="card-body">
							<div class="table-responsive">
                                <table class="table table-hover">
                                    <tr>
                                        <td>#</td>
                                        <td>User</td>
                                        <td>Tipe pengembalian</td>
                                        <td>Asal dana</td>
                                        <td>Tanggal</td>
                                        <td>Status</td>
                                        <td class="text-right">Total asal dana</td>
                                        <td class="text-right">Total</td>
                                    </tr>

                                    @foreach($limit as $key => $value)
                                     <tr>
                                        <td>{{ $key +1 }}</td>
                                        <td>{{ $value->user['name'] }}</td>
                                        <td>{{$value->tipe_pengembalian}}</td>
                                        <td>{{$value->asal_dana}}</td>
                                        <td>{{ $value->tanggal }}</td>
                                        <td>{{$value->status}}</td>
                                        @if ($value->tipe_pengembalian == 'pengembalian')
                                            <td class="text-right">{{ number_format($value->total_asal_dana,0,",",".") }}</td>
                                        @else
                                            <td></td>
                                        @endif
                                        <td class="text-right">{{ number_format($value->total,0,",",".") }}</td>
                                     </tr>
                                    @endforeach
                                </table>
				            </div>
						</div>
              		</div>
            	</div>
			</div>
		</>
	</section>

@endsection
