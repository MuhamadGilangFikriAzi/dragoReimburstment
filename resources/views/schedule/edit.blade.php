@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>Edit Schedule</b></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ url('/schedule/edit/update/'.$id->id.'') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Client</label>
                            <input type="text" name="klien" class="form-control" value="{{ $id->klien }}">
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" value="{{ $id->date }}">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Time</label>
                            <input type="time" name="time" class="form-control" value="{{ $id->time }}">
                        </div>
                        <div class="form-group">
                            <label>Agenda</label>
                            <input type="text" name="agenda" class="form-control" value="{{ $id->agenda }}">
                        </div>
                        <div>
                            <label>Participant</label>
                            <textarea class="form-control" name="participant" class="form-control" rows="3" >{{ $id->participant }}</textarea>
                        </div><br>
                        
                        <input type="submit" value="Save Change" class="btn btn-primary float-right">
                    </form>
                </div>
            </div>
        </div>
</div>
@endsection
