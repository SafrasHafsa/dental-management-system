@extends('layouts.dashboard')
@section('title', 'Manage Users')

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
<div
    x-data="crudModal({
        storeUrl:  '{{ route('admin.users.store') }}',
        updateUrl: '{{ url('admin/users') }}',
        defaults:  { name:'', email:'', phone:'', password:'', role:'staff', is_active:true }
    })"
>

{{-- Toolbar --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Manage Users</h1>
        <p class="text-sm text-gray-500 mt-0.5">Create and manage clinic staff, doctors, and patients.</p>
    </div>
    <button @click="openCreate()" class="btn-primary text-sm">+ New User</button>
</div>

{{-- Table card --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table id="users-dt" class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user->avatarUrl() }}" alt="" class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                            <div>
                                <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $user->phone ?? '—' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3.5 text-gray-600">{{ $user->email }}</td>
                    <td class="px-6 py-3.5">
                        @php $role = $user->roles->first()?->name ?? 'none'; @endphp
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                            {{ $role==='admin'  ? 'bg-violet-100 text-violet-700' :
                              ($role==='doctor' ? 'bg-blue-100 text-blue-700' :
                              ($role==='staff'  ? 'bg-green-100 text-green-700' :
                                                  'bg-gray-100 text-gray-600')) }}">
                            {{ $user->roles->first()?->display_name ?? 'No Role' }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                            {{ $user->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-600' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-2">
                            <button
                                @click="openEdit({
                                    id: {{ $user->id }},
                                    name: @js($user->name),
                                    email: @js($user->email),
                                    phone: @js($user->phone ?? ''),
                                    password: '',
                                    role: @js($user->roles->first()?->name ?? 'staff'),
                                    is_active: {{ $user->is_active ? 'true' : 'false' }}
                                })"
                                class="text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition-colors">
                                Edit
                            </button>
                            @if($user->id !== auth()->id())
                            <button
                                @click="del({{ $user->id }}, '{{ url('admin/users') }}')"
                                class="text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                Delete
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Create / Edit Modal --}}
<div x-show="showModal" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-black/50" @click="close()"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg mx-auto"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

        {{-- Modal header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900" x-text="mode === 'create' ? 'Create New User' : 'Edit User'"></h3>
            <button @click="close()" class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Modal form --}}
        <form @submit.prevent="submit()" class="px-6 py-5 space-y-4">
            <div x-show="Object.keys(errors).length > 0"
                 class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-600">
                Please correct the errors below.
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                    <input x-model="form.name" type="text" placeholder="e.g. Dr. Sarah Ali"
                           class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           :class="errors.name ? 'border-red-300' : 'border-gray-200'">
                    <p x-show="errors.name" x-text="errors.name?.[0]" class="text-xs text-red-500 mt-1"></p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input x-model="form.email" type="email" placeholder="email@clinic.com"
                           class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           :class="errors.email ? 'border-red-300' : 'border-gray-200'">
                    <p x-show="errors.email" x-text="errors.email?.[0]" class="text-xs text-red-500 mt-1"></p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Phone</label>
                    <input x-model="form.phone" type="text" placeholder="+94 77 123 4567"
                           class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Password <span x-show="mode==='create'" class="text-red-500">*</span>
                        <span x-show="mode==='edit'" class="text-gray-400 font-normal">(leave blank to keep)</span>
                    </label>
                    <input x-model="form.password" type="password" placeholder="Min. 8 characters"
                           class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           :class="errors.password ? 'border-red-300' : 'border-gray-200'">
                    <p x-show="errors.password" x-text="errors.password?.[0]" class="text-xs text-red-500 mt-1"></p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Role <span class="text-red-500">*</span></label>
                    <select x-model="form.role"
                            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                        <option value="doctor">Doctor</option>
                        <option value="patient">Patient</option>
                    </select>
                </div>
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input x-model="form.is_active" type="checkbox"
                               class="w-4 h-4 rounded accent-primary-600">
                        <span class="text-sm text-gray-700">Active account</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" @click="close()"
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit" :disabled="loading"
                        class="px-4 py-2 text-sm font-semibold text-white bg-gray-950 hover:bg-gray-800 rounded-xl transition-colors disabled:opacity-50 min-w-[100px]">
                    <span x-show="!loading" x-text="mode === 'create' ? 'Create User' : 'Save Changes'"></span>
                    <span x-show="loading">Saving…</span>
                </button>
            </div>
        </form>
    </div>
</div>

</div>{{-- end x-data --}}
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    initDT('#users-dt', { order: [[0, 'asc']] });
});
</script>
@endpush
