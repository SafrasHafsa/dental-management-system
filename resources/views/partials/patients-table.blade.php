{{-- Shared patients DataTable with create/edit modal --}}
{{-- Variables: $role, $storeUrl, $updateUrl, $deleteUrl, $showRoute --}}
<div
    x-data="crudModal({
        storeUrl:  '{{ $storeUrl }}',
        updateUrl: '{{ $updateUrl }}',
        defaults:  { first_name:'', last_name:'', date_of_birth:'', gender:'', blood_type:'', phone:'', notes:'' }
    })"
>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Patients</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $patients->count() }} registered patients</p>
    </div>
    <button @click="openCreate()" class="btn-primary text-sm">+ New Patient</button>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table id="patients-dt" class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Patient #</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Gender</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date of Birth</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($patients as $patient)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3.5">
                        <span class="font-mono text-xs text-primary-700 bg-primary-50 px-2 py-0.5 rounded-full">
                            {{ $patient->patient_number }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs flex-shrink-0">
                                {{ strtoupper(substr($patient->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                                <p class="text-xs text-gray-400">{{ $patient->user?->email ?? '—' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3.5 text-gray-600 capitalize">{{ $patient->gender ?? '—' }}</td>
                    <td class="px-6 py-3.5 text-gray-600">
                        {{ $patient->date_of_birth ? $patient->date_of_birth->format('M d, Y') : '—' }}
                    </td>
                    <td class="px-6 py-3.5 text-gray-600">{{ $patient->user?->phone ?? '—' }}</td>
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-2">
                            <a href="{{ route($showRoute, $patient) }}"
                               class="text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                View
                            </a>
                            <button
                                @click="openEdit({
                                    id: '{{ $patient->id }}',
                                    first_name: @js($patient->first_name),
                                    last_name: @js($patient->last_name),
                                    date_of_birth: '{{ $patient->date_of_birth?->format('Y-m-d') ?? '' }}',
                                    gender: @js($patient->gender ?? ''),
                                    blood_type: @js($patient->blood_type ?? ''),
                                    phone: @js($patient->user?->phone ?? ''),
                                    notes: @js($patient->notes ?? '')
                                })"
                                class="text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition-colors">
                                Edit
                            </button>
                            <button
                                @click="del('{{ $patient->id }}', '{{ $deleteUrl }}')"
                                class="text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal --}}
<div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-black/50" @click="close()"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg mx-auto overflow-y-auto max-h-[90vh]"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900" x-text="mode==='create' ? 'Register New Patient' : 'Edit Patient'"></h3>
            <button @click="close()" class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form @submit.prevent="submit()" class="px-6 py-5 space-y-4">
            <div x-show="Object.keys(errors).length > 0"
                 class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-600">
                Please correct the errors below.
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">First Name <span class="text-red-500">*</span></label>
                    <input x-model="form.first_name" type="text" placeholder="First name"
                           class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           :class="errors.first_name ? 'border-red-300' : 'border-gray-200'">
                    <p x-show="errors.first_name" x-text="errors.first_name?.[0]" class="text-xs text-red-500 mt-1"></p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Last Name <span class="text-red-500">*</span></label>
                    <input x-model="form.last_name" type="text" placeholder="Last name"
                           class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                           :class="errors.last_name ? 'border-red-300' : 'border-gray-200'">
                    <p x-show="errors.last_name" x-text="errors.last_name?.[0]" class="text-xs text-red-500 mt-1"></p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Date of Birth</label>
                    <input x-model="form.date_of_birth" type="date"
                           class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Gender</label>
                    <select x-model="form.gender" class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                        <option value="">— Select —</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Blood Type</label>
                    <select x-model="form.blood_type" class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">
                        <option value="">— Unknown —</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
                        <option value="{{ $bt }}">{{ $bt }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Phone</label>
                    <input x-model="form.phone" type="text" placeholder="+94 77 000 0000"
                           class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Notes</label>
                <textarea x-model="form.notes" rows="2" placeholder="Allergies, special conditions…"
                          class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 resize-none"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" @click="close()" class="px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Cancel</button>
                <button type="submit" :disabled="loading" class="px-4 py-2 text-sm font-semibold text-white bg-gray-950 hover:bg-gray-800 rounded-xl transition-colors disabled:opacity-50 min-w-[110px]">
                    <span x-show="!loading" x-text="mode==='create' ? 'Register Patient' : 'Save Changes'"></span>
                    <span x-show="loading">Saving…</span>
                </button>
            </div>
        </form>
    </div>
</div>
{{-- Delete Confirmation Modal --}}
<div x-show="showDeleteModal" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-black/50" @click="showDeleteModal = false"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm mx-auto p-6"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        {{-- Icon --}}
        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        {{-- Content --}}
        <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Delete Patient</h3>
        <p class="text-sm text-gray-500 text-center mb-6">
            Are you sure you want to delete this patient?
            <br>This action <span class="font-semibold text-red-600">cannot be undone</span>.
        </p>
        {{-- Buttons --}}
        <div class="flex gap-3">
            <button type="button"
                    @click="showDeleteModal = false"
                    class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                Cancel
            </button>
            <button type="button"
                    @click="confirmDelete()"
                    class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors">
                Yes, Delete
            </button>
        </div>
    </div>
</div>

</div>
