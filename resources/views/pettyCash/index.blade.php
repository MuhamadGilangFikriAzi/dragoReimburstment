@extends('layouts.app')

@section('content')
<section class="content">
<div class="container-fluid">
<div class="row justify-content-center">
	<div class="col-md-12">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
		<div class="card">
            <div class="card-header text-left"><b>{{$pageTitle}}</b></div>

			<div class="text-right mx-4 my-2">
				{{-- <a href="{{ route('trash')}}">
					<button type="button" class="btn btn-outline-dark">Trash</button>
                </a> --}}
                <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#add_petty_cash"><i class="fas fa-plus"></i>&nbsp;Add Petty Cash</button>
                {{-- <a href="" class="btn btn-sm btn-link"><i class="fas fa-plus"></i>&nbsp;Add Petty Cash</a> --}}
			</div>
			<div class="card-body text-center">
				<div class="table-responsive ">
					<table class="table table-striped table-sm">
						<thead class="thead-light">
							<tr>
								<th><b>No</b></th>
								<th><b>Name</b></th>
								<th><b>Date</b></th>
                                <th><b>Type</b></th>
                                <th><b>Description</b></th>
                                <th class="text-right"><b>Funds</b></th>
                                <th class="text-right"><b>Total</b></th>
							</tr>
						</thead>
						<tbody class="table-sm">
                            @php
                                $total = 0;
                            @endphp
                            @foreach($pettyCash as $key => $value)
							<tr>
                                <td><b>{{$key+1}}</b></td>
                                <td>{{$value->user['name']}}</td>
                                <td>{{$value->date}}</td>
                                <td>{{$value->type}}</td>
                                <td>{{$value->description}}</td>
                                <td class="text-right">{{ number_format($value->total,0,',','.') }}</td>
								<td class="text-right">
                                    @php
                                        if($value->type == 'in'){
                                            $total = $total+$value->total;
                                        }else{
                                            $total = $total-$value->total;
                                        }
                                    @endphp
                                    {{ number_format($total,0,',','.') }}
                                </td>
							</tr>
							@endforeach
						</tbody>
						<tfoot>
                            <td colspan="3" class="float-left">
                                {{ $pettyCash->links() }}
                            </td>
                        </tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<div class="modal fade" id="add_petty_cash" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Add Petty Cash</h4>
                <button type="button" class="close text-right" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('pettyCash.store')}}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="type" value="in">
                    <input type="hidden" name="description" value="Add petty cash by {{ Auth::user()->name }}">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Date</label>
                        <input type="date" name="date" class="form-control" id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Funds</label>
                        <input type="number" name="total" class="form-control" id="recipient-name">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info pull-right btn-save">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
