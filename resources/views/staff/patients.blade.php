@extends('layouts.dashboard')
@section('title', 'Patients')

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
@include('partials.patients-table', [
    'role'       => 'staff',
    'storeUrl'   => route('staff.patients.store'),
    'updateUrl'  => url('staff/patients'),
    'deleteUrl'  => url('staff/patients'),
    'showRoute'  => 'staff.patients.show',
])
@endsection

@push('scripts')
<script>$(document).ready(function(){ initDT('#patients-dt', {order:[[1,'asc']]}); });</script>
@endpush
