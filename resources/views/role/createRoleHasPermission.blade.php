@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><b>Create Role</b></div>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form action="{{ route('storeRoleHasPermission') }}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label>Role</label>
                        </div>
                        <div class="col-sm-10">
                            <select name="role" class="form-control form-control-sm">
                                <option value="">-- Choice Role --</option>
                                @foreach($role as $key => $roles)
                                <option value="{{ $roles->id }}">{{ $roles->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label>Permission</label>
                        </div>
                        <div class="col-sm-10">
                            <select name="permission" class="form-control form-control-sm">
                                <option value="">-- Choice Permission --</option>
                                @foreach($permission as $key => $permissions)
                                <option value="{{ $permissions->id }}">{{ $permissions->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- <div class="form-group row">
                        <div class="col-sm-2">
                            <label>Permission</label>
                        </div>
                        <div class="col-sm-10">
                            @foreach($permission as $permissions)
                                <input type="checkbox" name="permission" value="{{$permissions->id}}">&nbsp; {{$permissions->name}} <br>
                            @endforeach
                        </div>
                    </div> -->
                    <input type="submit" value="Save" class="btn btn-primary float-right">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
