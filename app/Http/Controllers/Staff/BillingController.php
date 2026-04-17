<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ClinicSetting;
use App\Models\Invoice;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class BillingController extends Controller
{
    public function index(): View
    {
        $invoices = Invoice::with(['appointment.patient', 'appointment.service'])
            ->latest()
            ->paginate(20);

        return view('staff.billing', compact('invoices'));
    }

    public function create(Appointment $appointment): View
    {
        $appointment->load(['patient', 'doctorProfile.user', 'service']);
        return view('staff.billing-create', compact('appointment'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'subtotal'       => 'required|numeric|min:0',
            'tax_rate'       => 'nullable|numeric|min:0|max:100',
            'discount_amount'=> 'nullable|numeric|min:0',
            'notes'          => 'nullable|string|max:500',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);
        $subtotal    = (float) $request->subtotal;
        $taxRate     = (float) ($request->tax_rate ?? 0);
        $discount    = (float) ($request->discount_amount ?? 0);
        $tax         = round($subtotal * $taxRate / 100, 2);
        $total       = $subtotal + $tax - $discount;

        $invoice = Invoice::create([
            'invoice_number'  => 'INV-' . date('Y') . '-' . str_pad(Invoice::withTrashed()->count() + 1, 5, '0', STR_PAD_LEFT),
            'appointment_id'  => $appointment->id,
            'patient_id'      => $appointment->patient_id,
            'issued_by'       => auth()->id(),
            'issue_date'      => now(),
            'due_date'        => now()->addDays(7),
            'subtotal'        => $subtotal,
            'tax_rate'        => $taxRate,
            'tax_amount'      => $tax,
            'discount_amount' => $discount,
            'total_amount'    => $total,
            'balance_due'     => $total,
            'status'          => 'unpaid',
            'notes'           => $request->notes,
        ]);

        return redirect()->route('staff.billing.show', $invoice)
            ->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice): View
    {
        $invoice->load(['appointment.patient', 'appointment.doctorProfile.user', 'appointment.service', 'payments']);
        return view('staff.billing-show', compact('invoice'));
    }

    public function recordPayment(Request $request, Invoice $invoice): RedirectResponse
    {
        $request->validate([
            'amount'          => 'required|numeric|min:0.01',
            'payment_method'  => 'required|string',
            'reference_number'=> 'nullable|string|max:100',
            'notes'           => 'nullable|string|max:255',
        ]);

        Payment::create([
            'invoice_id'       => $invoice->id,
            'received_by'      => auth()->id(),
            'amount'           => $request->amount,
            'payment_method'   => $request->payment_method,
            'reference_number' => $request->reference_number,
            'payment_date'     => now(),
            'notes'            => $request->notes,
        ]);

        $invoice->recalculate();

        return back()->with('success', 'Payment of Rs.' . number_format($request->amount, 2) . ' recorded.');
    }

    public function print(Invoice $invoice): View
    {
        $invoice->load(['appointment.patient', 'appointment.doctorProfile.user', 'appointment.service', 'payments']);
        return view('staff.billing-show', compact('invoice'));
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
