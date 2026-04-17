@extends('layouts.dashboard')
@section('title', 'Invoice ' . $invoice->invoice_number)

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
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('patient.invoices') }}"
       class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-bold text-gray-900">Invoice {{ $invoice->invoice_number }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">Issued {{ $invoice->issue_date?->format('F d, Y') }}</p>
    </div>
</div>

<div class="max-w-2xl space-y-5">

    {{-- Invoice header card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-gray-900">Invoice Details</h3>
            <span class="{{ $invoice->statusBadgeClass() }} text-sm px-3 py-1">{{ ucfirst($invoice->status) }}</span>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between py-2 border-b border-gray-50">
                <span class="text-gray-500">Doctor</span>
                <span class="font-medium text-gray-900">Dr. {{ $invoice->appointment->doctorProfile->user->name }}</span>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-50">
                <span class="text-gray-500">Service</span>
                <span class="text-gray-900">{{ $invoice->appointment->service?->name ?? '—' }}</span>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-50">
                <span class="text-gray-500">Visit Date</span>
                <span class="text-gray-900">{{ \Carbon\Carbon::parse($invoice->appointment->appointment_date)->format('M d, Y') }}</span>
            </div>
        </div>
    </div>

    {{-- Totals --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-semibold text-gray-900 mb-4">Summary</h3>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between py-1.5">
                <span class="text-gray-500">Subtotal</span>
                <span class="text-gray-900">Rs.{{ number_format($invoice->subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between py-1.5">
                <span class="text-gray-500">Tax</span>
                <span class="text-gray-900">Rs.{{ number_format($invoice->tax_amount, 2) }}</span>
            </div>
            @if($invoice->discount_amount > 0)
            <div class="flex justify-between py-1.5">
                <span class="text-gray-500">Discount</span>
                <span class="text-emerald-600">− Rs.{{ number_format($invoice->discount_amount, 2) }}</span>
            </div>
            @endif
            <div class="flex justify-between py-2 border-t border-gray-100 font-bold text-base mt-1">
                <span class="text-gray-900">Total</span>
                <span class="text-gray-900">Rs.{{ number_format($invoice->total_amount, 2) }}</span>
            </div>
            <div class="flex justify-between py-1.5 text-emerald-600">
                <span>Amount Paid</span>
                <span>Rs.{{ number_format($invoice->paid_amount, 2) }}</span>
            </div>
            <div class="flex justify-between py-1.5 font-semibold {{ $invoice->balance_due > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                <span>Balance Due</span>
                <span>Rs.{{ number_format($invoice->balance_due, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Payments --}}
    @if($invoice->payments && $invoice->payments->count())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-semibold text-gray-900 mb-4">Payment History</h3>
        <div class="space-y-3">
            @foreach($invoice->payments->sortByDesc('payment_date') as $payment)
            <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                <div>
                    <p class="text-sm font-medium text-gray-900">Rs.{{ number_format($payment->amount, 2) }}</p>
                    <p class="text-xs text-gray-400">
                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                        @if($payment->payment_method)
                        &middot; {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                        @endif
                    </p>
                </div>
                <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">Paid</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
