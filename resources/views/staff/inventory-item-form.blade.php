@extends('layouts.dashboard')
@section('title', isset($item) ? 'Edit Item' : 'New Item')
@section('page-title', isset($item) ? 'Edit Inventory Item' : 'Add Inventory Item')
@section('sidebar-nav')
    <x-nav-item route="staff.dashboard"    icon="home"     label="Dashboard" />
    <x-nav-item route="staff.appointments" icon="calendar" label="Appointments" />
    <x-nav-item route="staff.patients"     icon="users"    label="Patients" />
    <x-nav-item route="staff.billing"      icon="receipt"  label="Billing" />
    <x-nav-item route="staff.inventory"    icon="cube"     label="Inventory" />
@endsection
@section('content')
<div class="mb-4"><a href="{{ route('staff.inventory') }}" class="text-sm text-primary-600 hover:underline">&larr; Back to Inventory</a></div>
<div class="card max-w-lg">
    <h3 class="card-title mb-6">{{ isset($item) ? 'Edit' : 'Add' }} Item</h3>
    <p class="text-gray-400 text-sm">Inventory item form coming soon.</p>
</div>
@endsection
