<?php $__env->startSection('title', 'Doctor Dashboard'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
    <div class="mb-4">
        <p class="px-3 mb-2 text-xs font-semibold text-gray-600 uppercase tracking-wider">My Clinic</p>
        <?php if (isset($component)) { $__componentOriginal6cced52613a484e7295a90162a92d81b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6cced52613a484e7295a90162a92d81b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-item','data' => ['route' => 'doctor.dashboard','icon' => 'home','label' => 'Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'doctor.dashboard','icon' => 'home','label' => 'Dashboard']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-item','data' => ['route' => 'doctor.appointments','icon' => 'calendar','label' => 'My Schedule']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'doctor.appointments','icon' => 'calendar','label' => 'My Schedule']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-item','data' => ['route' => 'doctor.patients','icon' => 'users','label' => 'My Patients']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'doctor.patients','icon' => 'users','label' => 'My Patients']); ?>
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
        <h1 class="text-xl font-bold text-gray-900">Good <?php echo e(now()->hour < 12 ? 'Morning' : (now()->hour < 18 ? 'Afternoon' : 'Evening')); ?>, Dr. <?php echo e(auth()->user()->name); ?>!</h1>
        <p class="text-sm text-gray-500 mt-0.5">Here's your schedule for today.</p>
    </div>
    <a href="<?php echo e(route('doctor.appointments')); ?>" class="btn-primary text-sm">View Full Schedule</a>
</div>


<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

    <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100 shadow-sm">
        <p class="text-sm text-blue-600 mb-3">Today's Patients</p>
        <p class="text-3xl font-bold text-blue-900"><?php echo e($stats['appointments_today']); ?></p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-blue-100">
            <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full">Today</span>
            <span class="text-xs text-blue-400">scheduled</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <p class="text-sm text-gray-500 mb-3">This Week</p>
        <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['upcoming_week']); ?></p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100">
            <span class="text-xs font-semibold text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full">Upcoming</span>
            <span class="text-xs text-gray-400">appointments</span>
        </div>
    </div>

    <div class="bg-emerald-50 rounded-2xl p-5 border border-emerald-100 shadow-sm">
        <p class="text-sm text-emerald-600 mb-3">Completed</p>
        <p class="text-3xl font-bold text-emerald-900"><?php echo e($stats['completed_this_month']); ?></p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-emerald-100">
            <span class="text-xs font-semibold text-emerald-600 bg-emerald-100 px-2 py-0.5 rounded-full"><?php echo e(now()->format('M Y')); ?></span>
            <span class="text-xs text-emerald-400">this month</span>
        </div>
    </div>

    <div class="bg-amber-50 rounded-2xl p-5 border border-amber-100 shadow-sm">
        <p class="text-sm text-amber-600 mb-3">Notes Pending</p>
        <p class="text-3xl font-bold text-amber-900"><?php echo e($stats['pending_notes']); ?></p>
        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-amber-100">
            <?php if($stats['pending_notes'] > 0): ?>
                <span class="text-xs font-semibold text-amber-600 bg-amber-100 px-2 py-0.5 rounded-full">Needs action</span>
            <?php else: ?>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">All complete</span>
            <?php endif; ?>
        </div>
    </div>

</div>


<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    
    <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Today's Patients</h3>
            <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-full"><?php echo e(today()->format('l, M d')); ?></span>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $todayAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="flex items-center gap-4 px-6 py-4 <?php echo e(!$loop->last ? 'border-b border-gray-50' : ''); ?> hover:bg-gray-50 transition-colors">
            <div class="w-12 text-center flex-shrink-0">
                <p class="text-sm font-bold text-primary-600"><?php echo e(\Carbon\Carbon::parse($appt->start_time)->format('g:i')); ?></p>
                <p class="text-xs text-gray-400"><?php echo e(\Carbon\Carbon::parse($appt->start_time)->format('A')); ?></p>
            </div>
            <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs flex-shrink-0">
                <?php echo e(strtoupper(substr($appt->patient->first_name ?? 'P', 0, 1))); ?>

            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900"><?php echo e($appt->patient->fullName()); ?></p>
                <p class="text-xs text-gray-400 mt-0.5"><?php echo e($appt->service?->name ?? 'General'); ?> &middot; <?php echo e($appt->appointment_number); ?></p>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <span class="<?php echo e($appt->statusBadgeClass()); ?>"><?php echo e($appt->statusLabel()); ?></span>
                <?php if($appt->isConfirmed()): ?>
                    <form method="POST" action="<?php echo e(route('doctor.appointments.start', $appt)); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button class="text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 px-3 py-1.5 rounded-lg transition-colors">Start</button>
                    </form>
                <?php elseif($appt->isInProgress()): ?>
                    <a href="<?php echo e(route('doctor.appointments.notes', $appt)); ?>"
                       class="text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition-colors">Add Notes</a>
                <?php elseif($appt->isCompleted() && !$appt->clinicalNote): ?>
                    <a href="<?php echo e(route('doctor.appointments.notes', $appt)); ?>"
                       class="text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition-colors">Add Notes</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-12 text-gray-400">
            <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm">No patients scheduled for today.</p>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Upcoming</h3>
            <p class="text-xs text-gray-400 mt-0.5">Next appointments</p>
        </div>
        <div class="flex-1 divide-y divide-gray-50">
            <?php $__empty_1 = true; $__currentLoopData = $upcomingAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="px-6 py-3.5 hover:bg-gray-50 transition-colors">
                <p class="text-sm font-medium text-gray-900"><?php echo e($appt->patient->fullName()); ?></p>
                <p class="text-xs text-gray-400 mt-0.5">
                    <?php echo e($appt->appointment_date->format('M d')); ?> at <?php echo e(\Carbon\Carbon::parse($appt->start_time)->format('g:i A')); ?>

                </p>
                <?php if($appt->service): ?>
                    <p class="text-xs text-primary-600 mt-0.5"><?php echo e($appt->service->name); ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-10 text-gray-400 px-6">
                <p class="text-sm">No upcoming appointments.</p>
            </div>
            <?php endif; ?>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            <a href="<?php echo e(route('doctor.appointments')); ?>"
               class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-gray-950 text-white text-sm font-semibold hover:bg-gray-800 transition-colors">
                Full Schedule
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dental Managment System\resources\views\doctor\dashboard.blade.php ENDPATH**/ ?>