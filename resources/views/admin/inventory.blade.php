@extends('layouts.dashboard')
@section('title', 'Inventory')

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
        <h1 class="text-xl font-bold text-gray-900">Inventory</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $items->count() }} items tracked</p>
    </div>
</div>

@php $lowStock = $items->filter(fn($i) => $i->current_stock <= $i->minimum_stock); @endphp
@if($lowStock->count())
<div class="bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4 mb-5 flex items-center gap-3">
    <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
    </svg>
    <p class="text-sm text-amber-800">
        <strong>{{ $lowStock->count() }} item(s)</strong> at or below minimum stock.
    </p>
</div>
@endif

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table id="inventory-dt" class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Item</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Unit</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">In Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Min Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Unit Cost</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($items as $item)
                @php $isLow = $item->current_stock <= $item->minimum_stock; @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3.5">
                        <p class="font-medium text-gray-900">{{ $item->name }}</p>
                        @if($item->description)
                            <p class="text-xs text-gray-400 truncate max-w-xs">{{ $item->description }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-3.5 text-gray-600">{{ $item->unit }}</td>
                    <td class="px-6 py-3.5">
                        <span class="font-semibold {{ $isLow ? 'text-red-600' : 'text-gray-900' }}">
                            {{ number_format($item->current_stock, 0) }}
                        </span>
                        @if($isLow)
                            <span class="ml-1 text-xs font-semibold text-amber-600 bg-amber-100 px-1.5 py-0.5 rounded-full">Low</span>
                        @endif
                    </td>
                    <td class="px-6 py-3.5 text-gray-500">{{ number_format($item->minimum_stock, 0) }}</td>
                    <td class="px-6 py-3.5 text-gray-700">{{ $item->unit_cost ? 'Rs.'.number_format($item->unit_cost,2) : '—' }}</td>
                    <td class="px-6 py-3.5">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                            {{ $item->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $item->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>$(document).ready(function(){ initDT('#inventory-dt', {order:[[0,'asc']]}); });</script>
@endpush
