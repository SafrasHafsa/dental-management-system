@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('sidebar-nav')
    <div class="mb-4">
        <p class="px-3 mb-2 text-xs font-semibold text-gray-600 uppercase tracking-wider">General</p>
        <x-nav-item route="admin.dashboard"    icon="home"       label="Dashboard" />
        <x-nav-item route="admin.patients"     icon="users"      label="Patients" />
        <x-nav-item route="admin.appointments" icon="calendar"   label="Appointments" />
        <x-nav-item route="admin.billing"      icon="receipt"    label="Billing" />
        <x-nav-item route="admin.inventory"    icon="cube"       label="Inventory" />
        <x-nav-item route="admin.reports"      icon="chart"      label="Reports" />
    </div>
    <div class="pt-2 border-t border-white/5">
        <p class="px-3 mb-2 mt-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Admin</p>
        <x-nav-item route="admin.users"    icon="user-group" label="Manage Users" />
        <x-nav-item route="admin.services" icon="sparkles"   label="Services" />
        <x-nav-item route="admin.settings" icon="cog"        label="Settings" />
    </div>
@endsection

@section('content')

{{-- Welcome bar --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Welcome Back, {{ auth()->user()->name }}!</h1>
        <p class="text-sm text-gray-500 mt-0.5">Here's what's happening at the clinic today.</p>
    </div>
    <a href="{{ route('admin.appointments') }}" class="btn-primary text-sm">View All Time</a>
</div>

{{-- Stat cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <p class="text-sm text-gray-500 mb-3">Total Patients</p>
        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_patients']) }}</p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100">
            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Active</span>
            <span class="text-xs text-gray-400">registered patients</span>
        </div>
    </div>

    <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100 shadow-sm">
        <p class="text-sm text-blue-600 mb-3">Today's Appointments</p>
        <p class="text-3xl font-bold text-blue-900">{{ $stats['appointments_today'] }}</p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-blue-100">
            <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full">Today</span>
            <span class="text-xs text-blue-400">scheduled visits</span>
        </div>
    </div>

    <div class="bg-amber-50 rounded-2xl p-5 border border-amber-100 shadow-sm">
        <p class="text-sm text-amber-600 mb-3">Pending Approvals</p>
        <p class="text-3xl font-bold text-amber-900">{{ $stats['pending_appointments'] }}</p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-amber-100">
            @if($stats['pending_appointments'] > 0)
                <span class="text-xs font-semibold text-amber-600 bg-amber-100 px-2 py-0.5 rounded-full">Needs action</span>
            @else
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">All clear</span>
            @endif
        </div>
    </div>

    <div class="bg-violet-50 rounded-2xl p-5 border border-violet-100 shadow-sm">
        <p class="text-sm text-violet-600 mb-3">Monthly Revenue</p>
        <p class="text-3xl font-bold text-violet-900">Rs.{{ number_format($stats['revenue_this_month'], 0) }}</p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-violet-100">
            <span class="text-xs font-semibold text-violet-600 bg-violet-100 px-2 py-0.5 rounded-full">{{ now()->format('M Y') }}</span>
            <span class="text-xs text-violet-400">paid invoices</span>
        </div>
    </div>

</div>

{{-- Middle: bar chart + clinic overview --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-6">

    <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="font-semibold text-gray-900">Appointment Summary</h3>
                <p class="text-xs text-gray-400 mt-0.5">Daily bookings this week</p>
            </div>
            <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-full">Last 7 days</span>
        </div>
        @php
            $chartDays = collect(range(6, 0))->map(fn($i) => [
                'label' => now()->subDays($i)->format('D'),
                'date'  => now()->subDays($i)->format('M d'),
                'count' => \App\Models\Appointment::whereDate('appointment_date', now()->subDays($i))->count(),
            ]);
            $maxCount = $chartDays->max('count') ?: 1;
        @endphp
        <div class="flex items-end gap-3" style="height:140px">
            @foreach($chartDays as $day)
            @php $pct = max(5, round(($day['count'] / $maxCount) * 100)); @endphp
            <div class="flex-1 flex flex-col items-center gap-1.5">
                <span class="text-xs font-semibold text-gray-500 leading-none" style="min-height:1rem">
                    {{ $day['count'] > 0 ? $day['count'] : '' }}
                </span>
                <div class="w-full rounded-xl bg-primary-50 relative overflow-hidden" style="height:90px">
                    <div class="absolute bottom-0 w-full bg-primary-500 rounded-xl"
                         style="height:{{ $pct }}%"></div>
                </div>
                <div class="text-center">
                    <p class="text-xs font-medium text-gray-600">{{ $day['label'] }}</p>
                    <p class="text-xs text-gray-400">{{ $day['date'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="flex items-center gap-5 mt-4 pt-3 border-t border-gray-100">
            <span class="flex items-center gap-2 text-xs text-gray-500">
                <span class="w-3 h-3 rounded-sm bg-primary-500 inline-block"></span>
                Appointments scheduled
            </span>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col">
        <h3 class="font-semibold text-gray-900 mb-5">Clinic Overview</h3>
        <div class="space-y-3 flex-1">
            @foreach([
                ['Doctors on Staff',  $stats['total_doctors'],   'bg-blue-100 text-blue-700',    'bg-blue-500'],
                ['Staff Members',     $stats['total_staff'],     'bg-green-100 text-green-700',  'bg-green-500'],
                ['Overdue Invoices',  $stats['invoices_overdue'],'bg-red-100 text-red-700',      'bg-red-500'],
                ['Total Patients',    $stats['total_patients'],  'bg-violet-100 text-violet-700','bg-violet-500'],
            ] as [$label, $val, $colors, $dot])
            <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 {{ $colors }} rounded-xl flex items-center justify-center font-bold text-sm flex-shrink-0">
                    {{ $val }}
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-700">{{ $label }}</p>
                </div>
                <span class="w-2 h-2 rounded-full {{ $dot }}"></span>
            </div>
            @endforeach
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.reports') }}"
               class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-gray-950 text-white text-sm font-semibold hover:bg-gray-800 transition-colors">
                Full Reports
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>

</div>

{{-- Recent appointments --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-900">Recent Appointments</h3>
        <a href="{{ route('admin.appointments') }}" class="text-sm text-primary-600 hover:underline font-medium">View All</a>
    </div>

    @if($recentAppointments->isEmpty())
        <div class="text-center py-12 text-gray-400">
            <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm">No appointments yet.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Doctor</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentAppointments as $appt)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($appt->patient->first_name ?? 'P', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">
                                        {{ $appt->patient->first_name }} {{ $appt->patient->last_name }}
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $appt->patient->patient_number }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 text-gray-600">Dr. {{ $appt->doctorProfile->user->name }}</td>
                        <td class="px-6 py-3.5 text-gray-500">{{ $appt->service?->name ?? '—' }}</td>
                        <td class="px-6 py-3.5">
                            <p class="text-gray-700 font-medium">{{ $appt->appointment_date->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($appt->start_time)->format('g:i A') }}</p>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="{{ $appt->statusBadgeClass() }}">{{ $appt->statusLabel() }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
