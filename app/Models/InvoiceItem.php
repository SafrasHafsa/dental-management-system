<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    use HasUlids;

    protected $fillable = ['invoice_id', 'item_type', 'service_id', 'description', 'quantity', 'unit_price', 'discount_amount', 'total_price'];

    protected function casts(): array
    {
        return ['unit_price' => 'decimal:2', 'total_price' => 'decimal:2', 'quantity' => 'decimal:3'];
    }

    public function invoice(): BelongsTo { return $this->belongsTo(Invoice::class); }
    public function service(): BelongsTo { return $this->belongsTo(Service::class); }
}
