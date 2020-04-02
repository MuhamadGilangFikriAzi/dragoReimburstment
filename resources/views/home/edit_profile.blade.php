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

                <form action="{{ url('/home/update/'.$id->id.'') }}" method="post" enctype="multipart/form-data">
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
                    <div class="form-group">
                        <label>Photo</label>
                        <img src="{{ asset('img/user/'.$id->photo) }}" alt="..." class="img-thumbnail" style="width: 130px; height: 100px;">
                        <input type="file" name="photo">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role_id" option="" class="form-control">
                            <option value="">-- Choice Role--</option>
                            @foreach($roles as $key => $role)
                            @if($id->role_id == $role->id)
                                <option value="{{$role->id}}" selected="">{{ $role->name }}</option>
                            @else
                                <option value="{{$role->id}}">{{ $role->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <input type="submit" value="Save Change" class="btn btn-primary float-left">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
