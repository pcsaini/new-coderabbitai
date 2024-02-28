@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-start mb-4">Login to your account</h2>
            <form action="{{ route('auth.login.post') }}" method="post" autocomplete="off" novalidate
                  data-parsley-validate>
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           placeholder="Enter Email"
                           autocomplete="off"
                           value="{{ old('email') }}"
                           data-parsley-trigger="focusout"
                           data-parsley-required
                           data-parsley-type-message="Please enter valid email"
                           data-parsley-required-message="Please enter email">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label class="form-label">
                        Password
                    </label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Password"
                           autocomplete="off"
                           data-parsley-trigger="focusout"
                           data-parsley-required
                           data-parsley-required-message="Please enter password">

                </div>
                <div class="mb-2">
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input" name="remember"/>
                        <span class="form-check-label">Remember me</span>
                    </label>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Sign in</button>
                </div>
            </form>
        </div>
    </div>
    <div class="text-center text-muted mt-3">
        Don't have account yet? <a href="{{ route('auth.register') }}" tabindex="-1">Sign up</a>
    </div>
@endsection
