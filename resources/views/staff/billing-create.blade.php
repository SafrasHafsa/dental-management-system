@extends('layouts.dashboard')
@section('title', 'Create Invoice')

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
    subtotal: {{ $appointment->service?->base_price ?? 0 }},
    taxRate: 0,
    discount: 0,
    get tax()   { return Math.round(this.subtotal * this.taxRate / 100 * 100) / 100 },
    get total() { return Math.max(0, parseFloat(this.subtotal||0) + this.tax - parseFloat(this.discount||0)) }
}">

{{-- Header --}}
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('staff.appointments.show', $appointment) }}"
       class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-bold text-gray-900">Create Invoice</h1>
        <p class="text-sm text-gray-500 mt-0.5">For appointment {{ $appointment->appointment_number }}</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    {{-- Form --}}
    <div class="xl:col-span-2">
        <form method="POST" action="{{ route('staff.billing.store') }}">
            @csrf
            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

            {{-- Appointment summary --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5">
                <h3 class="font-semibold text-gray-900 mb-4">Appointment</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Patient</p>
                        <p class="font-medium text-gray-900">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</p>
                        <p class="text-xs text-gray-400">{{ $appointment->patient->patient_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Doctor</p>
                        <p class="font-medium text-gray-900">Dr. {{ $appointment->doctorProfile->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Service</p>
                        <p class="font-medium text-gray-900">{{ $appointment->service?->name ?? 'General Consultation' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Date</p>
                        <p class="font-medium text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Amounts --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5">
                <h3 class="font-semibold text-gray-900 mb-4">Invoice Amounts</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                            Subtotal (Rs.) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="subtotal" step="0.01" min="0" required
                               x-model="subtotal"
                               class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                               placeholder="0.00">
                        @error('subtotal')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tax Rate (%)</label>
                            <input type="number" name="tax_rate" step="0.01" min="0" max="100"
                                   x-model="taxRate"
                                   class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                                   placeholder="0">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Discount (Rs.)</label>
                            <input type="number" name="discount_amount" step="0.01" min="0"
                                   x-model="discount"
                                   class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                                   placeholder="0.00">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Notes</label>
                        <textarea name="notes" rows="3"
                                  class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                                  placeholder="Additional notes for this invoice…">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('staff.appointments.show', $appointment) }}"
                   class="px-5 py-2.5 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-gray-950 hover:bg-gray-800 rounded-xl transition-colors">
                    Create Invoice
                </button>
            </div>
        </form>
    </div>

    {{-- Live total sidebar --}}
    <div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-6">
            <h3 class="font-semibold text-gray-900 mb-5">Invoice Summary</h3>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-medium text-gray-900">Rs.<span x-text="parseFloat(subtotal||0).toFixed(2)"></span></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Tax (<span x-text="taxRate"></span>%)</span>
                    <span class="font-medium text-gray-900">Rs.<span x-text="tax.toFixed(2)"></span></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Discount</span>
                    <span class="font-medium text-red-600">− Rs.<span x-text="parseFloat(discount||0).toFixed(2)"></span></span>
                </div>
                <div class="border-t border-gray-100 pt-3 flex justify-between">
                    <span class="font-semibold text-gray-900">Total</span>
                    <span class="text-xl font-bold text-gray-900">Rs.<span x-text="total.toFixed(2)"></span></span>
                </div>
            </div>
            <div class="mt-5 pt-4 border-t border-gray-100">
                <div class="flex justify-between text-xs text-gray-400 mb-1">
                    <span>Due Date</span>
                    <span>{{ now()->addDays(7)->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between text-xs text-gray-400">
                    <span>Issue Date</span>
                    <span>{{ now()->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
@endsection
