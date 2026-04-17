<?php $__env->startSection('title', 'Reset Password'); ?>
<?php $__env->startSection('subtitle', 'We\'ll send you a reset link'); ?>

<?php $__env->startSection('content'); ?>
<div class="card-header">
    <h2 class="card-title text-center w-full">Forgot your password?</h2>
</div>

<p class="text-sm text-gray-500 mb-5 text-center">
    Enter your email and we'll send you a password reset link.
</p>

<?php if(session('status')): ?>
    <div class="alert-success mb-4"><?php echo e(session('status')); ?></div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('password.email')); ?>" class="space-y-5">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label for="email" class="form-label">Email address</label>
        <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>"
               class="form-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               placeholder="you@email.com" required autofocus>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <button type="submit" class="btn-primary w-full btn-lg">Send Reset Link</button>
</form>

<div class="mt-5 text-center">
    <a href="<?php echo e(route('login')); ?>" class="text-sm text-primary-600 hover:underline">Back to sign in</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dental Managment System\resources\views\auth\forgot-password.blade.php ENDPATH**/ ?>