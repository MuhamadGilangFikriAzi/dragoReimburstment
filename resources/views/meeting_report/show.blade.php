@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>Dashboard</b></div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form action="" method="post">

                        <table class="table table-striped table-bordered">
                            <tr>
                                <td>Agenda</td>
                                <td>{{ $id->schedule['agenda'] }}</td>
                            </tr>
                            <tr>
                                <td>Time Finished</td>
                                <td>{{ $id->time_finished }}</td>
                            </tr>
                            <tr>
                                <td>Client Person</td>
                                <td>{{ $id->client_person }}</td>
                            </tr>
                            <tr>
                                <td>Upload Doc.</td>
                                <td>{{ $id->document }}
                                    <a href="{{ route('download',$id->id) }}" class="btn btn-sm btn-primary mx-3">Download</a></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection