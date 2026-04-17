@extends('layouts.dashboard')
@section('title', 'My Invoices')

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
        <h1 class="text-xl font-bold text-gray-900">My Invoices</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $invoices->total() }} total invoices</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table id="invoices-dt" class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice #</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Issued</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Balance</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($invoices as $invoice)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3.5 font-mono text-xs text-gray-700">{{ $invoice->invoice_number }}</td>
                    <td class="px-6 py-3.5 text-gray-500">{{ $invoice->appointment->service?->name ?? '—' }}</td>
                    <td class="px-6 py-3.5 text-gray-600">{{ $invoice->issue_date?->format('M d, Y') }}</td>
                    <td class="px-6 py-3.5 font-semibold text-gray-900">Rs.{{ number_format($invoice->total_amount, 2) }}</td>
                    <td class="px-6 py-3.5 font-semibold {{ $invoice->balance_due > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                        Rs.{{ number_format($invoice->balance_due, 2) }}
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="{{ $invoice->statusBadgeClass() }}">{{ $invoice->statusLabel() }}</span>
                    </td>
                    <td class="px-6 py-3.5">
                        <a href="{{ route('patient.invoices.show', $invoice) }}"
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
<script>$(document).ready(function(){ initDT('#invoices-dt', {order:[[2,'desc']]}); });</script>
@endpush
