<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
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
        $invoice->load(['appointment.doctor.user', 'appointment.service', 'payments']);

        return view('patient.invoice-show', compact('invoice'));
    }

    public function pdf(Invoice $invoice)
    {
        abort_if($invoice->appointment->patient_id !== Auth::user()->patient?->id, 403);
        // TODO: PDF generation
        return back()->with('info', 'PDF download coming soon.');
    }
}
