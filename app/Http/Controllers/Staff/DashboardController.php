<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\InventoryItem;
use App\Models\Patient;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'appointments_today'  => Appointment::whereDate('appointment_date', today())->count(),
            'pending_approvals'   => Appointment::where('status', 'pending')->count(),
            'confirmed_today'     => Appointment::where('status', 'confirmed')
                ->whereDate('appointment_date', today())->count(),
            'completed_today'     => Appointment::where('status', 'completed')
                ->whereDate('appointment_date', today())->count(),
            'invoices_unpaid'     => Invoice::whereIn('status', ['sent', 'partial', 'overdue'])->count(),
            'low_stock_items'     => InventoryItem::whereColumn('current_stock', '<=', 'minimum_stock')
                ->where('is_active', true)->count(),
        ];

        $pendingAppointments = Appointment::with(['patient', 'doctorProfile.user', 'service'])
            ->where('status', 'pending')
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->take(10)
            ->get();

        $todayAppointments = Appointment::with(['patient', 'doctorProfile.user', 'service'])
            ->whereDate('appointment_date', today())
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('start_time')
            ->get();

        return view('staff.dashboard', compact('stats', 'pendingAppointments', 'todayAppointments'));
    }
}
