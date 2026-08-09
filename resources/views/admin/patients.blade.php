@extends('layouts.dashboard')
@section('title', 'Patients')
@section('datatable', true)

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
@include('partials.patients-table', [
    'role'       => 'admin',
    'storeUrl'   => route('admin.patients.store'),
    'updateUrl'  => url('admin/patients'),
    'deleteUrl'  => url('admin/patients'),
    'showRoute'  => 'admin.patients.show',
])
@endsection

@push('scripts')
<script>$(document).ready(function(){ initDT('#patients-dt', {order:[[1,'asc']]}); });</script>
@endpush
