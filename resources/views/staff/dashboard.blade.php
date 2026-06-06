@extends('layouts.dashboard')

@section('title', 'Staff Dashboard')

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

{{-- Welcome bar --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Welcome Back, {{ auth()->user()->name }}!</h1>
        <p class="text-sm text-gray-500 mt-0.5">Here's today's clinic activity.</p>
    </div>
    <a href="{{ route('staff.appointments') }}" class="btn-primary text-sm">View All Appointments</a>
</div>

{{-- Stat cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

    <div class="bg-amber-50 rounded-2xl p-5 border border-amber-100 shadow-sm">
        <p class="text-sm text-amber-600 mb-3">Pending Approvals</p>
        <p class="text-3xl font-bold text-amber-900">{{ $stats['pending_approvals'] }}</p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-amber-100">
            @if($stats['pending_approvals'] > 0)
                <span class="text-xs font-semibold text-amber-600 bg-amber-100 px-2 py-0.5 rounded-full">Needs action</span>
            @else
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">All clear</span>
            @endif
        </div>
    </div>

    <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100 shadow-sm">
        <p class="text-sm text-blue-600 mb-3">Today's Appointments</p>
        <p class="text-3xl font-bold text-blue-900">{{ $stats['appointments_today'] }}</p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-blue-100">
            <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full">Today</span>
            <span class="text-xs text-blue-400">scheduled visits</span>
        </div>
    </div>

    {{-- Pending Billing Card --}}
    <div class="bg-purple-50 rounded-2xl p-5 border border-purple-100 shadow-sm">
        <p class="text-sm text-purple-600 mb-3">Pending Billing</p>
        <p class="text-3xl font-bold text-purple-900">{{ $stats['unbilled_completed'] }}</p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-purple-100">
            @if($stats['unbilled_completed'] > 0)
                <span class="text-xs font-semibold text-purple-600 bg-purple-100 px-2 py-0.5 rounded-full">Needs invoicing</span>
            @else
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">All billed</span>
            @endif
        </div>
    </div>

    <div class="bg-red-50 rounded-2xl p-5 border border-red-100 shadow-sm">
        <p class="text-sm text-red-600 mb-3">Low Stock Items</p>
        <p class="text-3xl font-bold text-red-900">{{ $stats['low_stock_items'] }}</p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-red-100">
            @if($stats['low_stock_items'] > 0)
                <span class="text-xs font-semibold text-red-600 bg-red-100 px-2 py-0.5 rounded-full">Reorder needed</span>
            @else
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Stock OK</span>
            @endif
        </div>
    </div>

</div>

{{-- Three columns: pending approvals + today schedule + pending billing --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-5">

    {{-- Pending Approvals --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Pending Approvals</h3>
            <a href="{{ route('staff.appointments') }}" class="text-sm text-primary-600 hover:underline font-medium">View All</a>
        </div>
        @forelse($pendingAppointments as $appt)
        <div class="flex items-center justify-between px-6 py-3.5 {{ !$loop->last ? 'border-b border-gray-50' : '' }} hover:bg-gray-50 transition-colors">
            <div class="min-w-0 flex-1">
                <p class="text-sm font-medium text-gray-900 truncate">{{ $appt->patient->fullName() }}</p>
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ $appt->appointment_date->format('M d') }} &middot; {{ \Carbon\Carbon::parse($appt->start_time)->format('g:i A') }}
                    &middot; {{ $appt->service?->name ?? 'General' }}
                </p>
            </div>
            <div class="flex items-center gap-2 ml-4 flex-shrink-0">
                <form method="POST" action="{{ route('staff.appointments.approve', $appt) }}">
                    @csrf @method('PATCH')
                    <button class="text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition-colors">Approve</button>
                </form>
                <form method="POST" action="{{ route('staff.appointments.cancel', $appt) }}"
                      x-data="confirmAction('Cancel this appointment?')">
                    @csrf @method('PATCH')
                    <button type="button" @click="confirm($el.closest('form'))"
                            class="text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">Reject</button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center py-10 text-gray-400">
            <svg class="w-8 h-8 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm">No pending approvals.</p>
        </div>
        @endforelse
    </div>

    {{-- Today's Schedule --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Today's Schedule</h3>
            <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-full">{{ today()->format('l, M d') }}</span>
        </div>
        @forelse($todayAppointments as $appt)
        <div class="flex items-center gap-4 px-6 py-3.5 {{ !$loop->last ? 'border-b border-gray-50' : '' }} hover:bg-gray-50 transition-colors">
            <div class="w-12 text-center flex-shrink-0">
                <p class="text-sm font-bold text-primary-600">{{ \Carbon\Carbon::parse($appt->start_time)->format('g:i') }}</p>
                <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($appt->start_time)->format('A') }}</p>
            </div>
            <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs flex-shrink-0">
                {{ strtoupper(substr($appt->patient->first_name ?? 'P', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">{{ $appt->patient->fullName() }}</p>
                <p class="text-xs text-gray-400 truncate">Dr. {{ $appt->doctorProfile->user->name }} &middot; {{ $appt->service?->name ?? 'General' }}</p>
            </div>
            <span class="{{ $appt->statusBadgeClass() }}">{{ $appt->statusLabel() }}</span>
        </div>
        @empty
        <div class="text-center py-10 text-gray-400">
            <svg class="w-8 h-8 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm">No appointments scheduled today.</p>
        </div>
        @endforelse
    </div>

    {{-- Pending Billing --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Pending Billing</h3>
            <a href="{{ route('staff.billing') }}" class="text-sm text-primary-600 hover:underline font-medium">View All</a>
        </div>
        @forelse($unbilledAppointments as $appt)
        <div class="flex items-center justify-between px-6 py-3.5 {{ !$loop->last ? 'border-b border-gray-50' : '' }} hover:bg-gray-50 transition-colors">
            <div class="min-w-0 flex-1">
                <p class="text-sm font-medium text-gray-900 truncate">{{ $appt->patient->fullName() }}</p>
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ $appt->appointment_date->format('M d') }} &middot;
                    Dr. {{ $appt->doctorProfile->user->name }} &middot;
                    {{ $appt->service?->name ?? 'General' }}
                </p>
            </div>
            <a href="{{ route('staff.billing.create', $appt) }}"
               class="ml-3 flex-shrink-0 text-xs font-semibold text-purple-700 bg-purple-50 hover:bg-purple-100 px-3 py-1.5 rounded-lg transition-colors">
                Create Invoice
            </a>
        </div>
        @empty
        <div class="text-center py-10 text-gray-400">
            <svg class="w-8 h-8 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm">All appointments are billed.</p>
        </div>
        @endforelse
    </div>

</div>

@endsection