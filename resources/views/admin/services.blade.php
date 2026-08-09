@extends('layouts.dashboard')
@section('title', 'Services')
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
<div
    x-data="crudModal({
        storeUrl:  '{{ route('admin.services.store') }}',
        updateUrl: '{{ url('admin/services') }}',
        defaults:  { name:'', category:'Preventive', base_price:'', duration_minutes:'', description:'', is_active:true }
    })"
>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Services</h1>
        <p class="text-sm text-gray-500 mt-0.5">Manage the clinic's dental service catalog.</p>
    </div>
    <button @click="openCreate()" class="btn-primary text-sm">+ New Service</button>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table id="services-dt" class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Duration</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($services as $service)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3.5">
                        <p class="font-medium text-gray-900">{{ $service->name }}</p>
                        @if($service->description)
                            <p class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">{{ $service->description }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-3.5 text-gray-600">{{ $service->category }}</td>
                    <td class="px-6 py-3.5 font-medium text-gray-900">
                        {{ $service->base_price ? 'Rs.'.number_format($service->base_price, 0) : '—' }}
                    </td>
                    <td class="px-6 py-3.5 text-gray-500">
                        {{ $service->duration_minutes ? $service->duration_minutes.' min' : '—' }}
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                            {{ $service->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $service->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-2">
                            <button
                                @click="openEdit({
                                    id: {{ $service->id }},
                                    name: @js($service->name),
                                    category: @js($service->category),
                                    base_price: '{{ $service->base_price }}',
                                    duration_minutes: '{{ $service->duration_minutes }}',
                                    description: @js($service->description ?? ''),
                                    is_active: {{ $service->is_active ? 'true' : 'false' }}
                                })"
                                class="text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition-colors">
                                Edit
                            </button>
                            <button
                                @click="del({{ $service->id }}, '{{ url('admin/services') }}')"
                                class="text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal --}}
<div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-black/50" @click="close()"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg mx-auto"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900" x-text="mode==='create' ? 'Add New Service' : 'Edit Service'"></h3>
            <button @click="close()" class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form @submit.prevent="submit()" class="px-6 py-5 space-y-4">
            <div x-show="Object.keys(errors).length > 0"
                 class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-600">
                Please correct the errors below.
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Service Name <span class="text-red-500">*</span></label>
                <input x-model="form.name" type="text" placeholder="e.g. Tooth Extraction"
                       class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                       :class="errors.name ? 'border-red-300' : 'border-gray-200'">
                <p x-show="errors.name" x-text="errors.name?.[0]" class="text-xs text-red-500 mt-1"></p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Category <span class="text-red-500">*</span></label>
                    <input x-model="form.category" type="text" placeholder="e.g. Surgical"
                           list="category-suggestions"
                           class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           :class="errors.category ? 'border-red-300' : 'border-gray-200'">
                    <datalist id="category-suggestions">
                        @foreach($services->pluck('category')->unique()->sort() as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                        <option value="Preventive"><option value="Cosmetic">
                        <option value="Restorative"><option value="Orthodontics">
                        <option value="Surgical"><option value="Endodontics">
                        <option value="Periodontics"><option value="Pediatric">
                    </datalist>
                    <p x-show="errors.category" x-text="errors.category?.[0]" class="text-xs text-red-500 mt-1"></p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Base Price (Rs.)</label>
                    <input x-model="form.base_price" type="number" min="0" step="0.01" placeholder="0.00"
                           class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Duration (minutes)</label>
                    <input x-model="form.duration_minutes" type="number" min="0" step="5" placeholder="30"
                           class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input x-model="form.is_active" type="checkbox" class="w-4 h-4 rounded accent-primary-600">
                        <span class="text-sm text-gray-700">Active service</span>
                    </label>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Description</label>
                <textarea x-model="form.description" rows="2" placeholder="Brief description of the service…"
                          class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" @click="close()" class="px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Cancel</button>
                <button type="submit" :disabled="loading" class="px-4 py-2 text-sm font-semibold text-white bg-gray-950 hover:bg-gray-800 rounded-xl transition-colors disabled:opacity-50 min-w-[110px]">
                    <span x-show="!loading" x-text="mode==='create' ? 'Add Service' : 'Save Changes'"></span>
                    <span x-show="loading">Saving…</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-black/50" @click="showDeleteModal = false"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm mx-auto"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="px-6 py-5">
            <h3 class="font-semibold text-gray-900 mb-2">Delete Service</h3>
            <p class="text-sm text-gray-500">Are you sure you want to delete this service? This cannot be undone.</p>
        </div>
        <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-100">
            <button type="button" @click="showDeleteModal = false"
                    class="px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Cancel</button>
            <button type="button" @click="confirmDelete()"
                    class="px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors">Delete</button>
        </div>
    </div>
</div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    initDT('#services-dt', { order: [[1,'asc'],[0,'asc']] });
});
</script>
@endpush
