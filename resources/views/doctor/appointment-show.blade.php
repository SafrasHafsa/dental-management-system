@extends('layouts.dashboard')
@section('title', 'Appointment ' . $appointment->appointment_number)

@section('sidebar-nav')
    <div class="mb-4">
        <p class="px-3 mb-2 text-xs font-semibold text-gray-600 uppercase tracking-wider">My Clinic</p>
        <x-nav-item route="doctor.dashboard"    icon="home"     label="Dashboard" />
        <x-nav-item route="doctor.appointments" icon="calendar" label="My Schedule" />
        <x-nav-item route="doctor.patients"     icon="users"    label="My Patients" />
        <x-nav-item route="doctor.schedule" icon="clock" label="My Availability" />
    </div>
@endsection

@section('content')
{{-- Back + actions --}}
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('doctor.appointments') }}"
           class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Appointment {{ $appointment->appointment_number }}</h1>
            <p class="text-sm text-gray-500 mt-0.5">{{ $appointment->appointment_date->format('l, F d Y') }}</p>
        </div>
    </div>
    <div class="flex items-center gap-2">
        @if($appointment->isConfirmed())
        <form method="POST" action="{{ route('doctor.appointments.start', $appointment) }}">
            @csrf @method('PATCH')
            <button class="text-sm font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 px-4 py-2 rounded-xl transition-colors">
                Start Session
            </button>
        </form>
        @endif
        @if($appointment->isInProgress())
        <a href="{{ route('doctor.appointments.notes', $appointment) }}"
           class="text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-xl transition-colors">
            Add Clinical Notes
        </a>
        <form method="POST" action="{{ route('doctor.appointments.complete', $appointment) }}">
            @csrf @method('PATCH')
            <button class="text-sm font-semibold text-white bg-gray-900 hover:bg-gray-700 px-4 py-2 rounded-xl transition-colors">
                Mark Complete
            </button>
        </form>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    {{-- Main details --}}
    <div class="xl:col-span-2 space-y-5">

        {{-- Status card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-semibold text-gray-900">Appointment Details</h3>
                <span class="{{ $appointment->statusBadgeClass() }} text-sm px-3 py-1">{{ $appointment->statusLabel() }}</span>
            </div>
            <div class="grid grid-cols-2 gap-y-4 gap-x-6">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Date</p>
                    <p class="text-sm font-medium text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Time</p>
                    <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Service</p>
                    <p class="text-sm font-medium text-gray-900">{{ $appointment->service?->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Ref #</p>
                    <p class="text-sm font-mono text-gray-700">{{ $appointment->appointment_number }}</p>
                </div>
                @if($appointment->notes)
                <div class="col-span-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Booking Notes</p>
                    <p class="text-sm text-gray-700">{{ $appointment->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Clinical notes history --}}
        @if($appointment->clinicalNotes && $appointment->clinicalNotes->count())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Clinical Notes</h3>
            @foreach($appointment->clinicalNotes->sortByDesc('created_at') as $cn)
            <div class="border border-gray-100 rounded-xl p-4 mb-3 last:mb-0">
                <p class="text-xs text-gray-400 mb-3">{{ $cn->created_at->format('M d, Y g:i A') }}</p>
                @if($cn->subjective)
                <div class="mb-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Chief Complaint</p>
                    <p class="text-sm text-gray-700">{{ $cn->subjective }}</p>
                </div>
                @endif
                @if($cn->assessment)
                <div class="mb-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Diagnosis</p>
                    <p class="text-sm text-gray-700">{{ $cn->assessment }}</p>
                </div>
                @endif
                @if($cn->procedures_done)
                <div class="mb-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Treatment Done</p>
                    <p class="text-sm text-gray-700">{{ $cn->procedures_done }}</p>
                </div>
                @endif
                @if($cn->plan)
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Prescriptions / Notes</p>
                    <p class="text-sm text-gray-700">{{ $cn->plan }}</p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Patient sidebar --}}
    <div class="space-y-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Patient</h3>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold flex-shrink-0">
                    {{ strtoupper(substr($appointment->patient->first_name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-900">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</p>
                    <p class="text-xs text-gray-400">{{ $appointment->patient->patient_number }}</p>
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Gender</span>
                    <span class="text-gray-900 capitalize">{{ $appointment->patient->gender ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Blood Type</span>
                    <span class="text-gray-900">{{ $appointment->patient->blood_type ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Phone</span>
                    <span class="text-gray-900">{{ $appointment->patient->user?->phone ?? '—' }}</span>
                </div>
            </div>
            <a href="{{ route('doctor.patients.show', $appointment->patient) }}"
               class="mt-4 flex items-center justify-center gap-2 w-full py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm font-medium text-gray-700 transition-colors">
                Full Profile
            </a>
        </div>
    </div>
</div>
@endsection
