@extends('layouts.dashboard')
@section('title', $patient->first_name . ' ' . $patient->last_name)

@section('sidebar-nav')
    <div class="mb-4">
        <p class="px-3 mb-2 text-xs font-semibold text-gray-600 uppercase tracking-wider">My Clinic</p>
        <x-nav-item route="doctor.dashboard"    icon="home"     label="Dashboard" />
        <x-nav-item route="doctor.appointments" icon="calendar" label="My Schedule" />
        <x-nav-item route="doctor.patients"     icon="users"    label="My Patients" />
        <x-nav-item route="doctor.schedule" icon="clock" label="My Schedule" />
    </div>
@endsection

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('doctor.patients') }}"
       class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-bold text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $patient->patient_number }}</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    {{-- Appointment history --}}
    <div class="xl:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Appointment History</h3>
            </div>
            <div class="overflow-x-auto">
                <table id="appts-dt" class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($patient->appointments as $appt)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3.5">
                                <p class="font-medium text-gray-700">{{ $appt->appointment_date->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($appt->start_time)->format('g:i A') }}</p>
                            </td>
                            <td class="px-6 py-3.5 text-gray-600">{{ $appt->service?->name ?? '—' }}</td>
                            <td class="px-6 py-3.5">
                                <span class="{{ $appt->statusBadgeClass() }}">{{ $appt->statusLabel() }}</span>
                            </td>
                            <td class="px-6 py-3.5">
                                @if($appt->clinicalNotes && $appt->clinicalNotes->count())
                                <a href="{{ route('doctor.appointments.show', $appt) }}"
                                   class="text-xs font-medium text-blue-600 hover:underline">
                                    {{ $appt->clinicalNotes->count() }} note(s)
                                </a>
                                @else
                                <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Patient sidebar --}}
    <div class="space-y-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-14 h-14 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-lg flex-shrink-0">
                    {{ strtoupper(substr($patient->first_name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                    <p class="text-xs text-gray-400">{{ $patient->patient_number }}</p>
                </div>
            </div>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Gender</span>
                    <span class="text-gray-900 capitalize">{{ $patient->gender ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Blood Type</span>
                    <span class="text-gray-900">{{ $patient->blood_type ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Date of Birth</span>
                    <span class="text-gray-900">{{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') : '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Phone</span>
                    <span class="text-gray-900">{{ $patient->user?->phone ?? '—' }}</span>
                </div>
                @if($patient->notes)
                <div class="pt-2 border-t border-gray-100">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Medical Notes</p>
                    <p class="text-gray-700">{{ $patient->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>$(document).ready(function(){ initDT('#appts-dt', {order:[[0,'desc']]}); });</script>
@endpush
