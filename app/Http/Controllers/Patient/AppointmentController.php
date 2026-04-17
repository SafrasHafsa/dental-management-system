<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(): View
    {
        $appointments = Appointment::where('patient_id', Auth::user()->patient?->id)
            ->with(['doctor.user', 'service'])
            ->latest('appointment_date')
            ->paginate(15);

        return view('patient.appointments', compact('appointments'));
    }

    public function cancel(Appointment $appointment): RedirectResponse
    {
        abort_if($appointment->patient_id !== Auth::user()->patient?->id, 403);
        abort_if(! in_array($appointment->status, ['pending', 'confirmed']), 422, 'Cannot cancel this appointment.');

        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', 'Appointment cancelled successfully.');
    }
}
