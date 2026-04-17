<?php $__env->startSection('title', 'Sign In'); ?>
<?php $__env->startSection('subtitle', 'Sign in to your account'); ?>

<?php $__env->startSection('content'); ?>
<div class="card-header">
    <h2 class="card-title text-center w-full">Welcome back</h2>
</div>

<?php if(session('status')): ?>
    <div class="alert-success mb-4"><?php echo e(session('status')); ?></div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
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
               placeholder="you@email.com" required autofocus autocomplete="email">
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="form-error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <div class="form-group" x-data="{ show: false }">
        <div class="flex items-center justify-between mb-1">
            <label for="password" class="form-label mb-0">Password</label>
            <a href="<?php echo e(route('password.request')); ?>" class="text-xs text-primary-600 hover:underline">
                Forgot password?
            </a>
        </div>
        <div class="relative">
            <input id="password" :type="show ? 'text' : 'password'" name="password"
                   class="form-input pr-10 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   placeholder="••••••••" required autocomplete="current-password">
            <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600">
                <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                </svg>
            </button>
        </div>
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="form-error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <div class="flex items-center gap-2">
        <input id="remember" type="checkbox" name="remember" value="1"
               class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
        <label for="remember" class="text-sm text-gray-600">Keep me signed in</label>
    </div>

    <button type="submit" class="btn-primary w-full btn-lg">
        Sign In
    </button>
</form>

<div class="mt-6 text-center">
    <p class="text-sm text-gray-500">
        Don't have an account?
        <a href="<?php echo e(route('register')); ?>" class="text-primary-600 font-medium hover:underline">Create one</a>
    </p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dental Managment System\resources\views\auth\login.blade.php ENDPATH**/ ?>