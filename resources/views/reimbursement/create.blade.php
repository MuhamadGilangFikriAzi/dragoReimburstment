@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header"><b>Add Data</b>
			</div>

			<div class="card-body">
				@if (session('status'))
				<div class="alert alert-success" role="alert">
					{{ session('status') }}
				</div>
				@endif
				<form action="{{ route('store') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>Title</label>
						<input type="text" name="title" placeholder="Insert Title Here" class="form-control" value="{{old('title')}}">
						@if($errors->has('title'))
						<span class="text-danger">{{ $errors->first('title') }}</span>
						@endif
					</div>
					<div class="form-group">
						<label>Nama</label>
						<!-- <input type="text" ame="staff" placeholder="Name" class="form-control" value="{{ old('staff')}}" >	 -->
						<div class="input-group mb-3">
							<select name="user_id" class="custom-select" id="inputGroupSelect01">
								<option selected>Choose...</option>
								@foreach( $data as $key => $a )
								<option value="{{ $a->id }}">{{ $a->name}}</option>
								@endforeach
							</select>
						</div>
						@if($errors->has('user_id'))
						<span class="text-danger">{{ $errors->first('user_id') }}</span>
						@endif
					</div>
					<div>
						<label>Date</label>
						<input type="date" class="form-control" name="date" class="form-control">
						@if($errors->has('date'))
						<span class="text-danger">{{ $errors->first('date') }}</span>
						@endif
					</div>
					<div>
						<label>Description</label>
						<textarea class="form-control" name="description" class="form-control" rows="3" ></textarea>
						@if($errors->has('description'))
						<span class="text-danger">{{ $errors->first('description') }}</span>
						@endif
					</div>
					<div>
						<label>Total</label>
						<input type="text" name="total" class="form-control" placeholder="Total" value="{{old('to{tal')}}">
						@if($errors->has('total'))
						<span class="text-danger">{{ $errors->first('total') }}</span>
						@endif
					</div><br>
					<div>
						<label>Proof</label>
						<input type="file" name="proof"><br>
						@if($errors->has('proof'))
						<span class="text-danger">{{ $errors->first('proof') }}</span>
						@endif
					</div>
					<div class="text-right">
						<input class="btn btn-primary" type="submit" name="submit" value="submit">
						<input class="btn btn-dark" type="reset" name="reset" value="reset">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
