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

                    <form action="{{ url('mreport/update/'.$id->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Schedule</label>
                            <select class="form-control" name="schedule_id" id="exampleFormControlSelect1">
                                <option value="{{ $id->schedule_id }}">{{ $id->schedule['agenda'] }}</option>
                                @foreach($data as $d)
                                <option value="{{ $d->id }}">{{ $d->agenda }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Time Finished</label>
                            <input type="time" class="form-control" name="time_finished" value="{{ $id->time_finished }}">
                        </div>
                        <div class="form-group">
                            <label>Client Person</label>
                            <textarea name="client_person" class="form-control">{{ $id->client_person }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Upload Doc.</label><br>
                            <input type="file" name="document"><b>{{ $id->document }}</b>
                        </div>

                        <input type="submit" value="Save Change" class="btn btn-sm btn-primary float-right">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
