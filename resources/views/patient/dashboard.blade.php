@extends('layouts.dashboard')

@section('title', 'My Dashboard')

@section('sidebar-nav')
    <div class="mb-4">
        <p class="px-3 mb-2 text-xs font-semibold text-gray-600 uppercase tracking-wider">My Account</p>
        <x-nav-item route="patient.dashboard"    icon="home"     label="Dashboard" />
        <x-nav-item route="patient.appointments" icon="calendar" label="My Appointments" />
        <x-nav-item route="patient.invoices"     icon="receipt"  label="My Invoices" />
        <x-nav-item route="book.index"           icon="plus"     label="Book Appointment" />
        <x-nav-item route="patient.profile"      icon="user"     label="My Profile" />
    </div>
@endsection

@section('content')

{{-- Welcome bar --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">
            Good {{ now()->hour < 12 ? 'Morning' : (now()->hour < 18 ? 'Afternoon' : 'Evening') }}, {{ $patient->first_name }}!
        </h1>
        <p class="text-sm text-gray-500 mt-0.5">Patient ID: {{ $patient->patient_number }}</p>
    </div>
    <a href="{{ route('book.index') }}" class="btn-primary text-sm">Book Appointment</a>
</div>

{{-- Stat cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">

    <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100 shadow-sm">
        <p class="text-sm text-blue-600 mb-3">Upcoming Visits</p>
        <p class="text-3xl font-bold text-blue-900">{{ $stats['upcoming_appointments'] }}</p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-blue-100">
            <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full">Scheduled</span>
            <span class="text-xs text-blue-400">appointments</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <p class="text-sm text-gray-500 mb-3">Total Visits</p>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_visits'] }}</p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100">
            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Completed</span>
            <span class="text-xs text-gray-400">all time</span>
        </div>
    </div>

    <div class="bg-{{ $stats['pending_invoices'] > 0 ? 'red' : 'emerald' }}-50 rounded-2xl p-5 border border-{{ $stats['pending_invoices'] > 0 ? 'red' : 'emerald' }}-100 shadow-sm">
        <p class="text-sm text-{{ $stats['pending_invoices'] > 0 ? 'red' : 'emerald' }}-600 mb-3">Unpaid Bills</p>
        <p class="text-3xl font-bold text-{{ $stats['pending_invoices'] > 0 ? 'red' : 'emerald' }}-900">{{ $stats['pending_invoices'] }}</p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-{{ $stats['pending_invoices'] > 0 ? 'red' : 'emerald' }}-100">
            @if($stats['pending_invoices'] > 0)
                <span class="text-xs font-semibold text-red-600 bg-red-100 px-2 py-0.5 rounded-full">Payment due</span>
            @else
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-100 px-2 py-0.5 rounded-full">All paid</span>
            @endif
        </div>
    </div>

</div>

{{-- Two columns: upcoming appointments + recent invoices --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

    {{-- Upcoming appointments --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Upcoming Appointments</h3>
            <a href="{{ route('patient.appointments') }}" class="text-sm text-primary-600 hover:underline font-medium">View All</a>
        </div>
        @forelse($upcomingAppointments as $appt)
        <div class="flex items-center gap-4 px-6 py-3.5 {{ !$loop->last ? 'border-b border-gray-50' : '' }} hover:bg-gray-50 transition-colors">
            <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <div class="text-center">
                    <p class="text-xs font-bold text-primary-700 leading-none">{{ $appt->appointment_date->format('M') }}</p>
                    <p class="text-base font-bold text-primary-700 leading-none mt-0.5">{{ $appt->appointment_date->format('d') }}</p>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900">{{ $appt->service?->name ?? 'Consultation' }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Dr. {{ $appt->doctorProfile->user->name }} &middot; {{ \Carbon\Carbon::parse($appt->start_time)->format('g:i A') }}</p>
            </div>
            <span class="{{ $appt->statusBadgeClass() }}">{{ $appt->statusLabel() }}</span>
        </div>
        @empty
        <div class="text-center py-12 text-gray-400">
            <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm mb-4">No upcoming appointments.</p>
            <a href="{{ route('book.index') }}" class="text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 px-4 py-2 rounded-lg transition-colors">Book Now</a>
        </div>
        @endforelse
    </div>

    {{-- Recent invoices --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Recent Invoices</h3>
            <a href="{{ route('patient.invoices') }}" class="text-sm text-primary-600 hover:underline font-medium">View All</a>
        </div>
        @forelse($recentInvoices as $invoice)
        <div class="flex items-center justify-between px-6 py-3.5 {{ !$loop->last ? 'border-b border-gray-50' : '' }} hover:bg-gray-50 transition-colors">
            <div>
                <p class="text-sm font-medium text-gray-900">{{ $invoice->invoice_number }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $invoice->issue_date->format('M d, Y') }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-semibold text-gray-900">Rs.{{ number_format($invoice->total_amount, 2) }}</p>
                <span class="{{ $invoice->statusBadgeClass() }} mt-1 inline-block">{{ ucfirst($invoice->status) }}</span>
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-gray-400">
            <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
            </svg>
            <p class="text-sm">No invoices yet.</p>
        </div>
        @endforelse
    </div>

</div>

@endsection
