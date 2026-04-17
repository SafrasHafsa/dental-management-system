<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function index(): View
    {
        $patients = Patient::with('user')->latest()->get();
        return view('admin.patients', compact('patients'));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:50',
            'last_name'     => 'required|string|max:50',
            'date_of_birth' => 'nullable|date',
            'gender'        => 'nullable|in:male,female,other',
            'blood_type'    => 'nullable|string|max:5',
            'phone'         => 'nullable|string|max:20',
            'notes'         => 'nullable|string|max:1000',
        ]);

        $num = 'P' . str_pad(Patient::withTrashed()->count() + 1, 5, '0', STR_PAD_LEFT);
        $patient = Patient::create(array_merge($data, ['patient_number' => $num]));

        return response()->json(['success' => true, 'data' => $patient], 201);
    }

    public function update(Request $request, Patient $patient): JsonResponse
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:50',
            'last_name'     => 'required|string|max:50',
            'date_of_birth' => 'nullable|date',
            'gender'        => 'nullable|in:male,female,other',
            'blood_type'    => 'nullable|string|max:5',
            'phone'         => 'nullable|string|max:20',
            'notes'         => 'nullable|string|max:1000',
        ]);
        $patient->update($data);
        return response()->json(['success' => true, 'data' => $patient]);
    }

    public function destroy(Patient $patient): JsonResponse
    {
        $patient->delete();
        return response()->json(['success' => true]);
    }

    public function show(Patient $patient): View
    {
        $patient->load(['user', 'appointments.service', 'appointments.doctorProfile.user']);
        return view('admin.patient-show', compact('patient'));
    }

    // unused stubs
    public function create(): View { return view('admin.patients'); }
    public function edit($id): View { return view('admin.patients'); }
}
