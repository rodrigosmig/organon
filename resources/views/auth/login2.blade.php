<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ config('app.name') }}</title>
        <!-- Custom fonts for this template-->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link rel="stylesheet" href="{{ asset('css/app.css' )}}">
        <link rel="stylesheet" href="{{ asset('css/fontawesome-free/css/all.css' )}}">
        <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css' )}}">
    </head>
    <body class="bg-gradient-primary">
        <div class="container">
            <div class="row justify-content-center">        
                <div class="col-xl-10 col-lg-12 col-md-9">            
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Entrar</h1>
                                        </div>
                                        <form class="user" method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="form-group">
                                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required autocomplete="email" autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" required autocomplete="current-password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="customCheck">{{ __('Remember Me') }}</label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-user btn-block">Entrar</button>
                                        </form>
                                        <hr>
                                        @if (Route::has('password.request'))
                                            <div class="text-center">
                                                <a class="small" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                            </div>
                                        @endif                                        
                                        @if (Route::has('register'))
                                            <div class="text-center">
                                                <a class="small" href="{{ route('register') }}">{{ __('Create an Account!') }}</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>            
                </div>        
            </div>        
          </div>

        {{-- <script src="{{ asset('js/jquery/jquery.min.js' )}}" type="text/javascript"></script> --}}
        <script src="{{ asset('js/app.js' )}}" type="text/javascript"></script>
        <script src="{{ asset('js/sb-admin-2.min.js' )}}" type="text/javascript"></script>
    </body>
</html>
