@extends('layouts.dashboard')
@section('title', 'Settings')

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
        <h1 class="text-xl font-bold text-gray-900">Settings</h1>
        <p class="text-sm text-gray-500 mt-0.5">Clinic configuration</p>
    </div>
</div>

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-200 rounded-2xl px-5 py-4 mb-5 flex items-center gap-3">
    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    <p class="text-sm text-emerald-800">{{ session('success') }}</p>
</div>
@endif

<form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-2xl space-y-5">
    @csrf

    {{-- Clinic Info --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-semibold text-gray-900 mb-5">Clinic Information</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Clinic Name</label>
                <input type="text" name="clinic_name"
                       value="{{ old('clinic_name', $settings['clinic_name']) }}"
                       class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Phone</label>
                    <input type="text" name="clinic_phone"
                           value="{{ old('clinic_phone', $settings['clinic_phone']) }}"
                           placeholder="+94 11 123 4567"
                           class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Email</label>
                    <input type="email" name="clinic_email"
                           value="{{ old('clinic_email', $settings['clinic_email']) }}"
                           placeholder="clinic@example.com"
                           class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Address</label>
                <textarea name="clinic_address" rows="2"
                          class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                          placeholder="123 Main St, Colombo 03">{{ old('clinic_address', $settings['clinic_address']) }}</textarea>
            </div>
        </div>
    </div>

    {{-- Billing defaults --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-semibold text-gray-900 mb-5">Billing Defaults</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Default Tax Rate (%)</label>
                <input type="number" name="tax_rate" min="0" max="100" step="0.01"
                       value="{{ old('tax_rate', $settings['tax_rate']) }}"
                       class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                       placeholder="0">
                <p class="text-xs text-gray-400 mt-1">Applied automatically on new invoices.</p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Currency Symbol</label>
                <input type="text" name="currency"
                       value="{{ old('currency', $settings['currency']) }}"
                       class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                       placeholder="Rs.">
            </div>
        </div>
    </div>

    <button type="submit"
            class="px-6 py-2.5 text-sm font-semibold text-white bg-gray-950 hover:bg-gray-800 rounded-xl transition-colors">
        Save Settings
    </button>
</form>
@endsection
