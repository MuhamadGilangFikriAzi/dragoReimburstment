@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header"><b>Edit Data</b></div>
			<div class="card-body">
			    @if (session('status'))
			        <div class="alert alert-success" role="alert">
		        	{{ session('status') }}
			        </div>
			    @endif
				<form action="{{url('/reimbursement/edit/update/'.$id->id.'')}}" method="post" enctype="multipart/form-data">
				@csrf
					<div class="form-group">
						<label>Title</label>
						<input type="text" name="title" placeholder="Insert Title Here" class="form-control" value="{{ $id->title}}">
					</div>
					<div class="form-group">
						<label>Name</label>
						<div class="input-group mb-3">
							<select name="user_id" class="custom-select" id="inputGroupSelect01">
								<option value="{{ $id->user_id }}" selected>{{ $id->user['name']}}</option>
								@foreach( $data as $key => $a )
								<option value="{{ $a->id }}">{{ $a->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label>Date</label>
						<textarea class="form-control" name="date" rows="3">{{ $id->date}}</textarea>
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea class="form-control" name="description" rows="3">{{ $id->description}}</textarea>
					</div>
					<div class="form-group">
						<label>Total</label>
						<input type="text" name="total" class="form-control" placeholder="Total" value="{{ $id->total }}">
					</div>
					<div class="form-group">
						<label>Proof</label>
						<img src="{{ asset('img/proof/'.$id->proof) }}" alt="..." class="img-thumbnail"  data-toggle="
							modal" data-target="#exampleModal" style="width: 130px; height: 100px;">
								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<img src="{{ asset('img/proof/'.$id->proof) }}" alt="..." class="img-thumbnail" style="width: 500px; height: 500px;">
											</div>
										</div>
									</div>
								</div>
						<input type="file" name="proof"><br>
					</div>
					<div class="float-right">
						<input class="btn btn-primary" type="submit" value="Save Change">
						<input class="btn btn-dark" type="reset" name="reset" value="Reset">
					</div>
				</form>
			</div>
		</div>		
	</div>
</div>
@endsection