@extends('layouts.dashboard')
@section('title', $user->name)

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
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.users') }}"
       class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-bold text-gray-900">{{ $user->name }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $user->email }}</p>
    </div>
</div>

<div class="max-w-lg">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xl flex-shrink-0">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                <p class="text-sm text-gray-400">{{ $user->email }}</p>
                @if($user->roles->isNotEmpty())
                <span class="mt-1 inline-block text-xs font-semibold capitalize text-primary-700 bg-primary-50 px-2 py-0.5 rounded-full">
                    {{ $user->roles->first()?->name }}
                </span>
                @endif
            </div>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between py-2 border-b border-gray-50">
                <span class="text-gray-500">Phone</span>
                <span class="text-gray-900">{{ $user->phone ?? '—' }}</span>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-50">
                <span class="text-gray-500">Status</span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                    {{ $user->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="flex justify-between py-2">
                <span class="text-gray-500">Joined</span>
                <span class="text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
