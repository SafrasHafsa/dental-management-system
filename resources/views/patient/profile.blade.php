@extends('layouts.dashboard')
@section('title', 'My Profile')

@section('sidebar-nav')
    <div class="mb-4">
        <p class="px-3 mb-2 text-xs font-semibold text-gray-600 uppercase tracking-wider">My Portal</p>
        <x-nav-item route="patient.dashboard"    icon="home"     label="Dashboard" />
        <x-nav-item route="patient.appointments" icon="calendar" label="My Appointments" />
        <x-nav-item route="patient.invoices"     icon="receipt"  label="My Invoices" />
        <x-nav-item route="patient.profile"      icon="user"     label="My Profile" />
    </div>
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">My Profile</h1>
        <p class="text-sm text-gray-500 mt-0.5">Manage your personal information</p>
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

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
    <div class="xl:col-span-2">
        <form method="POST" action="{{ route('patient.profile.update') }}">
            @csrf @method('PUT')

            {{-- Personal info --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5">
                <h3 class="font-semibold text-gray-900 mb-5">Personal Information</h3>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">First Name</label>
                        <input type="text" name="first_name"
                               value="{{ old('first_name', $patient?->first_name) }}"
                               class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Last Name</label>
                        <input type="text" name="last_name"
                               value="{{ old('last_name', $patient?->last_name) }}"
                               class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Display Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required
                           value="{{ old('name', $user->name) }}"
                           class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Date of Birth</label>
                        <input type="date" name="date_of_birth"
                               value="{{ old('date_of_birth', $patient?->date_of_birth?->format('Y-m-d')) }}"
                               class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Gender</label>
                        <select name="gender"
                                class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">— Select —</option>
                            <option value="male"   {{ old('gender', $patient?->gender) === 'male'   ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $patient?->gender) === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other"  {{ old('gender', $patient?->gender) === 'other'  ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Phone</label>
                    <input type="text" name="phone"
                           value="{{ old('phone', $user->phone) }}"
                           class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    @error('phone')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Email Address</label>
                    <input type="email" value="{{ $user->email }}" disabled
                           class="w-full rounded-xl border border-gray-100 bg-gray-50 px-3 py-2 text-sm text-gray-400 cursor-not-allowed">
                    <p class="text-xs text-gray-400 mt-1">Email cannot be changed. Contact admin if needed.</p>
                </div>
            </div>

            {{-- Password --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5">
                <h3 class="font-semibold text-gray-900 mb-5">Change Password</h3>
                <p class="text-xs text-gray-400 mb-4">Leave blank to keep your current password.</p>
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Current Password</label>
                    <input type="password" name="current_password"
                           class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           placeholder="Enter current password">
                    @error('current_password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">New Password</label>
                        <input type="password" name="password"
                               class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                               class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>
            </div>

            <button type="submit"
                    class="px-6 py-2.5 text-sm font-semibold text-white bg-gray-950 hover:bg-gray-800 rounded-xl transition-colors">
                Save Changes
            </button>
        </form>
    </div>

    {{-- Account info sidebar --}}
    <div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-14 h-14 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-lg">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                </div>
            </div>
            <div class="space-y-3 text-sm">
                @if($patient)
                <div class="flex justify-between">
                    <span class="text-gray-500">Patient #</span>
                    <span class="font-mono text-gray-900">{{ $patient->patient_number }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-500">Member Since</span>
                    <span class="text-gray-900">{{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
