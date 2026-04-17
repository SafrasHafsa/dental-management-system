<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\InventoryItem;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
            'outstanding_balance'  => Invoice::whereIn('status', ['sent', 'partial', 'overdue'])
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

    // ─── CSV Exports ─────────────────────────────────────────────────────────

    public function exportRevenue(Request $request): StreamedResponse
    {
        $from = $request->query('from');
        $to   = $request->query('to');

        $query = Invoice::with(['appointment.patient', 'appointment.service', 'appointment.doctorProfile.user'])
            ->orderBy('issue_date', 'desc');

        if ($from) $query->whereDate('issue_date', '>=', $from);
        if ($to)   $query->whereDate('issue_date', '<=', $to);

        $filename = 'revenue_report_' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Invoice #', 'Issue Date', 'Due Date',
                'Patient Name', 'Patient #',
                'Doctor', 'Service',
                'Subtotal', 'Discount', 'Tax', 'Total',
                'Paid Amount', 'Balance Due', 'Status',
            ]);

            $query->chunk(500, function ($invoices) use ($handle) {
                foreach ($invoices as $inv) {
                    $patient = $inv->appointment?->patient;
                    $doctor  = $inv->appointment?->doctorProfile?->user?->name ?? '—';
                    $service = $inv->appointment?->service?->name ?? 'Dental Consultation';

                    fputcsv($handle, [
                        $inv->invoice_number,
                        $inv->issue_date->format('d/m/Y'),
                        $inv->due_date->format('d/m/Y'),
                        $patient ? $patient->first_name . ' ' . $patient->last_name : '—',
                        $patient?->patient_number ?? '—',
                        $doctor,
                        $service,
                        number_format($inv->subtotal, 2, '.', ''),
                        number_format($inv->discount_amount, 2, '.', ''),
                        number_format($inv->tax_amount, 2, '.', ''),
                        number_format($inv->total_amount, 2, '.', ''),
                        number_format($inv->paid_amount, 2, '.', ''),
                        number_format($inv->balance_due, 2, '.', ''),
                        $inv->status,
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function exportAppointments(Request $request): StreamedResponse
    {
        $from   = $request->query('from');
        $to     = $request->query('to');
        $status = $request->query('status');

        $query = Appointment::with(['patient', 'doctorProfile.user', 'service'])
            ->orderBy('appointment_date', 'desc');

        if ($from)   $query->whereDate('appointment_date', '>=', $from);
        if ($to)     $query->whereDate('appointment_date', '<=', $to);
        if ($status) $query->where('status', $status);

        $filename = 'appointments_report_' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Date', 'Time', 'Patient Name', 'Patient #',
                'Doctor', 'Service', 'Status', 'Notes',
            ]);

            $query->chunk(500, function ($appointments) use ($handle) {
                foreach ($appointments as $appt) {
                    $patient = $appt->patient;
                    fputcsv($handle, [
                        $appt->appointment_date->format('d/m/Y'),
                        $appt->start_time ?? '—',
                        $patient ? $patient->first_name . ' ' . $patient->last_name : '—',
                        $patient?->patient_number ?? '—',
                        $appt->doctorProfile?->user?->name ?? '—',
                        $appt->service?->name ?? 'Consultation',
                        ucfirst(str_replace('_', ' ', $appt->status)),
                        $appt->notes ?? '',
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function exportPatients(Request $request): StreamedResponse
    {
        $query = Patient::with('user')
            ->orderBy('created_at', 'desc');

        $filename = 'patients_report_' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Patient #', 'First Name', 'Last Name',
                'Date of Birth', 'Gender', 'Blood Type',
                'Phone', 'Email', 'Registered On',
            ]);

            $query->chunk(500, function ($patients) use ($handle) {
                foreach ($patients as $p) {
                    fputcsv($handle, [
                        $p->patient_number,
                        $p->first_name,
                        $p->last_name,
                        $p->date_of_birth?->format('d/m/Y') ?? '—',
                        ucfirst($p->gender ?? '—'),
                        $p->blood_type ?? '—',
                        $p->user?->phone ?? '—',
                        $p->user?->email ?? '—',
                        $p->created_at->format('d/m/Y'),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function exportInventory(): StreamedResponse
    {
        $query = InventoryItem::with('category')
            ->orderBy('name');

        $filename = 'inventory_report_' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'SKU', 'Name', 'Category', 'Unit',
                'In Stock', 'Min Stock', 'Status',
                'Unit Cost', 'Selling Price', 'Active',
            ]);

            $query->chunk(500, function ($items) use ($handle) {
                foreach ($items as $item) {
                    $isLow = $item->current_stock <= $item->minimum_stock;
                    fputcsv($handle, [
                        $item->sku,
                        $item->name,
                        $item->category?->name ?? '—',
                        $item->unit,
                        $item->current_stock,
                        $item->minimum_stock,
                        $isLow ? 'Low Stock' : 'OK',
                        number_format($item->unit_cost ?? 0, 2, '.', ''),
                        $item->selling_price ? number_format($item->selling_price, 2, '.', '') : '',
                        $item->is_active ? 'Yes' : 'No',
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
