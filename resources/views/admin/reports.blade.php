@extends('layouts.dashboard')
@section('title', 'Reports')

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
        <h1 class="text-xl font-bold text-gray-900">Reports</h1>
        <p class="text-sm text-gray-500 mt-0.5">Revenue & clinic analytics</p>
    </div>
</div>

{{-- KPI stat cards --}}
<div class="grid grid-cols-2 xl:grid-cols-3 gap-4 mb-6">
    <div class="bg-emerald-50 rounded-2xl p-4 border border-emerald-100">
        <p class="text-xs text-emerald-600 mb-1">Revenue This Month</p>
        <p class="text-2xl font-bold text-emerald-900">Rs.{{ number_format($stats['revenue_this_month'], 0) }}</p>
        @php $diff = $stats['revenue_this_month'] - $stats['revenue_last_month']; @endphp
        @if($stats['revenue_last_month'] > 0)
        <p class="text-xs mt-1 {{ $diff >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
            {{ $diff >= 0 ? '▲' : '▼' }}
            Rs.{{ number_format(abs($diff), 0) }} vs last month
        </p>
        @endif
    </div>
    <div class="bg-red-50 rounded-2xl p-4 border border-red-100">
        <p class="text-xs text-red-600 mb-1">Outstanding Balance</p>
        <p class="text-2xl font-bold text-red-900">Rs.{{ number_format($stats['outstanding_balance'], 0) }}</p>
    </div>
    <div class="bg-blue-50 rounded-2xl p-4 border border-blue-100">
        <p class="text-xs text-blue-600 mb-1">Completed This Month</p>
        <p class="text-2xl font-bold text-blue-900">{{ $stats['completed_this_month'] }}</p>
        <p class="text-xs text-blue-500 mt-1">appointments</p>
    </div>
    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-200">
        <p class="text-xs text-gray-500 mb-1">Total Patients</p>
        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_patients'] }}</p>
    </div>
    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-200">
        <p class="text-xs text-gray-500 mb-1">Total Appointments</p>
        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_appointments'] }}</p>
    </div>
    <div class="bg-amber-50 rounded-2xl p-4 border border-amber-100">
        <p class="text-xs text-amber-600 mb-1">Revenue Last Month</p>
        <p class="text-2xl font-bold text-amber-900">Rs.{{ number_format($stats['revenue_last_month'], 0) }}</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    {{-- Revenue chart (2/3 width) --}}
    <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-semibold text-gray-900 mb-5">Monthly Revenue — Last 6 Months</h3>
        <div class="relative h-64">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Appointment status breakdown (1/3) --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-semibold text-gray-900 mb-5">Appointments by Status</h3>
        <div class="relative h-64 flex items-center justify-center">
            <canvas id="statusChart"></canvas>
        </div>
        <div class="mt-4 space-y-2">
            @php
                $statusColors = [
                    'pending'     => '#f59e0b',
                    'confirmed'   => '#3b82f6',
                    'in_progress' => '#8b5cf6',
                    'completed'   => '#10b981',
                    'cancelled'   => '#ef4444',
                ];
            @endphp
            @foreach($statusBreakdown as $status => $count)
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full flex-shrink-0"
                          style="background: {{ $statusColors[$status] ?? '#9ca3af' }}"></span>
                    <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $status) }}</span>
                </div>
                <span class="font-semibold text-gray-900">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
(function () {
    // Revenue bar chart
    const revenueLabels = @json($monthlyRevenue->pluck('label'));
    const revenueData   = @json($monthlyRevenue->pluck('revenue'));

    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Revenue (Rs.)',
                data: revenueData,
                backgroundColor: 'rgba(99,102,241,0.15)',
                borderColor: 'rgba(99,102,241,0.8)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' Rs.' + Number(ctx.raw).toLocaleString()
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, border: { display: false } },
                y: {
                    border: { display: false },
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: { callback: v => 'Rs.' + Number(v).toLocaleString() }
                }
            }
        }
    });

    // Status doughnut chart
    const statusLabels = @json($statusBreakdown->keys()->map(fn($s) => ucfirst(str_replace('_',' ',$s))));
    const statusData   = @json($statusBreakdown->values());
    const statusColors = ['#f59e0b','#3b82f6','#8b5cf6','#10b981','#ef4444','#9ca3af'];

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: statusColors.slice(0, statusData.length),
                borderWidth: 0,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { display: false },
            }
        }
    });
})();
</script>
@endpush
