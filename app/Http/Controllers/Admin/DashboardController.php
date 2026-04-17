<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_patients'      => Patient::count(),
            'total_doctors'       => User::whereHas('roles', fn($q) => $q->where('name', 'doctor'))->count(),
            'total_staff'         => User::whereHas('roles', fn($q) => $q->where('name', 'staff'))->count(),
            'appointments_today'  => Appointment::whereDate('appointment_date', today())->count(),
            'pending_appointments'=> Appointment::where('status', 'pending')->count(),
            'revenue_this_month'  => Invoice::where('status', 'paid')
                ->whereMonth('issue_date', now()->month)
                ->whereYear('issue_date', now()->year)
                ->sum('total_amount'),
            'invoices_overdue'    => Invoice::where('status', 'overdue')->count(),
        ];

        $recentAppointments = Appointment::with(['patient', 'doctorProfile.user', 'service'])
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAppointments'));
    }
}
