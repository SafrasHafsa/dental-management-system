<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClinicSetting;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\View\View;

class BillingController extends Controller
{
    public function index(): View
    {
        $invoices = Invoice::with(['appointment.patient', 'appointment.service'])
            ->latest()
            ->get();
        return view('admin.billing', compact('invoices'));
    }

    public function show(Invoice $invoice): View
    {
        $invoice->load(['appointment.patient', 'appointment.doctorProfile.user', 'appointment.service', 'payments']);
        return view('admin.billing-show', compact('invoice'));
    }

    public function pdf(Invoice $invoice): Response
    {
        $invoice->load(['appointment.patient', 'appointment.doctorProfile.user', 'appointment.service', 'payments']);

        $pdf = Pdf::loadView('pdf.invoice', [
            'invoice'       => $invoice,
            'clinicName'    => ClinicSetting::get('clinic_name', 'SmileCare Dental Clinic'),
            'clinicAddress' => ClinicSetting::get('clinic_address', ''),
            'clinicPhone'   => ClinicSetting::get('clinic_phone', ''),
            'clinicEmail'   => ClinicSetting::get('clinic_email', ''),
            'currency'      => ClinicSetting::get('currency_symbol', 'Rs.'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download($invoice->invoice_number . '.pdf');
    }
}
