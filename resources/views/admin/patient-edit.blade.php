@extends('layouts.dashboard')
@section('title', 'patient-edit')
@section('page-title', 'patient-edit')
@section('sidebar-nav')
    <x-nav-item route="admin.dashboard"    icon="home"       label="Dashboard" />
    <x-nav-item route="admin.patients"     icon="users"      label="Patients" />
    <x-nav-item route="admin.appointments" icon="calendar"   label="Appointments" />
    <x-nav-item route="admin.billing"      icon="receipt"    label="Billing" />
    <x-nav-item route="admin.inventory"    icon="cube"       label="Inventory" />
    <x-nav-item route="admin.reports"      icon="chart"      label="Reports" />
    <div class="pt-3 mt-3 border-t border-gray-100">
        <x-nav-item route="admin.users"    icon="user-group" label="Users" />
        <x-nav-item route="admin.services" icon="sparkles"   label="Services" />
        <x-nav-item route="admin.settings" icon="cog"        label="Settings" />
    </div>
@endsection
@section('content')
<div class="card">
    <p class="text-gray-400 text-sm">This page is under construction.</p>
</div>
@endsection
