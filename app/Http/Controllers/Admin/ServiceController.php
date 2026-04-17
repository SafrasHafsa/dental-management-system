<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::orderBy('category')->orderBy('name')->get();
        return view('admin.services', compact('services'));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'             => 'required|string|max:100',
            'category'         => 'required|string|max:50',
            'base_price'       => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'description'      => 'nullable|string|max:500',
            'is_active'        => 'boolean',
        ]);
        $data['is_active'] = $data['is_active'] ?? true;
        $service = Service::create($data);
        return response()->json(['success' => true, 'data' => $service], 201);
    }

    public function update(Request $request, Service $service): JsonResponse
    {
        $data = $request->validate([
            'name'             => 'required|string|max:100',
            'category'         => 'required|string|max:50',
            'base_price'       => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'description'      => 'nullable|string|max:500',
            'is_active'        => 'boolean',
        ]);
        $service->update($data);
        return response()->json(['success' => true, 'data' => $service]);
    }

    public function destroy(Service $service): JsonResponse
    {
        $service->delete();
        return response()->json(['success' => true]);
    }

    // Unused stubs kept for resource route binding
    public function create(): View  { return view('admin.services'); }
    public function show($id): View { return $this->index(); }
    public function edit($id): View { return $this->index(); }
}
