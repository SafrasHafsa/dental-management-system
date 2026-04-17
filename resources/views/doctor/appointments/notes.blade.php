@extends('layouts.dashboard')
@section('title', 'Clinical Notes')

@section('sidebar-nav')
    <div class="mb-4">
        <p class="px-3 mb-2 text-xs font-semibold text-gray-600 uppercase tracking-wider">My Clinic</p>
        <x-nav-item route="doctor.dashboard"    icon="home"     label="Dashboard" />
        <x-nav-item route="doctor.appointments" icon="calendar" label="My Schedule" />
        <x-nav-item route="doctor.patients"     icon="users"    label="My Patients" />
    </div>
@endsection

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('doctor.appointments.show', $appointment) }}"
       class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-bold text-gray-900">Clinical Notes</h1>
        <p class="text-sm text-gray-500 mt-0.5">
            {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
            &middot; {{ $appointment->appointment_date->format('M d, Y') }}
        </p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
    <div class="xl:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            @if($note)
            <div class="flex items-center gap-2 mb-5 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 text-sm text-amber-800">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Previous notes exist. Submitting will add a new entry.
            </div>
            @endif

            <form method="POST" action="{{ route('doctor.appointments.notes.store', $appointment) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Chief Complaint</label>
                    <textarea name="chief_complaint" rows="2"
                              class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                              placeholder="Patient's main concern…">{{ old('chief_complaint', $note?->chief_complaint) }}</textarea>
                    @error('chief_complaint')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Diagnosis</label>
                    <textarea name="diagnosis" rows="2"
                              class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                              placeholder="Clinical diagnosis…">{{ old('diagnosis', $note?->diagnosis) }}</textarea>
                    @error('diagnosis')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Treatment Done</label>
                    <textarea name="treatment" rows="3"
                              class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                              placeholder="Procedures performed…">{{ old('treatment', $note?->treatment) }}</textarea>
                    @error('treatment')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Prescriptions / Notes</label>
                    <textarea name="notes" rows="3"
                              class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                              placeholder="Medications, follow-up instructions…">{{ old('notes', $note?->notes) }}</textarea>
                    @error('notes')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="px-5 py-2 text-sm font-semibold text-white bg-gray-950 hover:bg-gray-800 rounded-xl transition-colors">
                        Save Notes
                    </button>
                    <a href="{{ route('doctor.appointments.show', $appointment) }}"
                       class="px-5 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Appointment context sidebar --}}
    <div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Appointment</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Patient</span>
                    <span class="font-medium text-gray-900">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Date</span>
                    <span class="text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Time</span>
                    <span class="text-gray-900">{{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Service</span>
                    <span class="text-gray-900">{{ $appointment->service?->name ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="{{ $appointment->statusBadgeClass() }}">{{ $appointment->statusLabel() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
