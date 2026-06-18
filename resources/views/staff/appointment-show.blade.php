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
<div x-data="{
    showReschedule: false,
    date: '{{ $appointment->appointment_date->format('Y-m-d') }}',
    time: '{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}',
    notes: @js($appointment->notes ?? ''),
    today: '{{ now()->toDateString() }}'
}">

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
        <button @click="showReschedule = true"
                class="text-sm font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 px-4 py-2 rounded-xl transition-colors">
            Reschedule
        </button>
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

{{-- Reschedule Modal --}}
<div x-show="showReschedule" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-black/50" @click="showReschedule = false"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md mx-auto"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Reschedule Appointment</h3>
            <button @click="showReschedule = false" class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('staff.appointments.reschedule', $appointment) }}" class="px-6 py-5 space-y-4">
            @csrf @method('PATCH')
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-600">
                {{ $errors->first() }}
            </div>
            @endif
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">New Date <span class="text-red-500">*</span></label>
                <input type="date" name="appointment_date" x-model="date" :min="today" required
                       class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">New Time <span class="text-red-500">*</span></label>
                <input type="time" name="start_time" x-model="time" required
                       class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Notes</label>
                <textarea name="notes" x-model="notes" rows="2"
                          class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" @click="showReschedule = false"
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Cancel</button>
                <button type="submit"
                        class="px-4 py-2 text-sm font-semibold text-white bg-gray-950 hover:bg-gray-800 rounded-xl transition-colors min-w-[120px]">
                    Reschedule
                </button>
            </div>
        </form>
    </div>
</div>

</div>{{-- end x-data wrapper --}}
@endsection
