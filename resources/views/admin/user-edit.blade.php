@extends('layouts.dashboard')
@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('sidebar-nav')
    <x-nav-item route="admin.dashboard"  icon="home"       label="Dashboard" />
    <x-nav-item route="admin.users"      icon="user-group" label="Users" />
    <x-nav-item route="admin.services"   icon="sparkles"   label="Services" />
    <x-nav-item route="admin.settings"   icon="cog"        label="Settings" />
@endsection
@section('content')
<div class="mb-4"><a href="{{ route('admin.users.index') }}" class="text-sm text-primary-600 hover:underline">&larr; Back to Users</a></div>
<div class="card max-w-2xl">
    <h3 class="card-title mb-6">Edit User</h3>
    <p class="text-gray-400 text-sm">This page is under construction.</p>
</div>
@endsection
