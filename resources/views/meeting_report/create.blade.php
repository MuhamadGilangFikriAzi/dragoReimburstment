@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Insert Meeting Report</div>
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form action="{{ route('add_report') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Schedule</label>
                        <select class="form-control" name="schedule_id" id="exampleFormControlSelect1">
                          <option selected="">Choose....</option>
                          @foreach($data as $d)
                          <option value="{{ $d->id }}">{{ $d->agenda }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Time Finished</label>
                        <input type="time" class="form-control" name="time_finished">
                        @if($errors->has('time_finished'))
                        <span class="text-danger">{{ $errors->first('time_finished') }}</span>
                        @endif

                    </div>
                    <div class="form-group">
                        <label>Client Person</label>
                        <textarea name="client_person" class="form-control"></textarea>
                        @if($errors->has('client_person'))
                        <span class="text-danger">{{ $errors->first('client_person') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Upload Doc.</label><br>
                        <input type="file" name="document"><br>
                        @if($errors->has('document'))
                        <span class="text-danger">{{ $errors->first('document') }}</span>
                        @endif
                    </div>
                        <a href="{{ route('index_report') }}" class="btn btn-dark float-right mx-2">Back</a>
                        <input type="submit" value="Save" class="btn btn-primary float-right">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
