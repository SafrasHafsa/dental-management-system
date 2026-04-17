<?php $__env->startSection('title', 'Appointment ' . $appointment->appointment_number); ?>

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
    <div class="flex items-center gap-3">
        <a href="<?php echo e(route('doctor.appointments')); ?>"
           class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Appointment <?php echo e($appointment->appointment_number); ?></h1>
            <p class="text-sm text-gray-500 mt-0.5"><?php echo e($appointment->appointment_date->format('l, F d Y')); ?></p>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <?php if($appointment->isConfirmed()): ?>
        <form method="POST" action="<?php echo e(route('doctor.appointments.start', $appointment)); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
            <button class="text-sm font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 px-4 py-2 rounded-xl transition-colors">
                Start Session
            </button>
        </form>
        <?php endif; ?>
        <?php if($appointment->isInProgress()): ?>
        <a href="<?php echo e(route('doctor.appointments.notes', $appointment)); ?>"
           class="text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-xl transition-colors">
            Add Clinical Notes
        </a>
        <form method="POST" action="<?php echo e(route('doctor.appointments.complete', $appointment)); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
            <button class="text-sm font-semibold text-white bg-gray-900 hover:bg-gray-700 px-4 py-2 rounded-xl transition-colors">
                Mark Complete
            </button>
        </form>
        <?php endif; ?>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    
    <div class="xl:col-span-2 space-y-5">

        
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-semibold text-gray-900">Appointment Details</h3>
                <span class="<?php echo e($appointment->statusBadgeClass()); ?> text-sm px-3 py-1"><?php echo e($appointment->statusLabel()); ?></span>
            </div>
            <div class="grid grid-cols-2 gap-y-4 gap-x-6">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Date</p>
                    <p class="text-sm font-medium text-gray-900"><?php echo e($appointment->appointment_date->format('M d, Y')); ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Time</p>
                    <p class="text-sm font-medium text-gray-900"><?php echo e(\Carbon\Carbon::parse($appointment->start_time)->format('g:i A')); ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Service</p>
                    <p class="text-sm font-medium text-gray-900"><?php echo e($appointment->service?->name ?? '—'); ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Ref #</p>
                    <p class="text-sm font-mono text-gray-700"><?php echo e($appointment->appointment_number); ?></p>
                </div>
                <?php if($appointment->notes): ?>
                <div class="col-span-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Booking Notes</p>
                    <p class="text-sm text-gray-700"><?php echo e($appointment->notes); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if($appointment->clinicalNotes && $appointment->clinicalNotes->count()): ?>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Clinical Notes</h3>
            <?php $__currentLoopData = $appointment->clinicalNotes->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border border-gray-100 rounded-xl p-4 mb-3 last:mb-0">
                <p class="text-xs text-gray-400 mb-3"><?php echo e($cn->created_at->format('M d, Y g:i A')); ?></p>
                <?php if($cn->chief_complaint): ?>
                <div class="mb-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Chief Complaint</p>
                    <p class="text-sm text-gray-700"><?php echo e($cn->chief_complaint); ?></p>
                </div>
                <?php endif; ?>
                <?php if($cn->diagnosis): ?>
                <div class="mb-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Diagnosis</p>
                    <p class="text-sm text-gray-700"><?php echo e($cn->diagnosis); ?></p>
                </div>
                <?php endif; ?>
                <?php if($cn->treatment): ?>
                <div class="mb-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Treatment Done</p>
                    <p class="text-sm text-gray-700"><?php echo e($cn->treatment); ?></p>
                </div>
                <?php endif; ?>
                <?php if($cn->notes): ?>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Prescriptions / Notes</p>
                    <p class="text-sm text-gray-700"><?php echo e($cn->notes); ?></p>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="space-y-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Patient</h3>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold flex-shrink-0">
                    <?php echo e(strtoupper(substr($appointment->patient->first_name, 0, 1))); ?>

                </div>
                <div>
                    <p class="font-semibold text-gray-900"><?php echo e($appointment->patient->first_name); ?> <?php echo e($appointment->patient->last_name); ?></p>
                    <p class="text-xs text-gray-400"><?php echo e($appointment->patient->patient_number); ?></p>
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Gender</span>
                    <span class="text-gray-900 capitalize"><?php echo e($appointment->patient->gender ?? '—'); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Blood Type</span>
                    <span class="text-gray-900"><?php echo e($appointment->patient->blood_type ?? '—'); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Phone</span>
                    <span class="text-gray-900"><?php echo e($appointment->patient->user?->phone ?? '—'); ?></span>
                </div>
            </div>
            <a href="<?php echo e(route('doctor.patients.show', $appointment->patient)); ?>"
               class="mt-4 flex items-center justify-center gap-2 w-full py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm font-medium text-gray-700 transition-colors">
                Full Profile
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dental Managment System\resources\views\doctor\appointment-show.blade.php ENDPATH**/ ?>