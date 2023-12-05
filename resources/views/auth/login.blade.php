@extends('auth.master-auth')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Login - Page')
@section('content')
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <a href="#" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">

                            </span>
                            <span class="app-brand-text demo text-body fw-bolder">Login Page</span>
                        </a>
                    </div>
                    @if (Session::get('success'))
                        <div class="alert alert-primary alert-dismissible mb-4" role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    @endif

                    @if (Session::get('fail'))
                        <div class="alert alert-danger alert-dismissible mb-4" role="alert">
                            {{ Session::get('fail') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    @endif
                    <!-- /Logo -->
                    <h4 class="mb-2">Hi, Welcome 👋</h4>
                    <p class="mb-4">Please login to your account and start the adventure</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror " id="email"
                                name="email" placeholder="Enter your email address" autofocus
                                value="{{ old('email') }}" />

                            @error('email')
                                <div class="text-danger mb-2 ms-2 mt-1">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror

                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Password</label>
                                <a href="{{ route('password.request') }}">
                                    <small>Forgot Password?</small>
                                </a>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text showPassword cursor-pointer"><i class="bx bx-hide"></i></span>

                            </div>
                            @error('password')
                                <div class="text-danger mb-2 ms-2 mt-1">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
@endsection
