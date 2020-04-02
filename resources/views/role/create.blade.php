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
                    <div class="card-header">Create Role</div>
                    <div class="card-body">
                        <form action="{{ route('store_role') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control form-control-sm">
                            </div>
                            <input type="submit" name="simpan" class="btn btn-block btn-primary btn-sm">
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
