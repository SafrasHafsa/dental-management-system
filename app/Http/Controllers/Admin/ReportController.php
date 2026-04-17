<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_patients'       => Patient::count(),
            'total_appointments'   => Appointment::count(),
            'completed_this_month' => Appointment::whereMonth('appointment_date', now()->month)
                                        ->where('status', 'completed')->count(),
            'revenue_this_month'   => Invoice::whereMonth('issue_date', now()->month)
                                        ->whereIn('status', ['paid', 'partial'])->sum('paid_amount'),
            'revenue_last_month'   => Invoice::whereMonth('issue_date', now()->subMonth()->month)
                                        ->whereIn('status', ['paid', 'partial'])->sum('paid_amount'),
            'outstanding_balance'  => Invoice::whereIn('status', ['unpaid', 'partial', 'overdue'])
                                        ->sum('balance_due'),
        ];

        // Monthly revenue for the past 6 months
        $monthlyRevenue = collect(range(5, 0))->map(fn($i) => [
            'label'   => now()->subMonths($i)->format('M'),
            'revenue' => Invoice::whereMonth('issue_date', now()->subMonths($i)->month)
                            ->whereYear('issue_date', now()->subMonths($i)->year)
                            ->whereIn('status', ['paid', 'partial'])
                            ->sum('paid_amount'),
        ]);

        // Status breakdown
        $statusBreakdown = Appointment::selectRaw('status, count(*) as total')
            ->groupBy('status')->pluck('total', 'status');

        return view('admin.reports', compact('stats', 'monthlyRevenue', 'statusBreakdown'));
    }

    public function revenue(): View { return $this->index(); }
}
