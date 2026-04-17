<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(): View
    {
        $doctor = Auth::user()->doctorProfile;
        $appointments = Appointment::where('doctor_profile_id', $doctor?->id)
            ->with(['patient', 'service'])
            ->orderBy('appointment_date')
            ->get();

        return view('doctor.appointments', compact('appointments'));
    }

    public function show(Appointment $appointment): View
    {
        $appointment->load(['patient', 'service', 'clinicalNotes']);
        return view('doctor.appointment-show', compact('appointment'));
    }

    public function start(Appointment $appointment)
    {
        $appointment->update(['status' => 'in_progress']);
        return back()->with('success', 'Session started.');
    }

    public function complete(Appointment $appointment)
    {
        $appointment->update(['status' => 'completed']);
        return back()->with('success', 'Appointment marked complete.');
    }
}
