<?php $__env->startSection('title', 'Reset Password'); ?>

<?php $__env->startSection('content'); ?>
<div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-12 h-12 bg-primary-100 rounded-xl mb-3">
        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
        </svg>
    </div>
    <h1 class="text-2xl font-bold text-gray-900">Set New Password</h1>
    <p class="text-gray-500 text-sm mt-1">Enter your new password below.</p>
</div>

<form method="POST" action="<?php echo e(route('password.update')); ?>" class="space-y-5">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="token" value="<?php echo e($token); ?>">

    <div>
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-input"
               value="<?php echo e(old('email', request()->email)); ?>" required autofocus>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label class="form-label">New Password</label>
        <input type="password" name="password" class="form-input" required autocomplete="new-password">
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label class="form-label">Confirm New Password</label>
        <input type="password" name="password_confirmation" class="form-input" required autocomplete="new-password">
    </div>

    <button type="submit" class="btn-primary w-full py-2.5">Reset Password</button>
</form>

<p class="text-center text-sm text-gray-500 mt-6">
    Remembered your password?
    <a href="<?php echo e(route('login')); ?>" class="text-primary-600 font-medium hover:underline">Sign in</a>
</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dental Managment System\resources\views\auth\reset-password.blade.php ENDPATH**/ ?>