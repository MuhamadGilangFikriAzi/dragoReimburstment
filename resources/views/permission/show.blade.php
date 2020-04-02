@extends('layouts.app')

@section('content')
<div class="container mt-2">
<div class="row justify-content-between">
    <div class="offset-3 col-sm-6">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">View Permission</div>
            <div class="card-body">
                <div class="form-group">
                    Name
                    <input type="text" name="name" class="form-control form-control-sm" value="{{ $permission->name }}" readonly>
                </div>
                <div class="form-group">
                    Guard
                    <input type="text" name="guard" class="form-control form-control-sm" value="{{ $permission->guard_name }}" readonly=>
                </div>
            </div>
            </div>
        </div>              
    </div>
</div>
@endsection
