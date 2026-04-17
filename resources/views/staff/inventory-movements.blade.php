@extends('layouts.dashboard')
@section('title', 'Stock History — ' . $item->name)

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
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('staff.inventory') }}" class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-900">{{ $item->name }}</h1>
            <p class="text-sm text-gray-500 mt-0.5">Stock movement history</p>
        </div>
    </div>
    <div class="text-right">
        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Current Stock</p>
        <p class="text-2xl font-bold {{ $item->isLowStock() ? 'text-red-600' : 'text-gray-900' }}">
            {{ number_format($item->current_stock, 0) }}
            <span class="text-sm font-normal text-gray-500">{{ $item->unit }}</span>
        </p>
        @if($item->isLowStock())
        <span class="text-xs font-semibold text-amber-600 bg-amber-100 px-2 py-0.5 rounded-full">Low Stock</span>
        @endif
    </div>
</div>

{{-- Item summary card --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">SKU</p>
        <p class="text-sm font-mono text-gray-900">{{ $item->sku ?? '—' }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Unit</p>
        <p class="text-sm font-semibold text-gray-900">{{ $item->unit }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Min Stock</p>
        <p class="text-sm font-semibold text-gray-900">{{ number_format($item->minimum_stock, 0) }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Unit Cost</p>
        <p class="text-sm font-semibold text-gray-900">{{ $item->unit_cost ? 'Rs.'.number_format($item->unit_cost,2) : '—' }}</p>
    </div>
</div>

{{-- Movement history table --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-900">Movement History</h3>
        <span class="text-xs text-gray-500">{{ $movements->total() }} records</span>
    </div>
    <div class="overflow-x-auto">
        <table id="movements-dt" class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date & Time</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Qty Change</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Balance After</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">By</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Notes</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($movements as $m)
                @php
                    $positive = $m->quantity > 0;
                    $typeColors = [
                        'purchase'   => 'bg-emerald-50 text-emerald-700',
                        'return'     => 'bg-blue-50 text-blue-700',
                        'usage'      => 'bg-orange-50 text-orange-700',
                        'waste'      => 'bg-red-50 text-red-700',
                        'adjustment' => 'bg-purple-50 text-purple-700',
                        'sale'       => 'bg-indigo-50 text-indigo-700',
                        'transfer'   => 'bg-gray-100 text-gray-700',
                    ];
                    $badge = $typeColors[$m->movement_type] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3.5 text-gray-600 whitespace-nowrap">
                        {{ $m->performed_at->format('M d, Y') }}
                        <span class="text-xs text-gray-400 block">{{ $m->performed_at->format('g:i A') }}</span>
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $badge }}">
                            {{ ucfirst($m->movement_type) }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5 font-semibold {{ $positive ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ $positive ? '+' : '' }}{{ number_format($m->quantity, 0) }}
                    </td>
                    <td class="px-6 py-3.5 font-semibold text-gray-900">
                        {{ number_format($m->balance_after, 0) }}
                    </td>
                    <td class="px-6 py-3.5 text-gray-600">{{ $m->performedBy?->name ?? '—' }}</td>
                    <td class="px-6 py-3.5 text-gray-500 text-xs max-w-xs truncate">{{ $m->notes ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($movements->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $movements->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>$(document).ready(function(){ initDT('#movements-dt', {order:[[0,'desc']], paging: false}); });</script>
@endpush
