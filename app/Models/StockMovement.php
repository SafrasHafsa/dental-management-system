<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    use HasUlids;

    protected $fillable = ['inventory_item_id', 'movement_type', 'reference_type', 'reference_id', 'quantity', 'balance_after', 'unit_cost', 'notes', 'performed_by', 'performed_at'];

    protected function casts(): array
    {
        return ['performed_at' => 'datetime', 'quantity' => 'decimal:3', 'balance_after' => 'decimal:3'];
    }

    public function inventoryItem(): BelongsTo { return $this->belongsTo(InventoryItem::class); }
    public function performedBy(): BelongsTo { return $this->belongsTo(User::class, 'performed_by'); }
}
