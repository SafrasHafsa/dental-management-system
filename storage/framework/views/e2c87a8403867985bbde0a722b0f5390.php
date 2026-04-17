<?php $__env->startSection('title', 'Booking Confirmed — SmileCare'); ?>

<?php $__env->startSection('content'); ?>
<section class="max-w-2xl mx-auto px-4 py-20 text-center">
    <div class="card p-10">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">
            <svg class="w-9 h-9 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Booking Submitted!</h1>
        <p class="text-gray-500 mb-8">
            Your appointment request has been received and is <strong>awaiting confirmation</strong> from our staff.
            We'll notify you once it's approved.
        </p>

        <div class="bg-gray-50 rounded-xl p-5 text-left space-y-3 mb-8">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Booking #</span>
                <span class="font-semibold text-gray-900"><?php echo e($appointment->appointment_number); ?></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Doctor</span>
                <span class="font-medium text-gray-800">Dr. <?php echo e($appointment->doctorProfile->user->name); ?></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Date</span>
                <span class="font-medium text-gray-800"><?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y')); ?></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Time</span>
                <span class="font-medium text-gray-800"><?php echo e(\Carbon\Carbon::parse($appointment->start_time)->format('g:i A')); ?></span>
            </div>
            <?php if($appointment->service): ?>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Service</span>
                <span class="font-medium text-gray-800"><?php echo e($appointment->service->name); ?></span>
            </div>
            <?php endif; ?>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Status</span>
                <span class="<?php echo e($appointment->statusBadgeClass()); ?>"><?php echo e($appointment->statusLabel()); ?></span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="<?php echo e(route('home')); ?>" class="btn-secondary">Back to Home</a>
            <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(auth()->user()->dashboardRoute()); ?>" class="btn-primary">View My Appointments</a>
            <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="btn-primary">Sign In to Track</a>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dental Managment System\resources\views\public\booking-confirm.blade.php ENDPATH**/ ?>