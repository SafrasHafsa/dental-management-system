@extends('layouts.dashboard')
@section('title', 'Appointment #' . $appointment->appointment_number)

@section('sidebar-nav')
    <div class="mb-4">
        <p class="px-3 mb-2 text-xs font-semibold text-gray-600 uppercase tracking-wider">General</p>
        <x-nav-item route="staff.dashboard"    icon="home"     label="Dashboard" />
        <x-nav-item route="staff.appointments" icon="calendar" label="Appointments" />
        <x-nav-item route="staff.patients"     icon="users"    label="Patients" />
        <x-nav-item route="staff.billing"      icon="receipt"  label="Billing & Invoices" />
        <x-nav-item route="staff.inventory"    icon="cube"     label="Inventory" />
    </div>
@endsection

@section('content')
{{-- Back + actions --}}
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('staff.appointments') }}"
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
        @if($appointment->isPending())
        <form method="POST" action="{{ route('staff.appointments.approve', $appointment) }}">
            @csrf @method('PATCH')
            <button class="text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-xl transition-colors">
                Approve
            </button>
        </form>
        @endif
        @if(!$appointment->isCancelled() && !$appointment->isCompleted())
        <form method="POST" action="{{ route('staff.appointments.cancel', $appointment) }}"
              x-data="confirmAction('Cancel this appointment?')">
            @csrf @method('PATCH')
            <button type="button" @click="confirm($el.closest('form'))"
                    class="text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-xl transition-colors">
                Cancel
            </button>
        </form>
        @endif
        @if($appointment->isCompleted() && !$appointment->invoice)
        <a href="{{ route('staff.billing.create', $appointment) }}"
           class="btn-primary text-sm">Create Invoice</a>
        @elseif($appointment->invoice)
        <a href="{{ route('staff.billing.show', $appointment->invoice) }}"
           class="text-sm font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 px-4 py-2 rounded-xl transition-colors">
            View Invoice
        </a>
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
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Doctor</p>
                    <p class="text-sm font-medium text-gray-900">Dr. {{ $appointment->doctorProfile->user->name }}</p>
                </div>
                @if($appointment->approved_at)
                <div class="col-span-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Approved</p>
                    <p class="text-sm text-gray-700">{{ $appointment->approved_at->format('M d, Y g:i A') }}</p>
                </div>
                @endif
                @if($appointment->notes)
                <div class="col-span-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Notes</p>
                    <p class="text-sm text-gray-700">{{ $appointment->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Invoice summary if exists --}}
        @if($appointment->invoice)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Invoice</h3>
                <span class="{{ $appointment->invoice->statusBadgeClass() }}">{{ ucfirst($appointment->invoice->status) }}</span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-gray-50">
                <span class="text-sm text-gray-600">Invoice #</span>
                <span class="text-sm font-medium text-gray-900">{{ $appointment->invoice->invoice_number }}</span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-gray-50">
                <span class="text-sm text-gray-600">Total</span>
                <span class="text-sm font-semibold text-gray-900">Rs.{{ number_format($appointment->invoice->total_amount, 2) }}</span>
            </div>
            <div class="flex items-center justify-between py-2">
                <span class="text-sm text-gray-600">Balance Due</span>
                <span class="text-sm font-bold {{ $appointment->invoice->balance_due > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                    Rs.{{ number_format($appointment->invoice->balance_due, 2) }}
                </span>
            </div>
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
            <a href="{{ route('staff.patients.show', $appointment->patient) }}"
               class="mt-4 flex items-center justify-center gap-2 w-full py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm font-medium text-gray-700 transition-colors">
                Full Profile
            </a>
        </div>
    </div>
</div>
@endsection
