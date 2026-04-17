
<?php $__env->startSection('title', 'Inventory'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
    <div class="mb-4">
        <p class="px-3 mb-2 text-xs font-semibold text-gray-600 uppercase tracking-wider">General</p>
        <?php if (isset($component)) { $__componentOriginal6cced52613a484e7295a90162a92d81b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6cced52613a484e7295a90162a92d81b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-item','data' => ['route' => 'staff.dashboard','icon' => 'home','label' => 'Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'staff.dashboard','icon' => 'home','label' => 'Dashboard']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6cced52613a484e7295a90162a92d81b)): ?>
<?php $attributes = $__attributesOriginal6cced52613a484e7295a90162a92d81b; ?>
<?php unset($__attributesOriginal6cced52613a484e7295a90162a92d81b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6cced52613a484e7295a90162a92d81b)): ?>
<?php $component = $__componentOriginal6cced52613a484e7295a90162a92d81b; ?>
<?php unset($__componentOriginal6cced52613a484e7295a90162a92d81b); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal6cced52613a484e7295a90162a92d81b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6cced52613a484e7295a90162a92d81b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-item','data' => ['route' => 'staff.appointments','icon' => 'calendar','label' => 'Appointments']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'staff.appointments','icon' => 'calendar','label' => 'Appointments']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6cced52613a484e7295a90162a92d81b)): ?>
<?php $attributes = $__attributesOriginal6cced52613a484e7295a90162a92d81b; ?>
<?php unset($__attributesOriginal6cced52613a484e7295a90162a92d81b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6cced52613a484e7295a90162a92d81b)): ?>
<?php $component = $__componentOriginal6cced52613a484e7295a90162a92d81b; ?>
<?php unset($__componentOriginal6cced52613a484e7295a90162a92d81b); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal6cced52613a484e7295a90162a92d81b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6cced52613a484e7295a90162a92d81b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-item','data' => ['route' => 'staff.patients','icon' => 'users','label' => 'Patients']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'staff.patients','icon' => 'users','label' => 'Patients']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6cced52613a484e7295a90162a92d81b)): ?>
<?php $attributes = $__attributesOriginal6cced52613a484e7295a90162a92d81b; ?>
<?php unset($__attributesOriginal6cced52613a484e7295a90162a92d81b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6cced52613a484e7295a90162a92d81b)): ?>
<?php $component = $__componentOriginal6cced52613a484e7295a90162a92d81b; ?>
<?php unset($__componentOriginal6cced52613a484e7295a90162a92d81b); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal6cced52613a484e7295a90162a92d81b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6cced52613a484e7295a90162a92d81b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-item','data' => ['route' => 'staff.billing','icon' => 'receipt','label' => 'Billing & Invoices']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'staff.billing','icon' => 'receipt','label' => 'Billing & Invoices']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6cced52613a484e7295a90162a92d81b)): ?>
<?php $attributes = $__attributesOriginal6cced52613a484e7295a90162a92d81b; ?>
<?php unset($__attributesOriginal6cced52613a484e7295a90162a92d81b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6cced52613a484e7295a90162a92d81b)): ?>
<?php $component = $__componentOriginal6cced52613a484e7295a90162a92d81b; ?>
<?php unset($__componentOriginal6cced52613a484e7295a90162a92d81b); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal6cced52613a484e7295a90162a92d81b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6cced52613a484e7295a90162a92d81b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-item','data' => ['route' => 'staff.inventory','icon' => 'cube','label' => 'Inventory']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'staff.inventory','icon' => 'cube','label' => 'Inventory']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6cced52613a484e7295a90162a92d81b)): ?>
<?php $attributes = $__attributesOriginal6cced52613a484e7295a90162a92d81b; ?>
<?php unset($__attributesOriginal6cced52613a484e7295a90162a92d81b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6cced52613a484e7295a90162a92d81b)): ?>
<?php $component = $__componentOriginal6cced52613a484e7295a90162a92d81b; ?>
<?php unset($__componentOriginal6cced52613a484e7295a90162a92d81b); ?>
<?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div
    x-data="crudModal({
        storeUrl:  '<?php echo e(route('staff.inventory.items.store')); ?>',
        updateUrl: '<?php echo e(url('staff/inventory/items')); ?>',
        defaults:  { name:'', unit:'pcs', current_stock:0, minimum_stock:5, unit_cost:'', selling_price:'', description:'', is_active:true }
    })"
>


<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Inventory</h1>
        <p class="text-sm text-gray-500 mt-0.5">
            <?php echo e($items->count()); ?> items &middot;
            <span class="text-red-500 font-medium"><?php echo e($items->where('current_stock', '<=', 'minimum_stock')->count()); ?> low stock</span>
        </p>
    </div>
    <button @click="openCreate()" class="btn-primary text-sm">+ Add Item</button>
</div>


<?php $lowStock = $items->filter(fn($i) => $i->current_stock <= $i->minimum_stock); ?>
<?php if($lowStock->count()): ?>
<div class="bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4 mb-5 flex items-center gap-3">
    <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
    </svg>
    <p class="text-sm text-amber-800">
        <strong><?php echo e($lowStock->count()); ?> item(s)</strong> are at or below minimum stock level:
        <?php echo e($lowStock->pluck('name')->join(', ')); ?>.
    </p>
</div>
<?php endif; ?>

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
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $isLow = $item->current_stock <= $item->minimum_stock; ?>
                <tr class="hover:bg-gray-50 transition-colors <?php echo e($isLow ? 'bg-amber-50/30' : ''); ?>">
                    <td class="px-6 py-3.5">
                        <p class="font-medium text-gray-900"><?php echo e($item->name); ?></p>
                        <?php if($item->description): ?>
                            <p class="text-xs text-gray-400 truncate max-w-xs"><?php echo e($item->description); ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-3.5 text-gray-600"><?php echo e($item->unit); ?></td>
                    <td class="px-6 py-3.5">
                        <span class="font-semibold <?php echo e($isLow ? 'text-red-600' : 'text-gray-900'); ?>">
                            <?php echo e(number_format($item->current_stock, 0)); ?>

                        </span>
                        <?php if($isLow): ?>
                            <span class="ml-1 text-xs font-semibold text-amber-600 bg-amber-100 px-1.5 py-0.5 rounded-full">Low</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-3.5 text-gray-500"><?php echo e(number_format($item->minimum_stock, 0)); ?></td>
                    <td class="px-6 py-3.5 text-gray-700">
                        <?php echo e($item->unit_cost ? 'Rs.'.number_format($item->unit_cost, 2) : '—'); ?>

                    </td>
                    <td class="px-6 py-3.5">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                            <?php echo e($item->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500'); ?>">
                            <?php echo e($item->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </td>
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-2">
                            <button
                                @click="openEdit({
                                    id: <?php echo e($item->id); ?>,
                                    name: <?php echo \Illuminate\Support\Js::from($item->name)->toHtml() ?>,
                                    unit: <?php echo \Illuminate\Support\Js::from($item->unit)->toHtml() ?>,
                                    current_stock: <?php echo e($item->current_stock); ?>,
                                    minimum_stock: <?php echo e($item->minimum_stock); ?>,
                                    unit_cost: '<?php echo e($item->unit_cost); ?>',
                                    selling_price: '<?php echo e($item->selling_price); ?>',
                                    description: <?php echo \Illuminate\Support\Js::from($item->description ?? '')->toHtml() ?>,
                                    is_active: <?php echo e($item->is_active ? 'true' : 'false'); ?>

                                })"
                                class="text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition-colors">
                                Edit
                            </button>
                            <button
                                @click="del(<?php echo e($item->id); ?>, '<?php echo e(url('staff/inventory/items')); ?>')"
                                class="text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>


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

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>$(document).ready(function(){ initDT('#inventory-dt', {order:[[0,'asc']]}); });</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dental Managment System\resources\views/staff/inventory.blade.php ENDPATH**/ ?>