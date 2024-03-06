@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-start mb-4 text-secondary">Create new account</h2>
            <form action="{{ route('auth.register.post') }}" method="post" autocomplete="off" novalidate
                  data-parsley-validate>
                @csrf

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Enter Name"
                           autocomplete="off"
                           value="{{ old('email') }}"
                           data-parsley-trigger="focusout"
                           data-parsley-required
                           data-parsley-required-message="Please enter name">
                </div>
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
                </div>
                <div class="mb-2">
                    <label class="form-label">Password</label>
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
                        <input type="checkbox" class="form-check-input" required name="terms"
                               data-parsley-required-message="Please read and select the terms and policy"/>
                        <span class="form-check-label">Agree the <a href="#">terms and policy</a></span>
                    </label>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Create new Account</button>
                </div>
            </form>
        </div>
    </div>
    <div class="text-center text-muted mt-3">
        Already have an account? <a href="{{ route('auth.login') }}" tabindex="-1">Sign in</a>
    </div>
@endsection
