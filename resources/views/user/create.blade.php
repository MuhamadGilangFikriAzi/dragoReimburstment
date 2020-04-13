@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>Add Data</b></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('create_user') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control">
                            @if($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control">
                            @if($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                            @if($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                        </div>
                        <div class="form-group">
                            <label>Photo</label>
                            <input type="file" name="photo"><br>
                            @if($errors->has('photo'))
                                <span class="text-danger">{{ $errors->first('photo') }}</span>
                                @endif
                        </div>
                        <div class="text-right">
                            <input class="btn btn-primary" type="submit" name="submit" value="Save Change">
                            <input class="btn btn-dark" type="reset" name="reset" value="Reset">
                        </div>                     
                   </form>
                </div>
            </div>
        </div>
</div>
@endsection
