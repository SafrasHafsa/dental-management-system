@extends('layouts.dashboard')
@section('title', 'New Patient')
@section('page-title', 'New Patient')
@section('page-subtitle', 'Register a new patient')
@section('sidebar-nav')
    <x-nav-item route="staff.dashboard"    icon="home"     label="Dashboard" />
    <x-nav-item route="staff.appointments" icon="calendar" label="Appointments" />
    <x-nav-item route="staff.patients"     icon="users"    label="Patients" />
    <x-nav-item route="staff.billing"      icon="receipt"  label="Billing" />
    <x-nav-item route="staff.inventory"    icon="cube"     label="Inventory" />
@endsection
@section('content')
<div class="card">
    <h3 class="card-title mb-4">New Patient</h3>
    <p class="text-gray-400 text-sm">This module is under construction.</p>
</div>
@endsection
