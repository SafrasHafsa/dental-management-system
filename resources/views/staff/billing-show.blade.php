@extends('layouts.dashboard')
@section('title', $invoice->invoice_number)

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
<div x-data="{ showPayment: false, amount: '{{ $invoice->balance_due }}', method: 'cash', ref: '', notes: '', loading: false }">

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('staff.billing') }}" class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
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
        @if($invoice->balance_due > 0)
        <button @click="showPayment = true"
                class="btn-primary text-sm">Record Payment</button>
        @endif
        <a href="{{ route('staff.billing.print', $invoice) }}" target="_blank"
           class="text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-xl transition-colors">
            Print
        </a>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    {{-- Invoice body --}}
    <div class="xl:col-span-2 space-y-5">

        {{-- Patient & appointment info --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Bill To</p>
                    <p class="font-semibold text-gray-900 text-lg">
                        {{ $invoice->appointment->patient->first_name }} {{ $invoice->appointment->patient->last_name }}
                    </p>
                    <p class="text-sm text-gray-500">{{ $invoice->appointment->patient->patient_number }}</p>
                    <p class="text-sm text-gray-500">{{ $invoice->appointment->patient->user?->phone ?? '' }}</p>
                    <p class="text-sm text-gray-500">{{ $invoice->appointment->patient->user?->email ?? '' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Invoice Details</p>
                    <p class="text-sm text-gray-700"><span class="text-gray-500">Invoice #:</span> {{ $invoice->invoice_number }}</p>
                    <p class="text-sm text-gray-700"><span class="text-gray-500">Issue Date:</span> {{ $invoice->issue_date->format('M d, Y') }}</p>
                    <p class="text-sm text-gray-700"><span class="text-gray-500">Due Date:</span> {{ $invoice->due_date->format('M d, Y') }}</p>
                    <p class="text-sm text-gray-700"><span class="text-gray-500">Doctor:</span> Dr. {{ $invoice->appointment->doctorProfile->user->name }}</p>
                </div>
            </div>

            {{-- Service line --}}
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

        {{-- Payment history --}}
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
                            @if($payment->reference_number)
                                · Ref: {{ $payment->reference_number }}
                            @endif
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
            @if($invoice->balance_due > 0)
            <button @click="showPayment = true"
                    class="mt-5 w-full py-2.5 bg-gray-950 hover:bg-gray-800 text-white text-sm font-semibold rounded-xl transition-colors">
                Record Payment
            </button>
            @else
            <div class="mt-5 flex items-center justify-center gap-2 py-2.5 bg-emerald-50 rounded-xl">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-sm font-semibold text-emerald-700">Fully Paid</span>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Payment modal --}}
<div x-show="showPayment" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-black/50" @click="showPayment = false"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md mx-auto"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Record Payment</h3>
            <button @click="showPayment = false" class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('staff.billing.payment', $invoice) }}" class="px-6 py-5 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    Amount (Rs.) <span class="text-red-500">*</span>
                    <span class="text-gray-400 font-normal">— Balance: Rs.{{ number_format($invoice->balance_due, 2) }}</span>
                </label>
                <input type="number" name="amount" step="0.01" min="0.01"
                       x-model="amount" required
                       class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                       placeholder="0.00">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Payment Method <span class="text-red-500">*</span></label>
                <select name="payment_method" x-model="method" required
                        class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                    <option value="cash">Cash</option>
                    <option value="credit_card" disabled class="text-gray-300">Credit Card</option>
                    <option value="debit_card" disabled class="text-gray-300">Debit Card</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="insurance">Insurance</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Reference Number</label>
                <input type="text" name="reference_number" x-model="ref"
                       class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                       placeholder="Receipt / transaction ID (optional)">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Notes</label>
                <textarea name="notes" x-model="notes" rows="2"
                          class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                          placeholder="Optional notes…"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" @click="showPayment = false"
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Cancel</button>
                <button type="submit"
                        class="px-4 py-2 text-sm font-semibold text-white bg-gray-950 hover:bg-gray-800 rounded-xl transition-colors min-w-[120px]">
                    Record Payment
                </button>
            </div>
        </form>
    </div>
</div>

</div>
@endsection
