@extends('layouts.dashboard')
@section('title', 'Appointments')

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
@include('partials.appointments-table', [
    'canApprove'   => true,
    'showRoute'    => 'staff.appointments.show',
    'storeRoute'   => route('staff.appointments.store'),
    'approveRoute' => 'staff.appointments.approve',
    'cancelRoute'  => 'staff.appointments.cancel',
    'patients'     => $patients,
    'doctors'      => $doctors,
    'services'     => $services,
])
@endsection
