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
        $raw  = $appointment->clinicalNotes()->latest()->first();

        // Map DB columns back to view field names so the form can prefill
        $note = $raw ? (object) [
            'chief_complaint' => $raw->subjective,
            'diagnosis'       => $raw->assessment,
            'treatment'       => $raw->procedures_done,
            'notes'           => $raw->plan,
        ] : null;

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

        // Map view field names → DB column names (SOAP format)
        $appointment->clinicalNotes()->create([
            'doctor_id'       => auth()->id(),
            'subjective'      => $request->chief_complaint,   // what patient reports
            'assessment'      => $request->diagnosis,          // doctor's diagnosis
            'procedures_done' => $request->treatment,          // what was done
            'plan'            => $request->notes,              // prescriptions / follow-up
        ]);

        return redirect()->route('doctor.appointments')
            ->with('success', 'Clinical notes saved successfully.');
    }
}
