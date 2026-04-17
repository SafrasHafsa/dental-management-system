<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $invoice->invoice_number }} — {{ $clinicName }}</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #1a1a1a; background: #fff; }
    .page { max-width: 780px; margin: 0 auto; padding: 40px 48px; }

    /* Header */
    .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px; padding-bottom: 20px; border-bottom: 2px solid #e5e7eb; }
    .clinic-name { font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 4px; }
    .clinic-meta { font-size: 12px; color: #6b7280; line-height: 1.7; }
    .invoice-label { font-size: 30px; font-weight: 800; color: #111827; text-align: right; letter-spacing: -0.5px; }
    .invoice-sub { font-size: 12px; color: #6b7280; text-align: right; margin-top: 4px; }
    .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 6px; }
    .badge-paid    { background: #d1fae5; color: #065f46; }
    .badge-unpaid  { background: #fef3c7; color: #92400e; }
    .badge-partial { background: #fef3c7; color: #92400e; }

    /* Billing row */
    .billing-row { display: flex; justify-content: space-between; margin-bottom: 28px; gap: 24px; }
    .billing-col { flex: 1; }
    .billing-col h4 { font-size: 10px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; border-bottom: 1px solid #f3f4f6; padding-bottom: 4px; }
    .billing-col p { font-size: 12px; color: #374151; line-height: 1.8; }
    .billing-col .name { font-size: 15px; font-weight: 700; color: #111827; }

    /* Details table */
    .details-table { width: 100%; }
    .details-table td { font-size: 12px; padding: 3px 0; }
    .details-table td.label { color: #6b7280; width: 120px; }
    .details-table td.value { color: #111827; font-weight: 600; }

    /* Items */
    table.items { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
    table.items thead tr { background: #111827; color: #fff; }
    table.items th { font-size: 11px; font-weight: 600; padding: 10px 14px; text-align: left; letter-spacing: 0.3px; }
    table.items th.r { text-align: right; }
    table.items td { padding: 12px 14px; border-bottom: 1px solid #f3f4f6; font-size: 13px; vertical-align: top; }
    table.items td.r { text-align: right; }
    table.items tbody tr:nth-child(even) { background: #f9fafb; }
    .item-desc { font-size: 11px; color: #9ca3af; margin-top: 2px; }

    /* Totals */
    .totals-wrap { display: flex; justify-content: flex-end; margin-bottom: 24px; }
    .totals { width: 280px; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; }
    .totals-row { display: flex; justify-content: space-between; padding: 8px 16px; font-size: 13px; }
    .totals-row:not(:last-child) { border-bottom: 1px solid #f3f4f6; }
    .totals-row.total-row { background: #111827; color: #fff; font-weight: 700; font-size: 14px; }
    .totals-row.balance-row { font-weight: 700; font-size: 14px; }
    .totals-row.balance-row.due  { background: #fef2f2; color: #dc2626; }
    .totals-row.balance-row.paid-bg { background: #f0fdf4; color: #16a34a; }

    /* Payments */
    .payments { margin-bottom: 24px; }
    .payments h4 { font-size: 11px; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
    table.pay-table { width: 100%; border-collapse: collapse; }
    table.pay-table th { font-size: 11px; font-weight: 600; color: #6b7280; text-align: left; padding: 6px 10px; background: #f9fafb; border-bottom: 1px solid #e5e7eb; }
    table.pay-table td { font-size: 12px; padding: 8px 10px; border-bottom: 1px solid #f3f4f6; color: #374151; }
    .pay-amount { font-weight: 700; color: #16a34a; }

    /* Notes */
    .notes { background: #f9fafb; border-left: 3px solid #d1d5db; padding: 12px 16px; border-radius: 0 6px 6px 0; margin-bottom: 24px; }
    .notes h4 { font-size: 10px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
    .notes p { font-size: 12px; color: #374151; }

    /* Footer */
    .footer { text-align: center; font-size: 11px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 16px; margin-top: 32px; }

    /* Print-only */
    @media print {
        .no-print { display: none !important; }
        body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .page { padding: 20px; }
        @page { margin: 15mm; }
    }

    /* Screen toolbar */
    .toolbar { background: #1f2937; padding: 12px 24px; display: flex; align-items: center; justify-content: space-between; }
    .toolbar span { color: #d1d5db; font-size: 13px; }
    .btn-print { background: #3b82f6; color: #fff; border: none; padding: 8px 20px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; }
    .btn-print:hover { background: #2563eb; }
    .btn-close { background: transparent; color: #9ca3af; border: 1px solid #4b5563; padding: 8px 16px; border-radius: 6px; font-size: 13px; cursor: pointer; }
    .btn-close:hover { background: #374151; color: #fff; }
</style>
</head>
<body>

{{-- Screen toolbar (hidden on print) --}}
<div class="toolbar no-print">
    <span>{{ $invoice->invoice_number }} &nbsp;·&nbsp; {{ $clinicName }}</span>
    <div style="display:flex;gap:8px;">
        <button class="btn-close" onclick="window.close()">Close</button>
        <button class="btn-print" onclick="window.print()">Print / Save PDF</button>
    </div>
</div>

<div class="page">

    {{-- Header --}}
    <div class="header">
        <div>
            <div class="clinic-name">{{ $clinicName }}</div>
            <div class="clinic-meta">
                @if($clinicAddress){{ $clinicAddress }}<br>@endif
                @if($clinicPhone)Tel: {{ $clinicPhone }}&nbsp;&nbsp;&nbsp;@endif
                @if($clinicEmail)Email: {{ $clinicEmail }}@endif
            </div>
        </div>
        <div>
            <div class="invoice-label">INVOICE</div>
            <div class="invoice-sub">{{ $invoice->invoice_number }}</div>
            @php $st = $invoice->status; @endphp
            <div style="text-align:right;margin-top:6px;">
                <span class="badge badge-{{ $st === 'paid' ? 'paid' : ($st === 'partial' ? 'partial' : 'unpaid') }}">
                    {{ $invoice->statusLabel() }}
                </span>
            </div>
        </div>
    </div>

    {{-- Billing + details --}}
    <div class="billing-row">
        <div class="billing-col">
            <h4>Bill To</h4>
            <p class="name">{{ $invoice->appointment->patient->first_name }} {{ $invoice->appointment->patient->last_name }}</p>
            <p>{{ $invoice->appointment->patient->patient_number }}</p>
            @if($invoice->appointment->patient->user?->phone)<p>{{ $invoice->appointment->patient->user->phone }}</p>@endif
            @if($invoice->appointment->patient->user?->email)<p>{{ $invoice->appointment->patient->user->email }}</p>@endif
        </div>
        <div class="billing-col" style="text-align:right;">
            <h4 style="text-align:right;">Invoice Info</h4>
            <table class="details-table" style="margin-left:auto;">
                <tr><td class="label">Issue Date</td><td class="value">{{ $invoice->issue_date->format('d M Y') }}</td></tr>
                <tr><td class="label">Due Date</td><td class="value">{{ $invoice->due_date->format('d M Y') }}</td></tr>
                <tr><td class="label">Doctor</td><td class="value">Dr. {{ $invoice->appointment->doctorProfile->user->name }}</td></tr>
                <tr><td class="label">Service Date</td><td class="value">{{ $invoice->appointment->appointment_date->format('d M Y') }}</td></tr>
            </table>
        </div>
    </div>

    {{-- Service line --}}
    <table class="items">
        <thead>
            <tr>
                <th>Description</th>
                <th class="r">Unit Price</th>
                <th class="r">Qty</th>
                <th class="r">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>{{ $invoice->appointment->service?->name ?? 'Dental Consultation' }}</strong>
                    @if($invoice->appointment->service?->description)
                    <div class="item-desc">{{ $invoice->appointment->service->description }}</div>
                    @endif
                </td>
                <td class="r">{{ $currency }}{{ number_format($invoice->subtotal, 2) }}</td>
                <td class="r">1</td>
                <td class="r">{{ $currency }}{{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Totals --}}
    <div class="totals-wrap">
        <div class="totals">
            <div class="totals-row"><span>Subtotal</span><span>{{ $currency }}{{ number_format($invoice->subtotal, 2) }}</span></div>
            @if($invoice->discount_amount > 0)
            <div class="totals-row"><span>Discount</span><span style="color:#dc2626;">− {{ $currency }}{{ number_format($invoice->discount_amount, 2) }}</span></div>
            @endif
            @if($invoice->tax_amount > 0)
            <div class="totals-row"><span>Tax ({{ $invoice->tax_rate }}%)</span><span>{{ $currency }}{{ number_format($invoice->tax_amount, 2) }}</span></div>
            @endif
            <div class="totals-row total-row"><span>TOTAL</span><span>{{ $currency }}{{ number_format($invoice->total_amount, 2) }}</span></div>
            @if($invoice->paid_amount > 0)
            <div class="totals-row"><span style="color:#16a34a;">Paid</span><span style="color:#16a34a;">{{ $currency }}{{ number_format($invoice->paid_amount, 2) }}</span></div>
            @endif
            <div class="totals-row balance-row {{ $invoice->balance_due > 0 ? 'due' : 'paid-bg' }}">
                <span>Balance Due</span>
                <span>{{ $currency }}{{ number_format($invoice->balance_due, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Payment history --}}
    @if($invoice->payments->count())
    <div class="payments">
        <h4>Payment History</h4>
        <table class="pay-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Method</th>
                    <th>Reference</th>
                    <th style="text-align:right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->payments->sortByDesc('paid_at') as $payment)
                <tr>
                    <td>{{ $payment->paid_at->format('d M Y') }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $payment->method)) }}</td>
                    <td>{{ $payment->reference_number ?? '—' }}</td>
                    <td style="text-align:right;" class="pay-amount">{{ $currency }}{{ number_format($payment->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
        Thank you for choosing {{ $clinicName }}.
        @if($clinicPhone) &nbsp;|&nbsp; {{ $clinicPhone }}@endif
        @if($clinicEmail) &nbsp;|&nbsp; {{ $clinicEmail }}@endif
        <br>This is a computer-generated invoice. No signature required.
    </div>

</div>

<script>
    // Auto-open print dialog when page loads
    window.addEventListener('load', function () {
        window.print();
    });
</script>
</body>
</html>
