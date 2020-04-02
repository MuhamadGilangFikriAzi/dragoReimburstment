@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Meeting Report
                    <a href="{{ route('home') }}" class="float-right"> 
                    </a>                 
                </div>

                <div class="card-body">
                    <a href="{{ route('list_mreport') }}" class="btn btn-outline-dark my-3">Add Report</a>
                    <form>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Agenda</th>
                                    <th>Time Finished</th>
                                    <th>Client Person</th>
                                    <th>Document</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $d)
                                <tr>
                                    <td>{{ $d->schedule['agenda'] }}</td>
                                    <td>{{ $d->time_finished }}</td>
                                    <td>{{ $d->client_person }}</td>
                                    <td>{{ $d->document }}</td>
                                    <td><a href="{{ url('mreport/show/'.$d->id.'') }}" class="btn btn-danger">Show</a>
                                        <a href="{{ url('mreport/edit/'.$d->id.'') }}" class="btn btn-success">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
