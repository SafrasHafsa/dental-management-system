@extends('layouts.dashboard')
@section('title', 'Inventory')
@section('datatable', true)

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
<div
    x-data="{
        ...crudModal({
            storeUrl:  '{{ route('staff.inventory.items.store') }}',
            updateUrl: '{{ url('staff/inventory/items') }}',
            defaults:  { name:'', unit:'pcs', current_stock:0, minimum_stock:5, unit_cost:'', selling_price:'', description:'', is_active:true }
        }),
        showAdjust: false,
        adjItem: { id: '', name: '', stock: 0, url: '' },
        adjForm: { quantity: '', movement_type: 'purchase', notes: '' },
        adjError: '', adjLoading: false,
        openAdjust(item) {
            this.adjItem = item;
            this.adjForm = { quantity: '', movement_type: 'purchase', notes: '' };
            this.adjError = '';
            this.showAdjust = true;
        },
        async submitAdjust() {
            this.adjLoading = true; this.adjError = '';
            try {
                const res = await fetch(this.adjItem.url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                    body: JSON.stringify(this.adjForm)
                });
                const data = await res.json();
                if (!res.ok) { this.adjError = data.error || 'Failed to update stock.'; return; }
                this.showAdjust = false;
                location.reload();
            } finally { this.adjLoading = false; }
        }
    }"
    @open-adjust.window="openAdjust($event.detail)"
>

{{-- Toolbar --}}
@php $lowStock = $items->filter(fn($i) => $i->current_stock <= $i->minimum_stock); @endphp
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Inventory</h1>
        <p class="text-sm text-gray-500 mt-0.5">
            {{ $items->count() }} items &middot;
            <span class="text-red-500 font-medium">{{ $lowStock->count() }} low stock</span>
        </p>
    </div>
    <button @click="openCreate()" class="btn-primary text-sm">+ Add Item</button>
</div>

{{-- Low stock alert --}}

@if($lowStock->count())
<div class="bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4 mb-5 flex items-center gap-3">
    <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
    </svg>
    <p class="text-sm text-amber-800">
        <strong>{{ $lowStock->count() }} item(s)</strong> are at or below minimum stock level:
        {{ $lowStock->pluck('name')->join(', ') }}.
    </p>
</div>
@endif

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table id="inventory-dt" class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Item</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Unit</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">In Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Min Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Unit Cost</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($items as $item)
                @php $isLow = $item->current_stock <= $item->minimum_stock; @endphp
                <tr class="hover:bg-gray-50 transition-colors {{ $isLow ? 'bg-amber-50/30' : '' }}">
                    <td class="px-6 py-3.5">
                        <p class="font-medium text-gray-900">{{ $item->name }}</p>
                        @if($item->description)
                            <p class="text-xs text-gray-400 truncate max-w-xs">{{ $item->description }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-3.5 text-gray-600">{{ $item->unit }}</td>
                    <td class="px-6 py-3.5">
                        <span class="font-semibold {{ $isLow ? 'text-red-600' : 'text-gray-900' }}">
                            {{ number_format($item->current_stock, 0) }}
                        </span>
                        @if($isLow)
                            <span class="ml-1 text-xs font-semibold text-amber-600 bg-amber-100 px-1.5 py-0.5 rounded-full">Low</span>
                        @endif
                    </td>
                    <td class="px-6 py-3.5 text-gray-500">{{ number_format($item->minimum_stock, 0) }}</td>
                    <td class="px-6 py-3.5 text-gray-700">
                        {{ $item->unit_cost ? 'Rs.'.number_format($item->unit_cost, 2) : '—' }}
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                            {{ $item->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $item->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-2 flex-wrap">
                            <button
                                onclick="window.dispatchEvent(new CustomEvent('open-adjust',{detail:{id:{{ json_encode($item->id) }},name:{{ json_encode($item->name) }},stock:{{ $item->current_stock }},url:'{{ route('staff.inventory.adjust', $item) }}'}}));"
                                class="text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors">
                                Adjust
                            </button>
                            <a href="{{ route('staff.inventory.movements', $item) }}"
                               class="text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition-colors">
                                History
                            </a>
                            <button
                                @click="openEdit({
                                    id: @js($item->id),
                                    name: @js($item->name),
                                    unit: @js($item->unit),
                                    current_stock: {{ $item->current_stock }},
                                    minimum_stock: {{ $item->minimum_stock }},
                                    unit_cost: '{{ $item->unit_cost }}',
                                    selling_price: '{{ $item->selling_price }}',
                                    description: @js($item->description ?? ''),
                                    is_active: {{ $item->is_active ? 'true' : 'false' }}
                                })"
                                class="text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition-colors">
                                Edit
                            </button>
                            <button
                                @click="del(@js($item->id), '{{ url('staff/inventory/items') }}')"
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

{{-- Create/Edit Modal --}}
<div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-black/50" @click="close()"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg mx-auto overflow-y-auto max-h-[90vh]"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900" x-text="mode==='create' ? 'Add Inventory Item' : 'Edit Item'"></h3>
            <button @click="close()" class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form @submit.prevent="submit()" class="px-6 py-5 space-y-4">
            <div x-show="Object.keys(errors).length > 0" class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-600">
                Please correct the errors below.
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Item Name <span class="text-red-500">*</span></label>
                <input x-model="form.name" type="text" placeholder="e.g. Dental Gloves (Box)"
                       class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                       :class="errors.name ? 'border-red-300' : 'border-gray-200'">
                <p x-show="errors.name" x-text="errors.name?.[0]" class="text-xs text-red-500 mt-1"></p>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Unit <span class="text-red-500">*</span></label>
                    <input x-model="form.unit" type="text" placeholder="pcs / box / ml"
                           list="unit-list"
                           class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <datalist id="unit-list">
                        <option value="pcs"><option value="box"><option value="bottle">
                        <option value="ml"><option value="g"><option value="kg"><option value="roll">
                    </datalist>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">In Stock <span class="text-red-500">*</span></label>
                    <input x-model="form.current_stock" type="number" min="0" step="1"
                           class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           :class="errors.current_stock ? 'border-red-300' : 'border-gray-200'">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Min Stock <span class="text-red-500">*</span></label>
                    <input x-model="form.minimum_stock" type="number" min="0" step="1"
                           class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           :class="errors.minimum_stock ? 'border-red-300' : 'border-gray-200'">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Unit Cost (Rs.)</label>
                    <input x-model="form.unit_cost" type="number" min="0" step="0.01"
                           class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           placeholder="0.00">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Selling Price (Rs.)</label>
                    <input x-model="form.selling_price" type="number" min="0" step="0.01"
                           class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           placeholder="0.00">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Description</label>
                <textarea x-model="form.description" rows="2"
                          class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                          placeholder="Optional notes about this item…"></textarea>
            </div>
            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input x-model="form.is_active" type="checkbox" class="w-4 h-4 rounded accent-primary-600">
                    <span class="text-sm text-gray-700">Active item</span>
                </label>
            </div>
            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" @click="close()" class="px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Cancel</button>
                <button type="submit" :disabled="loading" class="px-4 py-2 text-sm font-semibold text-white bg-gray-950 hover:bg-gray-800 rounded-xl transition-colors disabled:opacity-50 min-w-[100px]">
                    <span x-show="!loading" x-text="mode==='create' ? 'Add Item' : 'Save Changes'"></span>
                    <span x-show="loading">Saving…</span>
                </button>
            </div>
        </form>
    </div>
</div>


{{-- Adjust Stock Modal (inside x-data so Alpine directives work) --}}
<div x-show="showAdjust" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-black/50" @click="showAdjust = false"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md mx-auto"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div>
                <h3 class="font-semibold text-gray-900">Adjust Stock</h3>
                <p class="text-xs text-gray-400 mt-0.5" x-text="adjItem.name + ' — Current: ' + adjItem.stock"></p>
            </div>
            <button @click="showAdjust = false" class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 space-y-4">
            <div x-show="adjError" x-text="adjError" class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-600"></div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Movement Type <span class="text-red-500">*</span></label>
                <select x-model="adjForm.movement_type"
                        class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                    <option value="purchase">Purchase / Restock (+)</option>
                    <option value="usage">Usage / Consumed (−)</option>
                    <option value="return">Return (+)</option>
                    <option value="waste">Waste / Expired (−)</option>
                    <option value="adjustment">Manual Adjustment (±)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    Quantity <span class="text-red-500">*</span>
                    <span class="text-gray-400 font-normal">— Use negative to subtract (e.g. −5 for usage)</span>
                </label>
                <input x-model="adjForm.quantity" type="number" step="1" placeholder="e.g. 10 or -5"
                       class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Notes</label>
                <textarea x-model="adjForm.notes" rows="2"
                          class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                          placeholder="Reason for adjustment (optional)"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" @click="showAdjust = false"
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Cancel</button>
                <button type="button" @click="submitAdjust()" :disabled="adjLoading || !adjForm.quantity"
                        class="px-4 py-2 text-sm font-semibold text-white bg-gray-950 hover:bg-gray-800 rounded-xl transition-colors disabled:opacity-50 min-w-[100px]">
                    <span x-show="!adjLoading">Save</span>
                    <span x-show="adjLoading">Saving…</span>
                </button>
            </div>
        </div>
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
            <h3 class="font-semibold text-gray-900 mb-2">Delete Item</h3>
            <p class="text-sm text-gray-500">Are you sure you want to delete this item? This cannot be undone.</p>
        </div>
        <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-100">
            <button type="button" @click="showDeleteModal = false"
                    class="px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Cancel</button>
            <button type="button" @click="confirmDelete()"
                    class="px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors">Delete</button>
        </div>
    </div>
</div>

</div>{{-- end x-data --}}
@endsection

@push('scripts')
<script>$(document).ready(function(){ initDT('#inventory-dt', {order:[[0,'asc']]}); });</script>
@endpush
