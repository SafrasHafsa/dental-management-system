@extends('layouts.dashboard')
@section('title', 'My Schedule')

@section('sidebar-nav')
    <div class="mb-4">
        <p class="px-3 mb-2 text-xs font-semibold text-gray-600 uppercase tracking-wider">My Clinic</p>
        <x-nav-item route="doctor.dashboard"    icon="home"     label="Dashboard" />
        <x-nav-item route="doctor.appointments" icon="calendar" label="My Schedule" />
        <x-nav-item route="doctor.patients"     icon="users"    label="My Patients" />
        <x-nav-item route="doctor.schedule" icon="clock" label="My Availability" />
    </div>
@endsection

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">My Schedule</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $appointments->count() }} appointments assigned to you</p>
    </div>
</div>

{{-- Filter chips --}}
<div class="flex flex-wrap gap-2 mb-4" id="status-filters">
    <button onclick="filterStatus('all')" data-status="all"
            class="filter-btn active text-xs font-semibold px-3 py-1.5 rounded-full bg-gray-900 text-white transition-colors">All</button>
    @foreach(['pending'=>'Pending','confirmed'=>'Confirmed','in_progress'=>'In Progress','completed'=>'Completed'] as $val=>$label)
    <button onclick="filterStatus('{{ $val }}')" data-status="{{ $val }}"
            class="filter-btn text-xs font-semibold px-3 py-1.5 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">
        {{ $label }}
    </button>
    @endforeach
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table id="appts-dt" class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Patient</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date & Time</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($appointments as $appt)
                <tr class="hover:bg-gray-50 transition-colors" data-status="{{ $appt->status }}">
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs flex-shrink-0">
                                {{ strtoupper(substr($appt->patient->first_name ?? 'P', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $appt->patient->first_name }} {{ $appt->patient->last_name }}</p>
                                <p class="text-xs text-gray-400">{{ $appt->patient->patient_number }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3.5 text-gray-500">{{ $appt->service?->name ?? '—' }}</td>
                    <td class="px-6 py-3.5" data-order="{{ $appt->appointment_date->format('Y-m-d') }}">
                        <p class="font-medium text-gray-700">{{ $appt->appointment_date->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($appt->start_time)->format('g:i A') }}</p>
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="hidden">{{ $appt->status }}</span>
                        <span class="{{ $appt->statusBadgeClass() }}">{{ $appt->statusLabel() }}</span>
                    </td>
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('doctor.appointments.show', $appt) }}"
                               class="text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">View</a>
                            @if($appt->isConfirmed())
                            <form method="POST" action="{{ route('doctor.appointments.start', $appt) }}" class="inline">
                                @csrf @method('PATCH')
                                <button class="text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 px-3 py-1.5 rounded-lg transition-colors">Start</button>
                            </form>
                            @elseif($appt->isInProgress())
                            <a href="{{ route('doctor.appointments.notes', $appt) }}"
                               class="text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition-colors">Add Notes</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
var apptTable;
$(document).ready(function(){
    apptTable = initDT('#appts-dt', {
        order: [[2,'desc']],
        columnDefs: [{
            targets: 3,
            render: function(data, type, row) {
                if (type === 'filter') {
                    var tmp = document.createElement('div');
                    tmp.innerHTML = data;
                    var hidden = tmp.querySelector('.hidden');
                    return hidden ? hidden.textContent.trim() : data;
                }
                return data;
            }
        }]
    });
});
function filterStatus(status) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.toggle('bg-gray-900', btn.dataset.status === status);
        btn.classList.toggle('text-white',  btn.dataset.status === status);
        btn.classList.toggle('bg-gray-100', btn.dataset.status !== status);
        btn.classList.toggle('text-gray-600', btn.dataset.status !== status);
    });
    if (apptTable) apptTable.column(3).search(status === 'all' ? '' : status, false, false).draw();
}
</script>
@endpush
