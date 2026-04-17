@extends('layouts.dashboard')
@section('title', 'My Appointments')

@section('sidebar-nav')
    <div class="mb-4">
        <p class="px-3 mb-2 text-xs font-semibold text-gray-600 uppercase tracking-wider">My Portal</p>
        <x-nav-item route="patient.dashboard"    icon="home"     label="Dashboard" />
        <x-nav-item route="patient.appointments" icon="calendar" label="My Appointments" />
        <x-nav-item route="patient.invoices"     icon="receipt"  label="My Invoices" />
        <x-nav-item route="patient.profile"      icon="user"     label="My Profile" />
    </div>
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">My Appointments</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $appointments->total() }} total appointments</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table id="appts-dt" class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ref #</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Doctor</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date & Time</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($appointments as $appt)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3.5 font-mono text-xs text-gray-500">{{ $appt->appointment_number }}</td>
                    <td class="px-6 py-3.5 font-medium text-gray-900">Dr. {{ $appt->doctorProfile->user->name }}</td>
                    <td class="px-6 py-3.5 text-gray-500">{{ $appt->service?->name ?? '—' }}</td>
                    <td class="px-6 py-3.5">
                        <p class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($appt->start_time)->format('g:i A') }}</p>
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="{{ $appt->statusBadgeClass() }}">{{ $appt->statusLabel() }}</span>
                    </td>
                    <td class="px-6 py-3.5">
                        @if(in_array($appt->status, ['pending', 'confirmed']))
                        <form method="POST" action="{{ route('patient.appointments.cancel', $appt) }}"
                              onsubmit="return confirm('Cancel this appointment?')">
                            @csrf @method('DELETE')
                            <button class="text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                Cancel
                            </button>
                        </form>
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
@endsection

@push('scripts')
<script>$(document).ready(function(){ initDT('#appts-dt', {order:[[3,'desc']]}); });</script>
@endpush
