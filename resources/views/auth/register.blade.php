@extends('layouts.auth')

@section('title', 'Create Account')
@section('subtitle', 'Register as a new patient')

@section('content')
<div class="card-header">
    <h2 class="card-title text-center w-full">Create your account</h2>
</div>

<form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf

    <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
            <label for="first_name" class="form-label">First Name</label>
            <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}"
                   class="form-input @error('first_name') border-red-400 @enderror"
                   placeholder="Juan" required autofocus>
            @error('first_name') <p class="form-error">{{ $message }}</p> @enderror
        </div>
        <div class="form-group">
            <label for="last_name" class="form-label">Last Name</label>
            <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}"
                   class="form-input @error('last_name') border-red-400 @enderror"
                   placeholder="dela Cruz" required>
            @error('last_name') <p class="form-error">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="email" class="form-label">Email address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}"
               class="form-input @error('email') border-red-400 @enderror"
               placeholder="you@email.com" required>
        @error('email') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label for="phone" class="form-label">Phone Number</label>
        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
               class="form-input @error('phone') border-red-400 @enderror"
               placeholder="+63 9XX XXX XXXX" required>
        @error('phone') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                   class="form-input @error('date_of_birth') border-red-400 @enderror">
            @error('date_of_birth') <p class="form-error">{{ $message }}</p> @enderror
        </div>
        <div class="form-group">
            <label for="gender" class="form-label">Gender</label>
            <select id="gender" name="gender" class="form-input @error('gender') border-red-400 @enderror">
                <option value="">Select</option>
                <option value="male"   {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                <option value="other"  {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                <option value="prefer_not_to_say" {{ old('gender') === 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
            </select>
            @error('gender') <p class="form-error">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="form-group" x-data="{ show: false }">
        <label for="password" class="form-label">Password</label>
        <div class="relative">
            <input id="password" :type="show ? 'text' : 'password'" name="password"
                   class="form-input pr-10 @error('password') border-red-400 @enderror"
                   placeholder="Min. 8 characters" required>
            <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 px-3 text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </button>
        </div>
        @error('password') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation"
               class="form-input" placeholder="Repeat password" required>
    </div>

    <button type="submit" class="btn-primary w-full btn-lg">
        Create Account
    </button>
</form>

<div class="mt-5 text-center">
    <p class="text-sm text-gray-500">
        Already have an account?
        <a href="{{ route('login') }}" class="text-primary-600 font-medium hover:underline">Sign in</a>
    </p>
</div>
@endsection
