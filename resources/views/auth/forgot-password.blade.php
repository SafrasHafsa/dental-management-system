@extends('layouts.auth')

@section('title', 'Reset Password')
@section('subtitle', 'We\'ll send you a reset link')

@section('content')
<div class="card-header">
    <h2 class="card-title text-center w-full">Forgot your password?</h2>
</div>

<p class="text-sm text-gray-500 mb-5 text-center">
    Enter your email and we'll send you a password reset link.
</p>

@if(session('status'))
    <div class="alert-success mb-4">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="space-y-5">
    @csrf
    <div class="form-group">
        <label for="email" class="form-label">Email address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}"
               class="form-input @error('email') border-red-400 @enderror"
               placeholder="you@email.com" required autofocus>
        @error('email') <p class="form-error">{{ $message }}</p> @enderror
    </div>
    <button type="submit" class="btn-primary w-full btn-lg">Send Reset Link</button>
</form>

<div class="mt-5 text-center">
    <a href="{{ route('login') }}" class="text-sm text-primary-600 hover:underline">Back to sign in</a>
</div>
@endsection
