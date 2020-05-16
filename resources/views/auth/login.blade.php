<!DOCTYPE html>
<html>
<head>
    <title>login</title>
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>
<body>
<div class="row justify-content-center">
    <div class="col-lg-4">
        <div class="card o-hidden border-0 shadow-sm-2 my-5">
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
