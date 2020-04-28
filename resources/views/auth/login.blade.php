<!DOCTYPE html>
<html>
<head>
    <title>login</title>
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>
<body>
<div class="row justify-content-center">
    <div class="col-xl-7 col-sm-9 col-md-6">
        <div class="card o-hidden border-0 shadow-sm-2 my-5">
            <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
                <div class="row">
                  <div class="col-lg-6 d-none d-sm-block bg-login-image">
                    <img src="{{ asset('img/reimburstment/drago.png') }}" alt="img" style="width: 105%; background-color: black; height: 100%;">
                  </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Drago Reimbursement</h1>
                                </div>
                                    <form method="POST" action="{{ route('login') }}" class="px-4 py-3">
                                        @csrf
                                        <div class="form-group">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter Email Address..." value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  placeholder="password" required autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror                            
                                        </div>
                                        {{-- <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="remember">
                                                        {{ __('Remember Me') }}
                                                    </label>
                                            </div>
                                        </div>  --}}
                                        <button type="submit" class="btn btn-dark" style="width: 100%;">
                                            {{ __('Login') }}
                                        </button>
                                    </form>
                                        {{-- <hr>
                                        <div class="text-center">
                                            @if (Route::has('password.request'))
                                            <a class="small" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                            @endif              
                                        </div>
                                        <div class="text-center">
                                            @if (Route::has('register'))
                                            <a class="small" href="{{ route('register') }}">Create an Account!</a>        
                                            @endif
                                        </div> --}}
                              
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>