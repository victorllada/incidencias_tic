@extends('layouts.app')

@section('content')
    <div class="background-radial-gradient overflow-hidden d-flex align-items-center">
        <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
            <div id="radius-shape-1" class="position-absolute shadow-5-strong animate"></div>
            <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-6 mb-5 mb-lg-0 d-flex flex-column align-items-center" style="z-index: 10">
                    <img src="{{ asset('assets/imagenes/logo.svg') }}" alt="" class="logo-login">
                    <h1 class="display-5 fw-bold ls-tight" style="color: #ffffff">
                        IES
                        <span style="color: #60bffb">Miguel Herrero</span>
                    </h1>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-1" class="position-absolute shadow-5-strong animate"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong animate"></div>

                    <div class="card bg-glass">
                        <div class="card-body px-4 py-5 px-md-5">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-outline mb-4">
                                    <label for="username" class="form-label">{{ __('Username') }}</label>
                                    <div>
                                        <input id="username" type="text"
                                            class="form-control @error('username') is-invalid @enderror" name="username"
                                            value="{{ old('username') }}" required autocomplete="username" autofocus>

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-outline mb-4">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>

                                    <div>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-outline mb-3">
                                    <div class="col d-flex justify-content-center">
                                        <div class="form-check d-flex gap-2">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-outline">
                                    <div class="col d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Login') }}
                                        </button>

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
