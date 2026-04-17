<?php $__env->startSection('title', 'Staff Dashboard'); ?>

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


<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Welcome Back, <?php echo e(auth()->user()->name); ?>!</h1>
        <p class="text-sm text-gray-500 mt-0.5">Here's today's clinic activity.</p>
    </div>
    <a href="<?php echo e(route('staff.appointments')); ?>" class="btn-primary text-sm">View All Appointments</a>
</div>


<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">

    <div class="bg-amber-50 rounded-2xl p-5 border border-amber-100 shadow-sm">
        <p class="text-sm text-amber-600 mb-3">Pending Approvals</p>
        <p class="text-3xl font-bold text-amber-900"><?php echo e($stats['pending_approvals']); ?></p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-amber-100">
            <?php if($stats['pending_approvals'] > 0): ?>
                <span class="text-xs font-semibold text-amber-600 bg-amber-100 px-2 py-0.5 rounded-full">Needs action</span>
            <?php else: ?>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">All clear</span>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100 shadow-sm">
        <p class="text-sm text-blue-600 mb-3">Today's Appointments</p>
        <p class="text-3xl font-bold text-blue-900"><?php echo e($stats['appointments_today']); ?></p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-blue-100">
            <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full">Today</span>
            <span class="text-xs text-blue-400">scheduled visits</span>
        </div>
    </div>

    <div class="bg-red-50 rounded-2xl p-5 border border-red-100 shadow-sm">
        <p class="text-sm text-red-600 mb-3">Low Stock Items</p>
        <p class="text-3xl font-bold text-red-900"><?php echo e($stats['low_stock_items']); ?></p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-red-100">
            <?php if($stats['low_stock_items'] > 0): ?>
                <span class="text-xs font-semibold text-red-600 bg-red-100 px-2 py-0.5 rounded-full">Reorder needed</span>
            <?php else: ?>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Stock OK</span>
            <?php endif; ?>
        </div>
    </div>

</div>


<div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

    
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Pending Approvals</h3>
            <a href="<?php echo e(route('staff.appointments')); ?>" class="text-sm text-primary-600 hover:underline font-medium">View All</a>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $pendingAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="flex items-center justify-between px-6 py-3.5 <?php echo e(!$loop->last ? 'border-b border-gray-50' : ''); ?> hover:bg-gray-50 transition-colors">
            <div class="min-w-0 flex-1">
                <p class="text-sm font-medium text-gray-900 truncate"><?php echo e($appt->patient->fullName()); ?></p>
                <p class="text-xs text-gray-400 mt-0.5">
                    <?php echo e($appt->appointment_date->format('M d')); ?> &middot; <?php echo e(\Carbon\Carbon::parse($appt->start_time)->format('g:i A')); ?>

                    &middot; <?php echo e($appt->service?->name ?? 'General'); ?>

                </p>
            </div>
            <div class="flex items-center gap-2 ml-4 flex-shrink-0">
                <form method="POST" action="<?php echo e(route('staff.appointments.approve', $appt)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <button class="text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition-colors">Approve</button>
                </form>
                <form method="POST" action="<?php echo e(route('staff.appointments.cancel', $appt)); ?>"
                      x-data="confirmAction('Cancel this appointment?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <button type="button" @click="confirm($el.closest('form'))"
                            class="text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">Reject</button>
                </form>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-10 text-gray-400">
            <svg class="w-8 h-8 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm">No pending approvals.</p>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Today's Schedule</h3>
            <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-full"><?php echo e(today()->format('l, M d')); ?></span>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $todayAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="flex items-center gap-4 px-6 py-3.5 <?php echo e(!$loop->last ? 'border-b border-gray-50' : ''); ?> hover:bg-gray-50 transition-colors">
            <div class="w-12 text-center flex-shrink-0">
                <p class="text-sm font-bold text-primary-600"><?php echo e(\Carbon\Carbon::parse($appt->start_time)->format('g:i')); ?></p>
                <p class="text-xs text-gray-400"><?php echo e(\Carbon\Carbon::parse($appt->start_time)->format('A')); ?></p>
            </div>
            <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs flex-shrink-0">
                <?php echo e(strtoupper(substr($appt->patient->first_name ?? 'P', 0, 1))); ?>

            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate"><?php echo e($appt->patient->fullName()); ?></p>
                <p class="text-xs text-gray-400 truncate">Dr. <?php echo e($appt->doctorProfile->user->name); ?> &middot; <?php echo e($appt->service?->name ?? 'General'); ?></p>
            </div>
            <span class="<?php echo e($appt->statusBadgeClass()); ?>"><?php echo e($appt->statusLabel()); ?></span>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-10 text-gray-400">
            <svg class="w-8 h-8 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm">No appointments scheduled today.</p>
        </div>
        <?php endif; ?>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dental Managment System\resources\views/staff/dashboard.blade.php ENDPATH**/ ?>