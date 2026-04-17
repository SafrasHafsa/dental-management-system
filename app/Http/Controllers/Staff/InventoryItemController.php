<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryItemController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'             => 'required|string|max:100',
            'unit'             => 'required|string|max:20',
            'current_stock'    => 'required|numeric|min:0',
            'minimum_stock'    => 'required|numeric|min:0',
            'unit_cost'        => 'nullable|numeric|min:0',
            'selling_price'    => 'nullable|numeric|min:0',
            'description'      => 'nullable|string|max:300',
            'is_active'        => 'boolean',
        ]);
        $data['is_active'] = $data['is_active'] ?? true;
        $item = InventoryItem::create($data);
        return response()->json(['success' => true, 'data' => $item], 201);
    }

    public function update(Request $request, InventoryItem $item): JsonResponse
    {
        $data = $request->validate([
            'name'          => 'required|string|max:100',
            'unit'          => 'required|string|max:20',
            'current_stock' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
            'unit_cost'     => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'description'   => 'nullable|string|max:300',
            'is_active'     => 'boolean',
        ]);
        $item->update($data);
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function destroy(InventoryItem $item): JsonResponse
    {
        $item->delete();
        return response()->json(['success' => true]);
    }

    // unused stubs
    public function index(): View  { return view('staff.inventory'); }
    public function create(): View { return view('staff.inventory'); }
    public function show($id): View { return view('staff.inventory'); }
    public function edit($id): View { return view('staff.inventory'); }
}
