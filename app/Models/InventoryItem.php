<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryItem extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = [
        'category_id', 'supplier_id', 'sku', 'name', 'description',
        'unit', 'current_stock', 'minimum_stock', 'reorder_quantity',
        'unit_cost', 'selling_price', 'expiry_date', 'location',
        'barcode', 'is_active', 'is_sellable',
    ];

    protected function casts(): array
    {
        return [
            'expiry_date'    => 'date',
            'current_stock'  => 'decimal:3',
            'minimum_stock'  => 'decimal:3',
            'unit_cost'      => 'decimal:2',
            'selling_price'  => 'decimal:2',
            'is_active'      => 'boolean',
            'is_sellable'    => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(InventoryCategory::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function isLowStock(): bool
    {
        return $this->current_stock <= $this->minimum_stock;
    }

    public function isOutOfStock(): bool
    {
        return $this->current_stock <= 0;
    }

    public function stockStatus(): string
    {
        if ($this->isOutOfStock()) return 'out_of_stock';
        if ($this->isLowStock())   return 'low_stock';
        return 'in_stock';
    }

    public function stockBadgeClass(): string
    {
        return match ($this->stockStatus()) {
            'out_of_stock' => 'badge-red',
            'low_stock'    => 'badge-yellow',
            default        => 'badge-green',
        };
    }
}
