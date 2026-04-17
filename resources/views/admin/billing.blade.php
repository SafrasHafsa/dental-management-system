@extends('layouts.dashboard')
@section('title', 'Billing')

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
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Billing Overview</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $invoices->count() }} total invoices</p>
    </div>
</div>

{{-- Quick stats --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    @php
        $totalRevenue   = $invoices->whereIn('status',['paid','partial'])->sum('paid_amount');
        $outstanding    = $invoices->whereIn('status',['unpaid','partial','overdue'])->sum('balance_due');
        $paidCount      = $invoices->where('status','paid')->count();
        $overdueCount   = $invoices->where('status','overdue')->count();
    @endphp
    <div class="bg-emerald-50 rounded-2xl p-4 border border-emerald-100">
        <p class="text-xs text-emerald-600 mb-1">Total Collected</p>
        <p class="text-2xl font-bold text-emerald-900">Rs.{{ number_format($totalRevenue, 0) }}</p>
    </div>
    <div class="bg-red-50 rounded-2xl p-4 border border-red-100">
        <p class="text-xs text-red-600 mb-1">Outstanding</p>
        <p class="text-2xl font-bold text-red-900">Rs.{{ number_format($outstanding, 0) }}</p>
    </div>
    <div class="bg-blue-50 rounded-2xl p-4 border border-blue-100">
        <p class="text-xs text-blue-600 mb-1">Fully Paid</p>
        <p class="text-2xl font-bold text-blue-900">{{ $paidCount }}</p>
    </div>
    <div class="bg-amber-50 rounded-2xl p-4 border border-amber-100">
        <p class="text-xs text-amber-600 mb-1">Overdue</p>
        <p class="text-2xl font-bold text-amber-900">{{ $overdueCount }}</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table id="billing-dt" class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice #</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Patient</th>
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
                    <td class="px-6 py-3.5">
                        <p class="font-medium text-gray-900">
                            {{ $invoice->appointment->patient->first_name }} {{ $invoice->appointment->patient->last_name }}
                        </p>
                    </td>
                    <td class="px-6 py-3.5 text-gray-500">{{ $invoice->appointment->service?->name ?? '—' }}</td>
                    <td class="px-6 py-3.5 text-gray-600">{{ $invoice->issue_date->format('M d, Y') }}</td>
                    <td class="px-6 py-3.5 font-semibold text-gray-900">Rs.{{ number_format($invoice->total_amount, 2) }}</td>
                    <td class="px-6 py-3.5 font-semibold {{ $invoice->balance_due > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                        Rs.{{ number_format($invoice->balance_due, 2) }}
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="{{ $invoice->statusBadgeClass() }}">{{ ucfirst($invoice->status) }}</span>
                    </td>
                    <td class="px-6 py-3.5">
                        <a href="{{ route('admin.billing.show', $invoice) }}"
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
<script>$(document).ready(function(){ initDT('#billing-dt', {order:[[3,'desc']]}); });</script>
@endpush
