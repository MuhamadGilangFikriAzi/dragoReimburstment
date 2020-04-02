@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header"><b>Add Schedule</b></div>

				<div class="card-body">
					@if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status')}}
					</div>
					@endif

					<form action="{{ route('schedule_save') }}" method="post" enctype="multipart/form-data">
						@csrf
						<div class="form-group">
							<label>Client</label>
							<input type="text" name="klien" class="form-control" value="{{old('klien')}}">
						</div>
						<div class="form-group">
							<label>Date</label>
							<input type="date" name="date" class="form-control" value="{{ old('date')}}" >
						</div>
						<div class="form-group">
							<label>Time</label>
							<input type="time" name="time" class="form-control" value="{{old('time')}}">
						</div>
						<div>
							<label>Agenda</label>
							<input type="text" name="agenda" class="form-control" value="{{old('agenda')}}">
						</div>
						<div id="participant">
							<label>Participant</label>
							<input type="text" name="participant" class="form-control" value="{{old('participant')}}" id="participant">
						</div>
						<div class="form-group">
                        	<label for="name" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                                <span id="btnparticipant" class="btn btn-sm btn-outline-dark">Add Participant</span>
                            </div>
                      	</div> 
						<div class="text-right">
							<input class="btn btn-primary" type="submit" name="submit" value="Save Change">
							<input class="btn btn-dark" type="reset" name="reset" value="reset">
						</div>
					</form>
				</div>
			</div>
		</div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $("#btnparticipant").click(function() {
      $("#participant").append(`
			<label>Participant</label>
			<input type="text" name="participant" class="form-control" value="{{old('participant')}}">
        `);
    });
  });
</script>
@endsection
