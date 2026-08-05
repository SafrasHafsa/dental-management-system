<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(): View
    {
        $appointments = Appointment::with(['patient', 'doctorProfile.user', 'service'])
            ->orderByDesc('appointment_date')
            ->get();

        $patients = Patient::orderBy('first_name')->get(['id','first_name','last_name','patient_number']);
        $doctors  = DoctorProfile::with('user')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get(['id','name','duration_minutes']);

        return view('staff.appointments', compact('appointments', 'patients', 'doctors', 'services'));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_profile_id'=> 'required|exists:doctor_profiles,id',
            'service_id'       => 'nullable|exists:services,id',
            'appointment_date' => 'required|date',
            'start_time'       => 'required',
            'notes'            => 'nullable|string|max:500',
        ]);

        $service  = $data['service_id'] ? Service::find($data['service_id']) : null;
        $duration = $service?->duration_minutes ?? 30;
        $start    = \Carbon\Carbon::parse($data['appointment_date'] . ' ' . $data['start_time']);

        // Double-booking check
        $conflict = Appointment::where('doctor_profile_id', $data['doctor_profile_id'])
            ->whereDate('appointment_date', $data['appointment_date'])
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->where('start_time', $start->format('H:i:s'))
            ->exists();

        if ($conflict) {
            return response()->json([
                'success' => false,
                'message' => 'This time slot is already booked for the selected doctor. Please choose a different time.'
            ], 422);
        }

        $number = 'APT-' . date('Y') . '-' . str_pad(Appointment::withTrashed()->count() + 1, 5, '0', STR_PAD_LEFT);

        Appointment::create([
            'appointment_number' => $number,
            'patient_id'         => $data['patient_id'],
            'doctor_profile_id'  => $data['doctor_profile_id'],
            'service_id'         => $data['service_id'] ?? null,
            'created_by'         => Auth::id(),
            'appointment_date'   => $data['appointment_date'],
            'start_time'         => $start->format('H:i:s'),
            'end_time'           => $start->copy()->addMinutes($duration)->format('H:i:s'),
            'status'             => 'pending',
            'source'             => 'walk_in',
            'notes'              => $data['notes'] ?? null,
        ]);

        return response()->json(['success' => true], 201);
    }

    public function show(Appointment $appointment): View
    {
        $appointment->load(['patient', 'doctorProfile.user', 'service', 'invoice']);
        return view('staff.appointment-show', compact('appointment'));
    }
   
    public function approve(Appointment $appointment): RedirectResponse
    {
        $appointment->update([
            'status'      => 'confirmed',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        $appointment->load(['patient.user', 'doctorProfile.user', 'service']);
        \App\Services\NotificationService::appointmentApproved($appointment);
        return back()->with('success', 'Appointment confirmed successfully.');
    }

    public function cancel(Appointment $appointment): RedirectResponse
    {
        $appointment->update(['status' => 'cancelled']);
        $appointment->load(['patient.user', 'doctorProfile.user', 'service']);
        \App\Services\NotificationService::appointmentCancelled($appointment);
        return back()->with('success', 'Appointment cancelled.');
    }
  

    public function reschedule(Request $request, Appointment $appointment): RedirectResponse
    {
        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time'       => 'required',
            'notes'            => 'nullable|string|max:500',
        ]);

        $service  = $appointment->service;
        $duration = $service?->duration_minutes ?? 30;
        $start    = \Carbon\Carbon::parse($request->appointment_date . ' ' . $request->start_time);

        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'start_time'       => $start->format('H:i:s'),
            'end_time'         => $start->copy()->addMinutes($duration)->format('H:i:s'),
            'status'           => 'pending',
            'notes'            => $request->notes ?? $appointment->notes,
        ]);

        return back()->with('success', 'Appointment rescheduled successfully.');
    }
}
