<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\ClinicSetting;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(): View
    {
        $invoices = Invoice::whereHas('appointment', function ($q) {
                $q->where('patient_id', Auth::user()->patient?->id);
            })
            ->with('appointment.service')
            ->latest()
            ->paginate(15);

        return view('patient.invoices', compact('invoices'));
    }

    public function show(Invoice $invoice): View
    {
        abort_if($invoice->appointment->patient_id !== Auth::user()->patient?->id, 403);
        $invoice->load(['appointment.doctorProfile.user', 'appointment.service', 'payments']);

        return view('patient.invoice-show', compact('invoice'));
    }

    public function pdf(Invoice $invoice): Response
    {
        abort_if($invoice->appointment->patient_id !== Auth::user()->patient?->id, 403);
        $invoice->load(['appointment.patient', 'appointment.doctorProfile.user', 'appointment.service', 'payments']);

        $pdf = Pdf::loadView('pdf.invoice', [
            'invoice'       => $invoice,
            'clinicName'    => ClinicSetting::get('clinic_name', 'City Dental Surgery'),
            'clinicAddress' => ClinicSetting::get('clinic_address', ''),
            'clinicPhone'   => ClinicSetting::get('clinic_phone', ''),
            'clinicEmail'   => ClinicSetting::get('clinic_email', ''),
            'currency'      => ClinicSetting::get('currency_symbol', 'Rs.'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download($invoice->invoice_number . '.pdf');
    }
}
