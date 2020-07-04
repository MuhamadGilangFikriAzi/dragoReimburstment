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
@php
    function format($n)
    {
        return number_format($n,0,',','.');
    }
@endphp
<section class="content">
	<div class="container-fluid">

        @hasanyrole('Super Admin|Admin')
            <div class="row mt-4">
                <div class="col-sm-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header text-center">
                            Total Reimburstment Diajukan
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
										<h6>Total:<b> Rp. {{ format($totalDiterima->sum('total')) }}</b></h6><hr>
										<a href="{{ route('reimburstment.index')}}"><i>Lihat Rincian</i></a>
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
										<h6 class="title my-2">TOTAL REIMBURSEMENT DITERIMA PADA BULAN INI</h6>
										<h3 class="text-center"><b>{{ count($bulanIni->get()) }}</b></h3>
										<h6>Total:<b> Rp. {{ format($bulanIni->sum('total')) }}</b></h6><hr>
										<a href="{{route('reimburstment.index',['bulan' => date('m')])}}"><i>Lihat Rincian</i></a>
								</div>
							</div>
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
										<h6 class=" title my-2">TOTAL DANA DIBERIKAN</h6>
										<h6>Total:<b> Rp. {{ format($total_asal_dana) }}</b></h6><hr>
										<a href="{{ route('pengembalian.index')}}"><i>Lihat Rincian</i></a>
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
                                        <h6 class="title my-2">TOTAL DANA DIKEMBALIAN</h6>
                                        <h6>Total:<b> Rp. {{ format($total_dikembalikan) }}</b></h6><hr>
										<a href="{{route('pengembalian.index')}}"><i>Lihat Rincian</i></a>
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
               				 <h3 class="card-title">list 5 reimburstment terakhir</h3>
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
                                        <td class="text-right">Total</td>
                                    </tr>

                                    @foreach($limit as $key => $value)
                                    @php
                                        if($value->status == 'Diajukan'){
                                            $badge = 'badge-info';
                                        }
                                        elseif($value->status == 'Diterima'){
                                            $badge = 'badge-success';
                                        }
                                        else{
                                            $badge = 'badge-danger';
                                        }
                                    @endphp
                                     <tr>
                                        <td>{{ $key +1 }}</td>
                                        <td>{{ $value->user['name'] }}</td>
                                        <td>{{$value->tipe_pengembalian}}</td>
                                        <td>{{$value->asal_dana}}</td>
                                        <td>{{ $value->tanggal }}</td>
                                        <td>
                                            <span class="badge badge-pill {{$badge}}">{{$value->status}}</span>
                                        </td>
                                        <td class="text-right">{{ number_format($value->total,0,",",".") }}</td>
                                     </tr>
                                    @endforeach
                                </table>
				            </div>
						</div>
              		</div>
            	</div>
            </div>
            @endhasanyrole

            @hasanyrole('Super Admin|User')
            <div class="row">
                <div class="col-sm-12">
                  <div class="card">
                        <div class="card-header">
                              <h3 class="card-title">list reimburstment {{ Auth::user()->name }}</h3>
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
                                      <td class="text-right">Total</td>
                                  </tr>

                                  @foreach($user as $key => $value)
                                  @php
                                      if($value->status == 'Diajukan'){
                                          $badge = 'badge-info';
                                      }
                                      elseif($value->status == 'Diterima'){
                                          $badge = 'badge-success';
                                      }
                                      else{
                                          $badge = 'badge-danger';
                                      }
                                  @endphp
                                   <tr>
                                      <td>{{ $key +1 }}</td>
                                      <td>{{ $value->user['name'] }}</td>
                                      <td>{{$value->tipe_pengembalian}}</td>
                                      <td>{{$value->asal_dana}}</td>
                                      <td>{{ $value->tanggal }}</td>
                                      <td>
                                          <span class="badge badge-pill {{$badge}}">{{$value->status}}</span>
                                      </td>
                                      <td class="text-right">{{ number_format($value->total,0,",",".") }}</td>
                                   </tr>
                                  @endforeach
                              </table>
                          </div>
                      </div>
                    </div>
              </div>
          </div>
          @endhasanyrole


	</section>

@endsection
