<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $patient = Auth::user()->patient;

        $stats = [
            'upcoming_appointments' => Appointment::where('patient_id', $patient->id)
                ->whereIn('status', ['confirmed', 'pending'])
                ->where('appointment_date', '>=', today())
                ->count(),
            'total_visits'          => Appointment::where('patient_id', $patient->id)
                ->where('status', 'completed')
                ->count(),
            'pending_invoices'      => Invoice::where('patient_id', $patient->id)
                ->whereIn('status', ['sent', 'partial', 'overdue'])
                ->count(),
        ];

        $upcomingAppointments = Appointment::with(['doctorProfile.user', 'service'])
            ->where('patient_id', $patient->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('appointment_date', '>=', today())
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        $recentInvoices = Invoice::where('patient_id', $patient->id)
            ->latest('issue_date')
            ->take(5)
            ->get();

        return view('patient.dashboard', compact('stats', 'upcomingAppointments', 'recentInvoices', 'patient'));
    }
}
