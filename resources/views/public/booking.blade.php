@extends('layouts.public')

@section('title', 'Book an Appointment — City Dental Surgery')

@section('content')

<section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-12">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h1 class="text-3xl font-bold mb-2">Book an Appointment</h1>
        <p class="text-primary-100">Fill in the details below and our staff will confirm your booking shortly.</p>
    </div>
</section>

<section class="max-w-3xl mx-auto px-4 sm:px-6 py-12">

    @if($errors->any())
        <div class="alert-error mb-6">
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('book.store') }}" method="POST"
          x-data="bookingForm()" class="space-y-6">
        @csrf

        {{-- Step 1: Service & Doctor --}}
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
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                                @if($service->base_price) (Rs.{{ number_format($service->base_price, 0) }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Doctor <span class="text-red-500">*</span></label>
                    <select name="doctor_id" class="form-input" required x-model="doctorId" @change="fetchSlots()">
                        <option value="">— Select a doctor —</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                Dr. {{ $doctor->user->name }}
                                @if($doctor->specialty) — {{ $doctor->specialty }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Step 2: Date & Time --}}
        <div class="card p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-5 flex items-center gap-2">
                <span class="w-7 h-7 bg-primary-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</span>
                Pick a Date & Time
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Date <span class="text-red-500">*</span></label>
                    <input type="date" name="date" class="form-input" required
                           min="{{ now()->toDateString() }}"
                           value="{{ old('date') }}"
                           x-model="selectedDate"
                           @change="fetchSlots()">
                </div>
                <div>
                    <label class="form-label">Time Slot <span class="text-red-500">*</span></label>

                    {{-- Loading state --}}
                    <div x-show="loadingSlots" class="text-sm text-gray-400 italic py-2">Loading slots...</div>

                    {{-- Slot grid --}}
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

                    {{-- Empty state --}}
                    <div x-show="!loadingSlots && slots.length === 0 && selectedDate && doctorId"
                         class="text-sm text-gray-400 italic py-2">
                        No available slots for this date.
                    </div>

                    <div x-show="!doctorId || !selectedDate" class="text-sm text-gray-400 italic py-2">
                        Select a doctor and date to see available slots.
                    </div>

                    {{-- Hidden input for selected time --}}
                    <input type="hidden" name="time" :value="selectedTime" required>
                </div>
            </div>
        </div>

        {{-- Step 3: Your info (guest only) --}}
        @guest
        <div class="card p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-5 flex items-center gap-2">
                <span class="w-7 h-7 bg-primary-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</span>
                Your Information
            </h2>
            <p class="text-sm text-gray-500 mb-5">
                Already have an account?
                <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="text-primary-600 font-medium hover:underline">Sign in</a>
                to book faster.
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">First Name <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" class="form-input" required value="{{ old('first_name') }}" placeholder="Juan">
                    @error('first_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" class="form-input" required value="{{ old('last_name') }}" placeholder="Dela Cruz">
                    @error('last_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" class="form-input" required value="{{ old('email') }}" placeholder="juan@example.com">
                    @error('email')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" class="form-input" required value="{{ old('phone') }}" placeholder="+63 9xx xxx xxxx">
                    @error('phone')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
        @endguest

        {{-- Notes --}}
        <div class="card p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <span class="w-7 h-7 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-sm font-bold">{{ Auth::check() ? '3' : '4' }}</span>
                Notes <span class="text-gray-400 font-normal text-sm">(optional)</span>
            </h2>
            <textarea name="notes" rows="3" class="form-input" maxlength="500"
                      placeholder="Any specific concerns or information for the doctor...">{{ old('notes') }}</textarea>
        </div>

        <button type="submit"
                :disabled="!selectedTime"
                :class="selectedTime ? 'btn-primary' : 'btn-primary opacity-50 cursor-not-allowed'"
                class="w-full py-3 text-base font-semibold">
            Confirm Booking
        </button>
    </form>
</section>

@push('scripts')
<script>
function bookingForm() {
    return {
        doctorId: '{{ old('doctor_id') }}',
        selectedDate: '{{ old('date') }}',
        serviceId: '{{ old('service_id') }}',
        selectedTime: '{{ old('time') }}',
        slots: [],
        loadingSlots: false,

        async fetchSlots() {
            if (!this.doctorId || !this.selectedDate) return;
            this.loadingSlots = true;
            this.slots = [];
            this.selectedTime = '';
            try {
                const res = await fetch(`{{ route('book.slots') }}?doctor_id=${this.doctorId}&date=${this.selectedDate}`);
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
@endpush

@endsection
