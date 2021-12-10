@extends('auth.layouts.app')

@section('content')

<div class="form-content">
    <h1 class="">{{ __('Reset Password') }}</h1>
    <p class="signup-link recovery">Enter your email and instructions will sent to you!</p>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form class="text-left" method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form" >
            <div id="email-field" class="field-wrapper input">
                <div class="d-flex justify-content-between">
                    <label for="email">{{ __('Email') }}</label>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus />
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="d-sm-flex justify-content-between">
                <div class="field-wrapper">
                    <button type="submit" class="btn btn-primary" value="">{{ __('Send Password Reset Link') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
