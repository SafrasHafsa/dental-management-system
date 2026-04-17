<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ClinicalNote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClinicalNoteController extends Controller
{
    public function create(Appointment $appointment): View
    {
        $note = $appointment->clinicalNotes()->latest()->first();
        return view('doctor.appointments.notes', compact('appointment', 'note'));
    }

    public function store(Request $request, Appointment $appointment): RedirectResponse
    {
        $request->validate([
            'chief_complaint' => 'nullable|string|max:1000',
            'diagnosis'       => 'nullable|string|max:1000',
            'treatment'       => 'nullable|string|max:2000',
            'notes'           => 'nullable|string|max:2000',
        ]);

        $appointment->clinicalNotes()->create([
            'doctor_profile_id' => $appointment->doctor_profile_id,
            'chief_complaint'   => $request->chief_complaint,
            'diagnosis'         => $request->diagnosis,
            'treatment'         => $request->treatment,
            'notes'             => $request->notes,
        ]);

        return redirect()->route('doctor.appointments')
            ->with('success', 'Clinical notes saved successfully.');
    }
}
