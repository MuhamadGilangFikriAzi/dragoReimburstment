<!DOCTYPE html>
<html>
<head>
    <title>login</title>

    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
</head>
<body>
<div class="row justify-content-center">
    <div class="col-lg-4">
        <div class="card o-hidden border-0 shadow-sm-2 my-5 bg-gradient-light">
            <div class="card-header bg-dark">
                <h1 class="h5 text-gray-900 ">Drago Reimbursement</h1>
            </div>
            <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
                <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                    <form method="POST" action="{{ route('login') }}" class="px-4 py-3">
                                        @csrf
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text bg-white border-right-0 float-right" id="basic-addon1"><i class="fas fa-at text-muted"></i></span>
                                                </div>
                                                <input id="email" type="email" class="form-control border-left-0 @error('email') is-invalid @enderror" name="email" placeholder="Enter Email Address..." value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            </div>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text bg-white border-right-0 float-right" id="basic-addon1"><i class="fas fa-lock text-muted"></i></span>
                                                </div>
                                                <input id="password" type="password" class="form-control border-left-0 @error('password') is-invalid @enderror" name="password"  placeholder="password" required autocomplete="current-password" autofocus>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-dark" style="width: 100%;">
                                            {{ __('Login') }}
                                        </button>
                                    </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
