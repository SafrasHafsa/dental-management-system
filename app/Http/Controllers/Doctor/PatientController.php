<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function index(): View
    {
        $doctor = Auth::user()->doctorProfile;
        $patients = Patient::whereHas('appointments', fn($q) => $q->where('doctor_profile_id', $doctor?->id))
            ->with('user')
            ->latest()
            ->get();

        return view('doctor.patients', compact('patients'));
    }

    public function show(Patient $patient): View
    {
        $doctor = Auth::user()->doctorProfile;
        $patient->load(['user', 'appointments' => function ($q) use ($doctor) {
            $q->where('doctor_profile_id', $doctor?->id)
              ->with(['service', 'clinicalNotes'])
              ->orderByDesc('appointment_date');
        }]);

        return view('doctor.patient-show', compact('patient'));
    }
}
