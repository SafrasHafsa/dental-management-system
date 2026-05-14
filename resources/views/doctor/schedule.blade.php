@extends('layouts.dashboard')
@section('title', 'My Schedule')

@section('sidebar-nav')
    <div class="mb-4">
        <p class="px-3 mb-2 text-xs font-semibold text-gray-600 uppercase tracking-wider">My Clinic</p>
        <x-nav-item route="doctor.dashboard"     icon="home"     label="Dashboard" />
        <x-nav-item route="doctor.appointments"  icon="calendar" label="My Appointments" />
        <x-nav-item route="doctor.schedule"      icon="clock"    label="My Schedule" />
        <x-nav-item route="doctor.patients"      icon="users"    label="My Patients" />
    </div>
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">My Schedule</h1>
        <p class="text-sm text-gray-500 mt-0.5">Set your working days and available appointment slots</p>
    </div>
</div>

@if(session('success'))
    <div class="alert-success mb-6">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert-error mb-6">
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('doctor.schedule.update') }}" x-data="scheduleForm()">
    @csrf

    {{-- Working Hours --}}
    <div class="card p-6 mb-5">
        <h2 class="text-base font-semibold text-gray-900 mb-1">Working Hours</h2>
        <p class="text-sm text-gray-400 mb-5">These hours apply to all your active working days.</p>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div>
                <label class="form-label">Start Time <span class="text-red-500">*</span></label>
                <input type="time" name="start_time" class="form-input" required
                       value="{{ old('start_time', $schedules->first()?->start_time ? substr($schedules->first()->start_time, 0, 5) : '08:00') }}">
                @error('start_time')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">End Time <span class="text-red-500">*</span></label>
                <input type="time" name="end_time" class="form-input" required
                       value="{{ old('end_time', $schedules->first()?->end_time ? substr($schedules->first()->end_time, 0, 5) : '17:00') }}">
                @error('end_time')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Appointment Duration <span class="text-red-500">*</span></label>
                <select name="slot_duration_minutes" class="form-input" required>
                    @foreach([15 => '15 minutes', 20 => '20 minutes', 30 => '30 minutes', 45 => '45 minutes', 60 => '1 hour'] as $val => $label)
                        <option value="{{ $val }}"
                            {{ old('slot_duration_minutes', $schedules->first()?->slot_duration_minutes ?? 30) == $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('slot_duration_minutes')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    {{-- Available Days --}}
    <div class="card p-6 mb-5">
        <h2 class="text-base font-semibold text-gray-900 mb-1">Available Days</h2>
        <p class="text-sm text-gray-400 mb-5">Select the days you are available for appointments.</p>
        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-3">
            @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $i => $day)
                @php $active = old('days') ? in_array($i, old('days', [])) : ($schedules->get($i)?->is_active ?? false); @endphp
                <label class="relative flex flex-col items-center gap-2 p-4 border-2 rounded-xl cursor-pointer transition-all select-none"
                       :class="days.includes({{ $i }}) ? 'border-primary-500 bg-primary-50' : 'border-gray-200 hover:border-primary-300'">
                    <input type="checkbox" name="days[]" value="{{ $i }}"
                           class="sr-only"
                           {{ $active ? 'checked' : '' }}
                           @change="toggleDay({{ $i }})">
                    <span class="text-sm font-bold text-gray-700">{{ $day }}</span>
                    <span class="text-xs font-medium"
                          :class="days.includes({{ $i }}) ? 'text-primary-600' : 'text-gray-400'"
                          x-text="days.includes({{ $i }}) ? '✓ Active' : 'Off'">
                        {{ $active ? '✓ Active' : 'Off' }}
                    </span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Preview --}}
    <div class="card p-6 mb-6 bg-gray-50">
        <h2 class="text-base font-semibold text-gray-900 mb-3">Schedule Preview</h2>
        <p class="text-sm text-gray-500">
            Patients will see time slots on:
            <span class="font-semibold text-gray-700" x-text="previewDays()"></span>
        </p>
    </div>

    <button type="submit" class="btn-primary px-8 py-2.5 text-base">
        Save Schedule
    </button>
</form>
@endsection

@push('scripts')
<script>
function scheduleForm() {
    return {
        days: @json(
            old('days')
                ? array_map('intval', old('days', []))
                : $schedules->filter(fn($s) => $s->is_active)->keys()->values()->toArray()
        ),
        dayNames: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],

        toggleDay(day) {
            if (this.days.includes(day)) {
                this.days = this.days.filter(d => d !== day);
            } else {
                this.days.push(day);
                this.days.sort();
            }
        },

        previewDays() {
            if (this.days.length === 0) return 'No days selected';
            return this.days.map(d => this.dayNames[d]).join(', ');
        }
    }
}
</script>
@endpush