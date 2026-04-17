<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $doctor = Auth::user()->doctorProfile;

        $stats = [
            'appointments_today'  => Appointment::where('doctor_profile_id', $doctor->id)
                ->whereDate('appointment_date', today())->count(),
            'upcoming_week'       => Appointment::where('doctor_profile_id', $doctor->id)
                ->whereBetween('appointment_date', [today(), today()->addDays(7)])
                ->whereIn('status', ['confirmed'])->count(),
            'completed_this_month'=> Appointment::where('doctor_profile_id', $doctor->id)
                ->where('status', 'completed')
                ->whereMonth('appointment_date', now()->month)->count(),
            'pending_notes'       => Appointment::where('doctor_profile_id', $doctor->id)
                ->where('status', 'completed')
                ->doesntHave('clinicalNote')
                ->count(),
        ];

        $todayAppointments = Appointment::with(['patient', 'service', 'clinicalNote'])
            ->where('doctor_profile_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('start_time')
            ->get();

        $upcomingAppointments = Appointment::with(['patient', 'service'])
            ->where('doctor_profile_id', $doctor->id)
            ->where('appointment_date', '>', today())
            ->where('status', 'confirmed')
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        return view('doctor.dashboard', compact('stats', 'todayAppointments', 'upcomingAppointments', 'doctor'));
    }
}
