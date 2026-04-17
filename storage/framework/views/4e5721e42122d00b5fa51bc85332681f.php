


<div x-data="apptModal('<?php echo e($storeRoute ?? ''); ?>')" @keydown.escape.window="close()">

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Appointments</h1>
        <p class="text-sm text-gray-500 mt-0.5"><?php echo e($appointments->count()); ?> total appointments</p>
    </div>
    <?php if(isset($storeRoute)): ?>
    <button @click="open()" class="text-sm font-semibold text-white bg-gray-950 hover:bg-gray-800 px-4 py-2 rounded-xl transition-colors">
        + New Appointment
    </button>
    <?php endif; ?>
</div>


<div class="flex flex-wrap gap-2 mb-4" id="status-filters">
    <button onclick="filterStatus('all')" data-status="all"
            class="filter-btn active text-xs font-semibold px-3 py-1.5 rounded-full bg-gray-900 text-white transition-colors">
        All
    </button>
    <?php $__currentLoopData = ['pending'=>'Pending','confirmed'=>'Confirmed','in_progress'=>'In Progress','completed'=>'Completed','cancelled'=>'Cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <button onclick="filterStatus('<?php echo e($val); ?>')" data-status="<?php echo e($val); ?>"
            class="filter-btn text-xs font-semibold px-3 py-1.5 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">
        <?php echo e($label); ?>

    </button>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table id="appts-dt" class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Patient</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Doctor</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date & Time</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50 transition-colors" data-status="<?php echo e($appt->status); ?>">
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs flex-shrink-0">
                                <?php echo e(strtoupper(substr($appt->patient->first_name ?? 'P', 0, 1))); ?>

                            </div>
                            <div>
                                <p class="font-medium text-gray-900"><?php echo e($appt->patient->first_name); ?> <?php echo e($appt->patient->last_name); ?></p>
                                <p class="text-xs text-gray-400"><?php echo e($appt->patient->patient_number); ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3.5 text-gray-600">Dr. <?php echo e($appt->doctorProfile->user->name); ?></td>
                    <td class="px-6 py-3.5 text-gray-500"><?php echo e($appt->service?->name ?? '—'); ?></td>
                    <td class="px-6 py-3.5">
                        <p class="font-medium text-gray-700"><?php echo e($appt->appointment_date->format('M d, Y')); ?></p>
                        <p class="text-xs text-gray-400"><?php echo e(\Carbon\Carbon::parse($appt->start_time)->format('g:i A')); ?></p>
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="<?php echo e($appt->statusBadgeClass()); ?>"><?php echo e($appt->statusLabel()); ?></span>
                    </td>
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-2">
                            <a href="<?php echo e(route($showRoute, $appt)); ?>"
                               class="text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                View
                            </a>
                            <?php if(isset($canApprove) && $canApprove && $appt->isPending()): ?>
                            <form method="POST" action="<?php echo e(route($approveRoute, $appt)); ?>" class="inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button class="text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition-colors">
                                    Approve
                                </button>
                            </form>
                            <?php endif; ?>
                            <?php if(isset($canApprove) && $canApprove && !$appt->isCancelled() && !$appt->isCompleted()): ?>
                            <form method="POST" action="<?php echo e(route($cancelRoute, $appt)); ?>"
                                  x-data="confirmAction('Cancel this appointment?')" class="inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button type="button" @click="confirm($el.closest('form'))"
                                        class="text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                    Cancel
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>


<?php if(isset($storeRoute)): ?>
<div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-black/50" @click="close()"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg mx-auto overflow-y-auto max-h-[90vh]"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">New Appointment</h3>
            <button @click="close()" class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form @submit.prevent="submit()" class="px-6 py-5 space-y-4">
            <div x-show="Object.keys(errors).length > 0" class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-600">
                Please correct the errors below.
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Patient <span class="text-red-500">*</span></label>
                <select x-model="form.patient_id"
                        class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                        :class="errors.patient_id ? 'border-red-300' : 'border-gray-200'">
                    <option value="">— Select Patient —</option>
                    <?php $__currentLoopData = $patients ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($p->id); ?>"><?php echo e($p->first_name); ?> <?php echo e($p->last_name); ?> (<?php echo e($p->patient_number); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p x-show="errors.patient_id" x-text="errors.patient_id?.[0]" class="text-xs text-red-500 mt-1"></p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Doctor <span class="text-red-500">*</span></label>
                <select x-model="form.doctor_profile_id"
                        class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                        :class="errors.doctor_profile_id ? 'border-red-300' : 'border-gray-200'">
                    <option value="">— Select Doctor —</option>
                    <?php $__currentLoopData = $doctors ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($d->id); ?>">Dr. <?php echo e($d->user->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p x-show="errors.doctor_profile_id" x-text="errors.doctor_profile_id?.[0]" class="text-xs text-red-500 mt-1"></p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Service</label>
                <select x-model="form.service_id"
                        class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">— None / General —</option>
                    <?php $__currentLoopData = $services ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Date <span class="text-red-500">*</span></label>
                    <input type="date" x-model="form.appointment_date"
                           :min="today"
                           class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           :class="errors.appointment_date ? 'border-red-300' : 'border-gray-200'">
                    <p x-show="errors.appointment_date" x-text="errors.appointment_date?.[0]" class="text-xs text-red-500 mt-1"></p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Time <span class="text-red-500">*</span></label>
                    <input type="time" x-model="form.start_time"
                           class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           :class="errors.start_time ? 'border-red-300' : 'border-gray-200'">
                    <p x-show="errors.start_time" x-text="errors.start_time?.[0]" class="text-xs text-red-500 mt-1"></p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Notes</label>
                <textarea x-model="form.notes" rows="2"
                          class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"
                          placeholder="Optional notes…"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" @click="close()"
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit" :disabled="loading"
                        class="px-4 py-2 text-sm font-semibold text-white bg-gray-950 hover:bg-gray-800 rounded-xl transition-colors disabled:opacity-50 min-w-[140px]">
                    <span x-show="!loading">Book Appointment</span>
                    <span x-show="loading">Saving…</span>
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
var apptTable;
$(document).ready(function () {
    apptTable = initDT('#appts-dt', { order: [[3,'desc']] });
});

function filterStatus(status) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.toggle('bg-gray-900', btn.dataset.status === status);
        btn.classList.toggle('text-white',  btn.dataset.status === status);
        btn.classList.toggle('bg-gray-100', btn.dataset.status !== status);
        btn.classList.toggle('text-gray-600',btn.dataset.status !== status);
    });
    if (apptTable) {
        apptTable.column(4).search(status === 'all' ? '' : status, false, false).draw();
    }
}

document.addEventListener('alpine:init', () => {
    Alpine.data('apptModal', (storeUrl) => ({
        showModal: false,
        form: { patient_id:'', doctor_profile_id:'', service_id:'', appointment_date:'', start_time:'', notes:'' },
        errors: {},
        loading: false,
        today: new Date().toISOString().split('T')[0],

        open() {
            this.form = { patient_id:'', doctor_profile_id:'', service_id:'', appointment_date:'', start_time:'', notes:'' };
            this.errors = {};
            this.showModal = true;
        },
        close() { this.showModal = false; },

        async submit() {
            this.loading = true;
            this.errors  = {};
            try {
                const res = await fetch(storeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(this.form),
                });
                const data = await res.json();
                if (res.status === 422) { this.errors = data.errors; return; }
                if (res.ok) { location.reload(); }
            } finally {
                this.loading = false;
            }
        },
    }));
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\Dental Managment System\resources\views/partials/appointments-table.blade.php ENDPATH**/ ?>