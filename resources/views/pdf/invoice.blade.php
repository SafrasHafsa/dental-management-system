<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Invoice {{ $invoice->invoice_number }}</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1a1a1a; background: #fff; }
    .page { padding: 40px 48px; }

    /* Header */
    .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 36px; padding-bottom: 24px; border-bottom: 2px solid #e5e7eb; }
    .clinic-name { font-size: 22px; font-weight: 700; color: #111827; margin-bottom: 4px; }
    .clinic-meta { font-size: 11px; color: #6b7280; line-height: 1.6; }
    .invoice-label { font-size: 28px; font-weight: 700; color: #111827; text-align: right; }
    .invoice-number { font-size: 13px; color: #6b7280; text-align: right; margin-top: 4px; }
    .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 6px; }
    .badge-paid    { background: #d1fae5; color: #065f46; }
    .badge-unpaid  { background: #fee2e2; color: #991b1b; }
    .badge-partial { background: #fef3c7; color: #92400e; }
    .badge-overdue { background: #fee2e2; color: #991b1b; }

    /* Billing block */
    .billing-block { display: flex; justify-content: space-between; margin-bottom: 28px; }
    .billing-col { width: 48%; }
    .billing-col h4 { font-size: 10px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; }
    .billing-col p { font-size: 12px; color: #374151; line-height: 1.7; }
    .billing-col .name { font-size: 14px; font-weight: 700; color: #111827; }

    /* Details grid */
    .details-grid { display: flex; justify-content: flex-end; margin-bottom: 28px; }
    .details-table { width: 260px; }
    .details-table td { font-size: 11px; padding: 3px 0; }
    .details-table td:first-child { color: #6b7280; padding-right: 16px; }
    .details-table td:last-child { color: #111827; font-weight: 600; text-align: right; }

    /* Line items */
    .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .items-table thead tr { background: #f3f4f6; }
    .items-table th { font-size: 10px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 12px; text-align: left; }
    .items-table th.right { text-align: right; }
    .items-table td { padding: 12px 12px; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
    .items-table td.right { text-align: right; }
    .items-table .item-name { font-weight: 600; color: #111827; }
    .items-table .item-desc { font-size: 10px; color: #9ca3af; margin-top: 2px; }

    /* Totals */
    .totals { float: right; width: 260px; margin-bottom: 28px; }
    .totals-row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 12px; }
    .totals-row.border-top { border-top: 1px solid #e5e7eb; padding-top: 10px; margin-top: 4px; }
    .totals-row.total { font-size: 15px; font-weight: 700; color: #111827; border-top: 2px solid #111827; padding-top: 8px; margin-top: 4px; }
    .totals-row.balance { font-size: 14px; font-weight: 700; }
    .totals-row.balance.due { color: #dc2626; }
    .totals-row.balance.paid { color: #059669; }
    .label { color: #6b7280; }
    .clearfix::after { content: ''; display: table; clear: both; }

    /* Payment history */
    .payments { margin-top: 24px; }
    .payments h4 { font-size: 11px; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; }
    .payment-row { display: flex; justify-content: space-between; padding: 7px 0; border-bottom: 1px solid #f3f4f6; font-size: 11px; }
    .payment-amount { font-weight: 700; color: #059669; }
    .payment-meta { color: #6b7280; }

    /* Notes */
    .notes { margin-top: 24px; padding: 14px 16px; background: #f9fafb; border-left: 3px solid #e5e7eb; }
    .notes h4 { font-size: 10px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .notes p { font-size: 11px; color: #374151; line-height: 1.6; }

    /* Footer */
    .footer { margin-top: 48px; padding-top: 16px; border-top: 1px solid #e5e7eb; text-align: center; font-size: 10px; color: #9ca3af; }
</style>
</head>
<body>
<div class="page">

    {{-- Header --}}
    <div class="header">
        <div>
            <div class="clinic-name">{{ $clinicName }}</div>
            <div class="clinic-meta">
                @if($clinicAddress){{ $clinicAddress }}<br>@endif
                @if($clinicPhone)Tel: {{ $clinicPhone }}&nbsp;&nbsp;&nbsp;@endif
                @if($clinicEmail){{ $clinicEmail }}@endif
            </div>
        </div>
        <div>
            <div class="invoice-label">INVOICE</div>
            <div class="invoice-number">{{ $invoice->invoice_number }}</div>
            <div style="text-align:right;">
                @php $st = $invoice->status; @endphp
                <span class="badge badge-{{ in_array($st, ['paid']) ? 'paid' : (in_array($st, ['partial']) ? 'partial' : 'unpaid') }}">
                    {{ ucfirst($st) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Billing info + invoice details --}}
    <div class="billing-block">
        <div class="billing-col">
            <h4>Bill To</h4>
            <p class="name">{{ $invoice->appointment->patient->first_name }} {{ $invoice->appointment->patient->last_name }}</p>
            <p>{{ $invoice->appointment->patient->patient_number }}</p>
            @if($invoice->appointment->patient->user?->phone)
            <p>{{ $invoice->appointment->patient->user->phone }}</p>
            @endif
            @if($invoice->appointment->patient->user?->email)
            <p>{{ $invoice->appointment->patient->user->email }}</p>
            @endif
        </div>
        <div class="billing-col">
            <h4>Invoice Details</h4>
            <table class="details-table">
                <tr><td>Issue Date</td><td>{{ $invoice->issue_date->format('d M Y') }}</td></tr>
                <tr><td>Due Date</td><td>{{ $invoice->due_date->format('d M Y') }}</td></tr>
                <tr><td>Doctor</td><td>Dr. {{ $invoice->appointment->doctorProfile->user->name }}</td></tr>
                <tr><td>Appointment</td><td>{{ $invoice->appointment->appointment_date->format('d M Y') }}</td></tr>
            </table>
        </div>
    </div>

    {{-- Items table --}}
    <table class="items-table">
        <thead>
            <tr>
                <th>Description</th>
                <th class="right">Unit Price</th>
                <th class="right">Qty</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="item-name">{{ $invoice->appointment->service?->name ?? 'Dental Consultation' }}</div>
                    @if($invoice->appointment->service?->description)
                    <div class="item-desc">{{ $invoice->appointment->service->description }}</div>
                    @endif
                </td>
                <td class="right">{{ $currency }}{{ number_format($invoice->subtotal, 2) }}</td>
                <td class="right">1</td>
                <td class="right">{{ $currency }}{{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Totals --}}
    <div class="clearfix">
        <div class="totals">
            <div class="totals-row">
                <span class="label">Subtotal</span>
                <span>{{ $currency }}{{ number_format($invoice->subtotal, 2) }}</span>
            </div>
            @if($invoice->discount_amount > 0)
            <div class="totals-row">
                <span class="label">Discount</span>
                <span>− {{ $currency }}{{ number_format($invoice->discount_amount, 2) }}</span>
            </div>
            @endif
            @if($invoice->tax_amount > 0)
            <div class="totals-row">
                <span class="label">Tax ({{ $invoice->tax_rate }}%)</span>
                <span>{{ $currency }}{{ number_format($invoice->tax_amount, 2) }}</span>
            </div>
            @endif
            <div class="totals-row total">
                <span>Total</span>
                <span>{{ $currency }}{{ number_format($invoice->total_amount, 2) }}</span>
            </div>
            @if($invoice->paid_amount > 0)
            <div class="totals-row border-top">
                <span class="label">Paid</span>
                <span style="color:#059669;">{{ $currency }}{{ number_format($invoice->paid_amount, 2) }}</span>
            </div>
            @endif
            <div class="totals-row balance {{ $invoice->balance_due > 0 ? 'due' : 'paid' }}">
                <span>Balance Due</span>
                <span>{{ $currency }}{{ number_format($invoice->balance_due, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Payment history --}}
    @if($invoice->payments->count())
    <div class="payments">
        <h4>Payment History</h4>
        @foreach($invoice->payments->sortByDesc('payment_date') as $payment)
        <div class="payment-row">
            <div>
                <span class="payment-amount">{{ $currency }}{{ number_format($payment->amount, 2) }}</span>
                <span class="payment-meta"> &nbsp;·&nbsp; {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                @if($payment->reference_number) &nbsp;·&nbsp; Ref: {{ $payment->reference_number }}@endif
                </span>
            </div>
            <div class="payment-meta">{{ $payment->paid_at->format('d M Y') }}</div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Notes --}}
    @if($invoice->notes)
    <div class="notes">
        <h4>Notes</h4>
        <p>{{ $invoice->notes }}</p>
    </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        Thank you for choosing {{ $clinicName }}. &nbsp;|&nbsp; This is a computer-generated invoice.
    </div>

</div>
</body>
</html>
