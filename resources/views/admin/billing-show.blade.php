@extends('layouts.dashboard')
@section('title', $invoice->invoice_number)

@section('sidebar-nav')
    <div class="mb-4">
        <p class="px-3 mb-2 text-xs font-semibold text-gray-600 uppercase tracking-wider">General</p>
        <x-nav-item route="admin.dashboard"    icon="home"     label="Dashboard" />
        <x-nav-item route="admin.patients"     icon="users"    label="Patients" />
        <x-nav-item route="admin.appointments" icon="calendar" label="Appointments" />
        <x-nav-item route="admin.billing"      icon="receipt"  label="Billing" />
        <x-nav-item route="admin.inventory"    icon="cube"     label="Inventory" />
        <x-nav-item route="admin.reports"      icon="chart"    label="Reports" />
    </div>
    <div class="pt-2 border-t border-white/5">
        <p class="px-3 mb-2 mt-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Admin</p>
        <x-nav-item route="admin.users"    icon="user-group" label="Manage Users" />
        <x-nav-item route="admin.services" icon="sparkles"   label="Services" />
        <x-nav-item route="admin.settings" icon="cog"        label="Settings" />
    </div>
@endsection

@section('content')
<div>

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.billing') }}" class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-900">{{ $invoice->invoice_number }}</h1>
            <p class="text-sm text-gray-500 mt-0.5">Issued {{ $invoice->issue_date->format('M d, Y') }}</p>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <span class="{{ $invoice->statusBadgeClass() }} text-sm px-3 py-1">{{ $invoice->statusLabel() }}</span>
        <a href="{{ route('admin.billing.pdf', $invoice) }}"
           class="text-sm font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-4 py-2 rounded-xl transition-colors">
            Download PDF
        </a>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    {{-- Invoice body --}}
    <div class="xl:col-span-2 space-y-5">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Bill To</p>
                    <p class="font-semibold text-gray-900 text-lg">
                        {{ $invoice->appointment->patient->first_name }} {{ $invoice->appointment->patient->last_name }}
                    </p>
                    <p class="text-sm text-gray-500">{{ $invoice->appointment->patient->patient_number }}</p>
                    <p class="text-sm text-gray-500">{{ $invoice->appointment->patient->user?->phone ?? '' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Invoice Details</p>
                    <p class="text-sm text-gray-700"><span class="text-gray-500">Invoice #:</span> {{ $invoice->invoice_number }}</p>
                    <p class="text-sm text-gray-700"><span class="text-gray-500">Issue Date:</span> {{ $invoice->issue_date->format('M d, Y') }}</p>
                    <p class="text-sm text-gray-700"><span class="text-gray-500">Due Date:</span> {{ $invoice->due_date->format('M d, Y') }}</p>
                    <p class="text-sm text-gray-700"><span class="text-gray-500">Doctor:</span> Dr. {{ $invoice->appointment->doctorProfile->user->name }}</p>
                </div>
            </div>

            <table class="w-full text-sm border-t border-gray-100">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Description</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t border-gray-50">
                        <td class="px-4 py-3 text-gray-900">
                            {{ $invoice->appointment->service?->name ?? 'Dental Consultation' }}
                            <p class="text-xs text-gray-400 mt-0.5">{{ $invoice->appointment->appointment_date->format('M d, Y') }}</p>
                        </td>
                        <td class="px-4 py-3 text-right font-medium text-gray-900">Rs.{{ number_format($invoice->subtotal, 2) }}</td>
                    </tr>
                </tbody>
                <tfoot class="border-t border-gray-100">
                    <tr>
                        <td class="px-4 py-2 text-right text-sm text-gray-500">Subtotal</td>
                        <td class="px-4 py-2 text-right text-sm text-gray-900">Rs.{{ number_format($invoice->subtotal, 2) }}</td>
                    </tr>
                    @if($invoice->tax_amount > 0)
                    <tr>
                        <td class="px-4 py-2 text-right text-sm text-gray-500">Tax ({{ $invoice->tax_rate }}%)</td>
                        <td class="px-4 py-2 text-right text-sm text-gray-900">Rs.{{ number_format($invoice->tax_amount, 2) }}</td>
                    </tr>
                    @endif
                    @if($invoice->discount_amount > 0)
                    <tr>
                        <td class="px-4 py-2 text-right text-sm text-gray-500">Discount</td>
                        <td class="px-4 py-2 text-right text-sm text-red-600">− Rs.{{ number_format($invoice->discount_amount, 2) }}</td>
                    </tr>
                    @endif
                    <tr class="border-t-2 border-gray-200">
                        <td class="px-4 py-3 text-right font-bold text-gray-900">Total</td>
                        <td class="px-4 py-3 text-right font-bold text-gray-900 text-lg">Rs.{{ number_format($invoice->total_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 text-right text-sm text-gray-500">Paid</td>
                        <td class="px-4 py-2 text-right text-sm text-emerald-600 font-medium">Rs.{{ number_format($invoice->paid_amount, 2) }}</td>
                    </tr>
                    <tr class="bg-{{ $invoice->balance_due > 0 ? 'red' : 'emerald' }}-50">
                        <td class="px-4 py-3 text-right font-bold text-{{ $invoice->balance_due > 0 ? 'red' : 'emerald' }}-700">Balance Due</td>
                        <td class="px-4 py-3 text-right font-bold text-{{ $invoice->balance_due > 0 ? 'red' : 'emerald' }}-700 text-lg">
                            Rs.{{ number_format($invoice->balance_due, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            @if($invoice->notes)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Notes</p>
                <p class="text-sm text-gray-700">{{ $invoice->notes }}</p>
            </div>
            @endif
        </div>

        @if($invoice->payments->count())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Payment History</h3>
            <div class="space-y-3">
                @foreach($invoice->payments->sortByDesc('payment_date') as $payment)
                <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Rs.{{ number_format($payment->amount, 2) }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $payment->paid_at->format('M d, Y g:i A') }}
                            · {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                            @if($payment->reference_number) · Ref: {{ $payment->reference_number }}@endif
                        </p>
                    </div>
                    <span class="text-xs font-semibold bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">Received</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="space-y-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Summary</h3>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total</span>
                    <span class="font-bold text-gray-900">Rs.{{ number_format($invoice->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Paid</span>
                    <span class="font-medium text-emerald-600">Rs.{{ number_format($invoice->paid_amount, 2) }}</span>
                </div>
                <div class="border-t border-gray-100 pt-3 flex justify-between">
                    <span class="font-semibold text-gray-900">Balance Due</span>
                    <span class="font-bold text-lg {{ $invoice->balance_due > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                        Rs.{{ number_format($invoice->balance_due, 2) }}
                    </span>
                </div>
            </div>
            @if($invoice->balance_due <= 0)
            <div class="mt-5 flex items-center justify-center gap-2 py-2.5 bg-emerald-50 rounded-xl">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-sm font-semibold text-emerald-700">Fully Paid</span>
            </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Related</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.appointments.show', $invoice->appointment) }}"
                   class="flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    View Appointment
                </a>
                <a href="{{ route('admin.patients.show', $invoice->appointment->patient) }}"
                   class="flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    View Patient
                </a>
                <a href="{{ route('admin.billing.pdf', $invoice) }}"
                   class="flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
