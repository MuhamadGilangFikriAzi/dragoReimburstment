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

                    <form action="{{ url('user/update/'.$id->id.'') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ $id->name }}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="{{ $id->email }}">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                         <div class="card">
                        <div class="card-header">Role</div>
                        <div class="card-body">
                            <select name="role_id" class="form-control">
                               <option value="">-- Choose Role--</option>
                                @foreach($role as $key => $value)
                                @if($id->role_id == $value->id)
                                    <option value="{{$value->id}}" selected="">{{ $value->name }}</option>
                                @else
                                    <option value="{{$value->id}}">{{ $value->name }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        </div>
                        <div class="text-right">
                            <input class="btn btn-primary" type="submit"  name="submit" value="Save Change">
                            <input class="btn btn-dark" type="reset" name="reset" value="Reset">
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
