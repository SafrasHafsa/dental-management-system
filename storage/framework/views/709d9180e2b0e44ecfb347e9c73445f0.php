<?php $__env->startSection('title', 'Contact Us — SmileCare Dental Clinic'); ?>

<?php $__env->startSection('content'); ?>

<section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-3">Contact Us</h1>
        <p class="text-primary-100 max-w-xl mx-auto">We'd love to hear from you. Reach out to schedule an appointment or ask us anything.</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        
        <div class="space-y-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-6">Get in Touch</h2>
            </div>
            <?php $__currentLoopData = [
                ['Location', '123 Mabini St., Ermita, Manila 1000', 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', 'bg-primary-50 text-primary-600'],
                ['Phone', '+63 2 8123-4567', 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'bg-green-50 text-green-600'],
                ['Email', 'info@smilecare.ph', 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'bg-purple-50 text-purple-600'],
                ['Hours', 'Mon–Sat: 8:00 AM – 5:00 PM', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'bg-orange-50 text-orange-600'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value, $icon, $colors]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 <?php echo e($colors); ?> rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($icon); ?>"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-0.5"><?php echo e($label); ?></p>
                    <p class="text-gray-700"><?php echo e($value); ?></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="pt-4">
                <a href="<?php echo e(route('book.index')); ?>" class="btn-primary w-full text-center">
                    Book an Appointment
                </a>
            </div>
        </div>

        
        <div class="lg:col-span-2 card p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Send a Message</h2>
            <form class="space-y-5" x-data="{ sent: false }" @submit.prevent="sent = true">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-input" placeholder="Juan">
                    </div>
                    <div>
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-input" placeholder="Dela Cruz">
                    </div>
                </div>
                <div>
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-input" placeholder="juan@example.com">
                </div>
                <div>
                    <label class="form-label">Subject</label>
                    <input type="text" class="form-input" placeholder="How can we help you?">
                </div>
                <div>
                    <label class="form-label">Message</label>
                    <textarea rows="5" class="form-input" placeholder="Write your message here..."></textarea>
                </div>
                <div x-show="!sent">
                    <button type="submit" class="btn-primary w-full">Send Message</button>
                </div>
                <div x-show="sent" class="alert-success">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Thank you! We'll get back to you within 24 hours.</span>
                </div>
            </form>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dental Managment System\resources\views\public\contact.blade.php ENDPATH**/ ?>