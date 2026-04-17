<?php $__env->startSection('title', $invoice->invoice_number); ?>

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
<div x-data="{ showPayment: false, amount: '<?php echo e($invoice->balance_due); ?>', method: 'cash', ref: '', notes: '', loading: false }">


<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <a href="<?php echo e(route('staff.billing')); ?>" class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-900"><?php echo e($invoice->invoice_number); ?></h1>
            <p class="text-sm text-gray-500 mt-0.5">Issued <?php echo e($invoice->issue_date->format('M d, Y')); ?></p>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <span class="<?php echo e($invoice->statusBadgeClass()); ?> text-sm px-3 py-1"><?php echo e(ucfirst($invoice->status)); ?></span>
        <?php if($invoice->balance_due > 0): ?>
        <button @click="showPayment = true"
                class="btn-primary text-sm">Record Payment</button>
        <?php endif; ?>
        <a href="<?php echo e(route('staff.billing.print', $invoice)); ?>" target="_blank"
           class="text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-xl transition-colors">
            Print
        </a>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    
    <div class="xl:col-span-2 space-y-5">

        
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Bill To</p>
                    <p class="font-semibold text-gray-900 text-lg">
                        <?php echo e($invoice->appointment->patient->first_name); ?> <?php echo e($invoice->appointment->patient->last_name); ?>

                    </p>
                    <p class="text-sm text-gray-500"><?php echo e($invoice->appointment->patient->patient_number); ?></p>
                    <p class="text-sm text-gray-500"><?php echo e($invoice->appointment->patient->user?->phone ?? ''); ?></p>
                    <p class="text-sm text-gray-500"><?php echo e($invoice->appointment->patient->user?->email ?? ''); ?></p>
                </div>
                <div class="text-right">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Invoice Details</p>
                    <p class="text-sm text-gray-700"><span class="text-gray-500">Invoice #:</span> <?php echo e($invoice->invoice_number); ?></p>
                    <p class="text-sm text-gray-700"><span class="text-gray-500">Issue Date:</span> <?php echo e($invoice->issue_date->format('M d, Y')); ?></p>
                    <p class="text-sm text-gray-700"><span class="text-gray-500">Due Date:</span> <?php echo e($invoice->due_date->format('M d, Y')); ?></p>
                    <p class="text-sm text-gray-700"><span class="text-gray-500">Doctor:</span> Dr. <?php echo e($invoice->appointment->doctorProfile->user->name); ?></p>
                </div>
            </div>

            
            <table class="w-full text-sm border-t border-gray-100">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Description</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t border-gray-50">
                        <td class="px-4 py-3 text-gray-900">
                            <?php echo e($invoice->appointment->service?->name ?? 'Dental Consultation'); ?>

                            <p class="text-xs text-gray-400 mt-0.5"><?php echo e($invoice->appointment->appointment_date->format('M d, Y')); ?></p>
                        </td>
                        <td class="px-4 py-3 text-right font-medium text-gray-900">Rs.<?php echo e(number_format($invoice->subtotal, 2)); ?></td>
                    </tr>
                </tbody>
                <tfoot class="border-t border-gray-100">
                    <tr>
                        <td class="px-4 py-2 text-right text-sm text-gray-500">Subtotal</td>
                        <td class="px-4 py-2 text-right text-sm text-gray-900">Rs.<?php echo e(number_format($invoice->subtotal, 2)); ?></td>
                    </tr>
                    <?php if($invoice->tax_amount > 0): ?>
                    <tr>
                        <td class="px-4 py-2 text-right text-sm text-gray-500">Tax (<?php echo e($invoice->tax_rate); ?>%)</td>
                        <td class="px-4 py-2 text-right text-sm text-gray-900">Rs.<?php echo e(number_format($invoice->tax_amount, 2)); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if($invoice->discount_amount > 0): ?>
                    <tr>
                        <td class="px-4 py-2 text-right text-sm text-gray-500">Discount</td>
                        <td class="px-4 py-2 text-right text-sm text-red-600">− Rs.<?php echo e(number_format($invoice->discount_amount, 2)); ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr class="border-t-2 border-gray-200">
                        <td class="px-4 py-3 text-right font-bold text-gray-900">Total</td>
                        <td class="px-4 py-3 text-right font-bold text-gray-900 text-lg">Rs.<?php echo e(number_format($invoice->total_amount, 2)); ?></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 text-right text-sm text-gray-500">Paid</td>
                        <td class="px-4 py-2 text-right text-sm text-emerald-600 font-medium">Rs.<?php echo e(number_format($invoice->paid_amount, 2)); ?></td>
                    </tr>
                    <tr class="bg-<?php echo e($invoice->balance_due > 0 ? 'red' : 'emerald'); ?>-50">
                        <td class="px-4 py-3 text-right font-bold text-<?php echo e($invoice->balance_due > 0 ? 'red' : 'emerald'); ?>-700">Balance Due</td>
                        <td class="px-4 py-3 text-right font-bold text-<?php echo e($invoice->balance_due > 0 ? 'red' : 'emerald'); ?>-700 text-lg">
                            Rs.<?php echo e(number_format($invoice->balance_due, 2)); ?>

                        </td>
                    </tr>
                </tfoot>
            </table>

            <?php if($invoice->notes): ?>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Notes</p>
                <p class="text-sm text-gray-700"><?php echo e($invoice->notes); ?></p>
            </div>
            <?php endif; ?>
        </div>

        
        <?php if($invoice->payments->count()): ?>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Payment History</h3>
            <div class="space-y-3">
                <?php $__currentLoopData = $invoice->payments->sortByDesc('payment_date'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center justify-between py-2 <?php echo e(!$loop->last ? 'border-b border-gray-50' : ''); ?>">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Rs.<?php echo e(number_format($payment->amount, 2)); ?></p>
                        <p class="text-xs text-gray-400">
                            <?php echo e($payment->payment_date->format('M d, Y g:i A')); ?>

                            · <?php echo e(ucfirst(str_replace('_', ' ', $payment->payment_method))); ?>

                            <?php if($payment->reference_number): ?>
                                · Ref: <?php echo e($payment->reference_number); ?>

                            <?php endif; ?>
                        </p>
                    </div>
                    <span class="text-xs font-semibold bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">Received</span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="space-y-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Summary</h3>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total</span>
                    <span class="font-bold text-gray-900">Rs.<?php echo e(number_format($invoice->total_amount, 2)); ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Paid</span>
                    <span class="font-medium text-emerald-600">Rs.<?php echo e(number_format($invoice->paid_amount, 2)); ?></span>
                </div>
                <div class="border-t border-gray-100 pt-3 flex justify-between">
                    <span class="font-semibold text-gray-900">Balance Due</span>
                    <span class="font-bold text-lg <?php echo e($invoice->balance_due > 0 ? 'text-red-600' : 'text-emerald-600'); ?>">
                        Rs.<?php echo e(number_format($invoice->balance_due, 2)); ?>

                    </span>
                </div>
            </div>
            <?php if($invoice->balance_due > 0): ?>
            <button @click="showPayment = true"
                    class="mt-5 w-full py-2.5 bg-gray-950 hover:bg-gray-800 text-white text-sm font-semibold rounded-xl transition-colors">
                Record Payment
            </button>
            <?php else: ?>
            <div class="mt-5 flex items-center justify-center gap-2 py-2.5 bg-emerald-50 rounded-xl">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-sm font-semibold text-emerald-700">Fully Paid</span>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<div x-show="showPayment" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-black/50" @click="showPayment = false"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md mx-auto"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Record Payment</h3>
            <button @click="showPayment = false" class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="<?php echo e(route('staff.billing.payment', $invoice)); ?>" class="px-6 py-5 space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    Amount (Rs.) <span class="text-red-500">*</span>
                    <span class="text-gray-400 font-normal">— Balance: Rs.<?php echo e(number_format($invoice->balance_due, 2)); ?></span>
                </label>
                <input type="number" name="amount" step="0.01" min="0.01"
                       x-model="amount" required
                       class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                       placeholder="0.00">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Payment Method <span class="text-red-500">*</span></label>
                <select name="payment_method" x-model="method" required
                        class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="insurance">Insurance</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Reference Number</label>
                <input type="text" name="reference_number" x-model="ref"
                       class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                       placeholder="Receipt / transaction ID (optional)">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Notes</label>
                <textarea name="notes" x-model="notes" rows="2"
                          class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                          placeholder="Optional notes…"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" @click="showPayment = false"
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Cancel</button>
                <button type="submit"
                        class="px-4 py-2 text-sm font-semibold text-white bg-gray-950 hover:bg-gray-800 rounded-xl transition-colors min-w-[120px]">
                    Record Payment
                </button>
            </div>
        </form>
    </div>
</div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dental Managment System\resources\views\staff\billing-show.blade.php ENDPATH**/ ?>