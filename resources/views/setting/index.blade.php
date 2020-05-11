@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">


            <div class="card col-sm-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="card-header">{{$pageTitle}}</div>
                <div class="card-body">
                    <div class="row justify-content-center">
                    @foreach ($all as $name => $item)
                        <div class="card col-sm-5 mr-1 ml-1">
                            <div class="card-header bg-light">
                                @if ($item->nama == 'langsung' || $item->nama == 'transfer')
                                    Asal dana :
                                @endif
                                {{$item->nama}}
                                <a href="{{route($urlEdit,$item->id)}}" class="btn btn-primary float-right ">Edit</a>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                @foreach (json_decode($item->value) as $key => $value)
                                    <li class="list-group-item">{{$value}}</li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                    </div>

                </div>
            </div>


    </div>
</section>

@endsection
