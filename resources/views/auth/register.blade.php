<!DOCTYPE html>
<html>
<head>
    <title>register</title>
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>
<body>
<div class="row justify-content-center">
    <div class="col-xl-7 col-sm-9 col-md-6">
        <div class="card o-hidden bordered-0 shadow-sm-2 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-6 d-none d-sm-block bg-login-image">
                        <img src="{{ asset('img/drago.png') }}" alt="img" style="width: 105%; background-color: black; height: 100%;">
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Register</h1>
                            </div>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                    <div class="form-group">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"  placeholder="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="password_confirmation" required autocomplete="new-password">
                                    </div>

                                <div class="form-group row mb-0">
                                    <button type="submit" class="btn btn-dark" style="width: 100%;">
                                       {{ __('Register') }}
                                    </button>
                                    <a href="{{ route('login') }}">
                                        <button class="btn btn-dark my-2">
                                           Back
                                        </button>
                                    </a>
                                </div>
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