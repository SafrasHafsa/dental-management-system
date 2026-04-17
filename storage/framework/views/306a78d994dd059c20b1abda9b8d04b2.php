<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'SmileCare Dental Clinic'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', 'Professional dental care for the whole family.'); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-white text-gray-900" x-data="sidebar()">

    
    <nav class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 bg-primary-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4.5 12.5c0-4.142 3.358-7.5 7.5-7.5s7.5 3.358 7.5 7.5c0 1.818-.648 3.484-1.716 4.784M12 17v4m0 0H9m3 0h3"/>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-gray-900">SmileCare</span>
                </a>

                
                <div class="hidden md:flex items-center gap-8">
                    <a href="<?php echo e(route('home')); ?>" class="text-sm font-medium text-gray-600 hover:text-primary-600 transition-colors">Home</a>
                    <a href="<?php echo e(route('services')); ?>" class="text-sm font-medium text-gray-600 hover:text-primary-600 transition-colors">Services</a>
                    <a href="<?php echo e(route('about')); ?>" class="text-sm font-medium text-gray-600 hover:text-primary-600 transition-colors">About</a>
                    <a href="<?php echo e(route('contact')); ?>" class="text-sm font-medium text-gray-600 hover:text-primary-600 transition-colors">Contact</a>
                </div>

                
                <div class="hidden md:flex items-center gap-3">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(auth()->user()->dashboardRoute()); ?>" class="btn-primary btn-sm">
                            My Dashboard
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-gray-600 hover:text-primary-600">Sign In</a>
                        <a href="<?php echo e(route('book.index')); ?>" class="btn-primary btn-sm">Book Appointment</a>
                    <?php endif; ?>
                </div>

                
                <button @click="toggle()" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        
        <div x-show="open" x-collapse class="md:hidden border-t border-gray-100">
            <div class="px-4 py-3 space-y-1">
                <a href="<?php echo e(route('home')); ?>" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Home</a>
                <a href="<?php echo e(route('services')); ?>" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Services</a>
                <a href="<?php echo e(route('about')); ?>" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">About</a>
                <a href="<?php echo e(route('contact')); ?>" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Contact</a>
                <div class="pt-2 border-t border-gray-100 flex flex-col gap-2">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(auth()->user()->dashboardRoute()); ?>" class="btn-primary">My Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn-secondary">Sign In</a>
                        <a href="<?php echo e(route('book.index')); ?>" class="btn-primary">Book Appointment</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    
    <?php if(session('success')): ?>
        <div x-data="flash()" x-show="show" x-transition class="fixed top-4 right-4 z-50 max-w-sm">
            <div class="alert-success shadow-lg rounded-xl">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span><?php echo e(session('success')); ?></span>
            </div>
        </div>
    <?php endif; ?>

    
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4.5 12.5c0-4.142 3.358-7.5 7.5-7.5s7.5 3.358 7.5 7.5c0 1.818-.648 3.484-1.716 4.784M12 17v4"/>
                            </svg>
                        </div>
                        <span class="text-white font-bold">SmileCare</span>
                    </div>
                    <p class="text-sm text-gray-400 max-w-xs">Professional dental care delivered with compassion. Your healthy smile is our mission.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-3">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?php echo e(route('services')); ?>" class="hover:text-white transition-colors">Services</a></li>
                        <li><a href="<?php echo e(route('about')); ?>" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="<?php echo e(route('contact')); ?>" class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="<?php echo e(route('book.index')); ?>" class="hover:text-white transition-colors">Book Appointment</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-3">Contact</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>123 Mabini St., Manila</li>
                        <li>+63 2 8123-4567</li>
                        <li>info@smilecare.ph</li>
                        <li>Mon–Sat: 8AM – 5PM</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-xs text-gray-500">
                &copy; <?php echo e(date('Y')); ?> SmileCare Dental Clinic. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
<?php /**PATH D:\Dental Managment System\resources\views\layouts\public.blade.php ENDPATH**/ ?>