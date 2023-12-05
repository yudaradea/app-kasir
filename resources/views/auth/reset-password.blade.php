@extends('auth.master-auth')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Reset Password')
@section('content')
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Forgot Password -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <a href="index.html" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">

                            </span>
                            <span class="app-brand-text demo text-body fw-bolder">Reset password</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">Reset Password Page</h4>
                    <p class="mb-4">Enter your new password</p>
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" readonly id="email" value="{{ $request->email }}"
                                name="email" autofocus />
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Password</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="Enter new password" aria-describedby="password" />
                                <span class="input-group-text showPassword cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            @error('password')
                                <div class="text-danger mb-2 ms-2 mt-1">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 mt-1 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Confirm Password</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" placeholder="Enter confirm password"
                                    aria-describedby="password_confirmation" />
                                <span class="input-group-text showPassword cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            @error('password_confirmation')
                                <div class="text-danger mb-2 ms-2 mt-1">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                        <button class="btn btn-primary d-grid w-100">Reset Password</button>
                    </form>
                </div>
            </div>
            <!-- /Forgot Password -->
        </div>
    </div>
@endsection
