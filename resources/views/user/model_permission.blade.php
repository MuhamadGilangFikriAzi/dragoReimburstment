@extends('layouts.app')

@section('content')
<div class="row justify-content-between">
    <div class="offset-3 col-6">
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <div class="card">
                    <div class="card-header">Add Model Permission</div>
                    <div class="card-body">
                        <form action="{{ route('storegivePermission',$id->id) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Permission</label>
                                <select name="permission" class="form-control">
                                    <option value="">- Choose -</option>
                                    @foreach($permission as $value)
                                    @if($id->permission_id == $value->id)
                                    <option value="{{$value->id}}" selected>{{$value->name}}</option>
                                    @else
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <input type="submit" name="simpan" class="btn btn-block btn-primary btn-sm">
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
