@extends('layouts.public')

@section('title', 'Booking Confirmed — City Dental Surgery')

@section('content')
<section class="max-w-2xl mx-auto px-4 py-20 text-center">
    <div class="card p-10">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">
            <svg class="w-9 h-9 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Booking Submitted!</h1>
        <p class="text-gray-500 mb-8">
            Your appointment request has been received and is <strong>awaiting confirmation</strong> from our staff.
            We'll notify you once it's approved.
        </p>

        <div class="bg-gray-50 rounded-xl p-5 text-left space-y-3 mb-8">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Booking #</span>
                <span class="font-semibold text-gray-900">{{ $appointment->appointment_number }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Doctor</span>
                <span class="font-medium text-gray-800">Dr. {{ $appointment->doctorProfile->user->name }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Date</span>
                <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Time</span>
                <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}</span>
            </div>
            @if($appointment->service)
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Service</span>
                <span class="font-medium text-gray-800">{{ $appointment->service->name }}</span>
            </div>
            @endif
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Status</span>
                <span class="{{ $appointment->statusBadgeClass() }}">{{ $appointment->statusLabel() }}</span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}" class="btn-secondary">Back to Home</a>
            @auth
            <a href="{{ auth()->user()->dashboardRoute() }}" class="btn-primary">View My Appointments</a>
            @else
            <a href="{{ route('login') }}" class="btn-primary">Sign In to Track</a>
            @endauth
        </div>
    </div>
</section>
@endsection
