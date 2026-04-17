<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = ['name', 'contact_person', 'email', 'phone', 'address', 'payment_terms', 'notes', 'is_active'];

    public function inventoryItems(): HasMany  { return $this->hasMany(InventoryItem::class); }
    public function purchaseOrders(): HasMany  { return $this->hasMany(PurchaseOrder::class); }
}
