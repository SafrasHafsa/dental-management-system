<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(): View
    {
        $items = InventoryItem::with('category')->orderBy('name')->get();
        return view('staff.inventory', compact('items'));
    }

    public function adjustStock(Request $request, InventoryItem $item): RedirectResponse
    {
        $request->validate(['quantity' => 'required|integer', 'notes' => 'nullable|string']);
        $item->increment('quantity_in_stock', $request->quantity);
        return back()->with('success', 'Stock updated.');
    }
}
