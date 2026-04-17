<?php $__env->startSection('title', 'Book an Appointment — SmileCare'); ?>

<?php $__env->startSection('content'); ?>

<section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-12">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h1 class="text-3xl font-bold mb-2">Book an Appointment</h1>
        <p class="text-primary-100">Fill in the details below and our staff will confirm your booking shortly.</p>
    </div>
</section>

<section class="max-w-3xl mx-auto px-4 sm:px-6 py-12">

    <?php if($errors->any()): ?>
        <div class="alert-error mb-6">
            <ul class="list-disc list-inside text-sm space-y-1">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('book.store')); ?>" method="POST"
          x-data="bookingForm()" class="space-y-6">
        <?php echo csrf_field(); ?>

        
        <div class="card p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-5 flex items-center gap-2">
                <span class="w-7 h-7 bg-primary-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</span>
                Choose Service & Doctor
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Service <span class="text-gray-400 font-normal">(optional)</span></label>
                    <select name="service_id" class="form-input" x-model="serviceId">
                        <option value="">— Select a service —</option>
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($service->id); ?>" <?php echo e(old('service_id') == $service->id ? 'selected' : ''); ?>>
                                <?php echo e($service->name); ?>

                                <?php if($service->base_price): ?> (Rs.<?php echo e(number_format($service->base_price, 0)); ?>) <?php endif; ?>
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Doctor <span class="text-red-500">*</span></label>
                    <select name="doctor_id" class="form-input" required x-model="doctorId" @change="fetchSlots()">
                        <option value="">— Select a doctor —</option>
                        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($doctor->id); ?>" <?php echo e(old('doctor_id') == $doctor->id ? 'selected' : ''); ?>>
                                Dr. <?php echo e($doctor->user->name); ?>

                                <?php if($doctor->specialty): ?> — <?php echo e($doctor->specialty); ?> <?php endif; ?>
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>

        
        <div class="card p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-5 flex items-center gap-2">
                <span class="w-7 h-7 bg-primary-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</span>
                Pick a Date & Time
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Date <span class="text-red-500">*</span></label>
                    <input type="date" name="date" class="form-input" required
                           min="<?php echo e(now()->toDateString()); ?>"
                           value="<?php echo e(old('date')); ?>"
                           x-model="selectedDate"
                           @change="fetchSlots()">
                </div>
                <div>
                    <label class="form-label">Time Slot <span class="text-red-500">*</span></label>

                    
                    <div x-show="loadingSlots" class="text-sm text-gray-400 italic py-2">Loading slots...</div>

                    
                    <div x-show="!loadingSlots && slots.length > 0" class="grid grid-cols-3 gap-2">
                        <template x-for="slot in slots" :key="slot.time">
                            <button type="button"
                                    @click="slot.available && (selectedTime = slot.time)"
                                    :disabled="!slot.available"
                                    :class="{
                                        'ring-2 ring-primary-500 bg-primary-50 text-primary-700 font-semibold': selectedTime === slot.time,
                                        'opacity-40 cursor-not-allowed line-through': !slot.available,
                                        'hover:border-primary-400 hover:bg-primary-50': slot.available && selectedTime !== slot.time,
                                    }"
                                    class="px-2 py-2 text-sm border border-gray-200 rounded-lg text-gray-700 transition-all">
                                <span x-text="slot.label"></span>
                            </button>
                        </template>
                    </div>

                    
                    <div x-show="!loadingSlots && slots.length === 0 && selectedDate && doctorId"
                         class="text-sm text-gray-400 italic py-2">
                        No available slots for this date.
                    </div>

                    <div x-show="!doctorId || !selectedDate" class="text-sm text-gray-400 italic py-2">
                        Select a doctor and date to see available slots.
                    </div>

                    
                    <input type="hidden" name="time" :value="selectedTime" required>
                </div>
            </div>
        </div>

        
        <?php if(auth()->guard()->guest()): ?>
        <div class="card p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-5 flex items-center gap-2">
                <span class="w-7 h-7 bg-primary-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</span>
                Your Information
            </h2>
            <p class="text-sm text-gray-500 mb-5">
                Already have an account?
                <a href="<?php echo e(route('login')); ?>?redirect=<?php echo e(urlencode(request()->fullUrl())); ?>" class="text-primary-600 font-medium hover:underline">Sign in</a>
                to book faster.
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">First Name <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" class="form-input" required value="<?php echo e(old('first_name')); ?>" placeholder="Juan">
                    <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="form-label">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" class="form-input" required value="<?php echo e(old('last_name')); ?>" placeholder="Dela Cruz">
                    <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="form-label">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" class="form-input" required value="<?php echo e(old('email')); ?>" placeholder="juan@example.com">
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
                    <label class="form-label">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" class="form-input" required value="<?php echo e(old('phone')); ?>" placeholder="+63 9xx xxx xxxx">
                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        
        <div class="card p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <span class="w-7 h-7 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-sm font-bold"><?php echo e(Auth::check() ? '3' : '4'); ?></span>
                Notes <span class="text-gray-400 font-normal text-sm">(optional)</span>
            </h2>
            <textarea name="notes" rows="3" class="form-input" maxlength="500"
                      placeholder="Any specific concerns or information for the doctor..."><?php echo e(old('notes')); ?></textarea>
        </div>

        <button type="submit"
                :disabled="!selectedTime"
                :class="selectedTime ? 'btn-primary' : 'btn-primary opacity-50 cursor-not-allowed'"
                class="w-full py-3 text-base font-semibold">
            Confirm Booking
        </button>
    </form>
</section>

<?php $__env->startPush('scripts'); ?>
<script>
function bookingForm() {
    return {
        doctorId: '<?php echo e(old('doctor_id')); ?>',
        selectedDate: '<?php echo e(old('date')); ?>',
        serviceId: '<?php echo e(old('service_id')); ?>',
        selectedTime: '<?php echo e(old('time')); ?>',
        slots: [],
        loadingSlots: false,

        async fetchSlots() {
            if (!this.doctorId || !this.selectedDate) return;
            this.loadingSlots = true;
            this.slots = [];
            this.selectedTime = '';
            try {
                const res = await fetch(`<?php echo e(route('book.slots')); ?>?doctor_id=${this.doctorId}&date=${this.selectedDate}`);
                const data = await res.json();
                this.slots = data.slots || [];
            } catch (e) {
                this.slots = [];
            } finally {
                this.loadingSlots = false;
            }
        }
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Dental Managment System\resources\views\public\booking.blade.php ENDPATH**/ ?>