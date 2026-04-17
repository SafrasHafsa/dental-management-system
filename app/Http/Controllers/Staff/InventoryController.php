<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\StockMovement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(): View
    {
        $items = InventoryItem::with('category')->orderBy('name')->get();
        return view('staff.inventory', compact('items'));
    }

    public function movements(InventoryItem $item): View
    {
        $movements = $item->stockMovements()
            ->with('performedBy')
            ->orderByDesc('performed_at')
            ->paginate(30);

        return view('staff.inventory-movements', compact('item', 'movements'));
    }

    public function adjustStock(Request $request, InventoryItem $item): JsonResponse
    {
        $request->validate([
            'quantity'      => 'required|integer|not_in:0',
            'movement_type' => 'required|in:purchase,usage,adjustment,return,waste',
            'notes'         => 'nullable|string|max:300',
        ]);

        $qty        = (int) $request->quantity;
        $newBalance = (float) $item->current_stock + $qty;

        if ($newBalance < 0) {
            return response()->json(['error' => 'Cannot reduce stock below zero.'], 422);
        }

        $item->update(['current_stock' => $newBalance]);

        StockMovement::create([
            'inventory_item_id' => $item->id,
            'movement_type'     => $request->movement_type,
            'quantity'          => $qty,
            'balance_after'     => $newBalance,
            'unit_cost'         => $item->unit_cost,
            'notes'             => $request->notes,
            'performed_by'      => auth()->id(),
            'performed_at'      => now(),
        ]);

        return response()->json([
            'success'   => true,
            'new_stock' => $newBalance,
            'is_low'    => $item->isLowStock(),
        ]);
    }
}
