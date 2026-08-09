@extends('layouts.dashboard')
@section('title', 'My Patients')
@section('datatable', true)

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
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">My Patients</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $patients->count() }} patients you have treated</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table id="patients-dt" class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Patient</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Gender</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Blood Type</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($patients as $patient)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs flex-shrink-0">
                                {{ strtoupper(substr($patient->first_name ?? 'P', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                                <p class="text-xs text-gray-400">{{ $patient->patient_number }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3.5 text-gray-600 capitalize">{{ $patient->gender ?? '—' }}</td>
                    <td class="px-6 py-3.5 text-gray-600">{{ $patient->blood_type ?? '—' }}</td>
                    <td class="px-6 py-3.5 text-gray-600">{{ $patient->user?->phone ?? '—' }}</td>
                    <td class="px-6 py-3.5">
                        <a href="{{ route('doctor.patients.show', $patient) }}"
                           class="text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                            View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>$(document).ready(function(){ initDT('#patients-dt', {order:[[0,'asc']]}); });</script>
@endpush
