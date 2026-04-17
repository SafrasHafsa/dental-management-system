<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
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
}
