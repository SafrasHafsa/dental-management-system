<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'invoice_number', 'patient_id', 'appointment_id', 'created_by',
        'status', 'type', 'issue_date', 'due_date',
        'subtotal', 'discount_amount', 'discount_type',
        'tax_rate', 'tax_amount', 'total_amount',
        'paid_amount', 'balance_due', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'issue_date'      => 'date',
            'due_date'        => 'date',
            'subtotal'        => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'tax_amount'      => 'decimal:2',
            'total_amount'    => 'decimal:2',
            'paid_amount'     => 'decimal:2',
            'balance_due'     => 'decimal:2',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function isPaid(): bool      { return $this->status === 'paid'; }
    public function isOverdue(): bool   { return $this->status === 'overdue'; }
    public function isDraft(): bool     { return $this->status === 'draft'; }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'draft'   => 'badge-gray',
            'sent'    => 'badge-blue',
            'partial' => 'badge-yellow',
            'paid'    => 'badge-green',
            'overdue' => 'badge-red',
            'void'    => 'badge-gray',
            default   => 'badge-gray',
        };
    }

    public function recalculate(): void
    {
        $subtotal = $this->items->sum('total_price');
        $discount = $this->discount_type === 'percentage'
            ? $subtotal * ($this->discount_amount / 100)
            : $this->discount_amount;
        $taxable   = $subtotal - $discount;
        $tax       = $taxable * ($this->tax_rate / 100);
        $total     = $taxable + $tax;
        $balance   = $total - $this->paid_amount;

        $this->update([
            'subtotal'        => $subtotal,
            'tax_amount'      => $tax,
            'total_amount'    => $total,
            'balance_due'     => max(0, $balance),
            'status'          => $balance <= 0 ? 'paid' : ($this->paid_amount > 0 ? 'partial' : $this->status),
        ]);
    }
}
