<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorProfile;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::with('roles')->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:admin,staff,doctor,patient',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        $role = Role::where('name', $data['role'])->first();
        if ($role) $user->roles()->attach($role->id);

        if ($data['role'] === 'patient') {
            $num = 'P' . str_pad(Patient::count() + 1, 5, '0', STR_PAD_LEFT);
            $parts = explode(' ', trim($data['name']), 2);
            Patient::create([
                'user_id'        => $user->id,
                'patient_number' => $num,
                'first_name'     => $parts[0],
                'last_name'      => $parts[1] ?? '-',
                'gender'         => 'other',
            ]);
        } elseif ($data['role'] === 'doctor') {
            DoctorProfile::firstOrCreate(
                ['user_id' => $user->id],
                ['specialty' => 'General Dentistry']
            );
        }

        return response()->json(['success' => true, 'data' => $user->load('roles')], 201);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8',
            'role'     => 'required|in:admin,staff,doctor,patient',
            'is_active'=> 'boolean',
        ]);

        $user->update([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'] ?? $user->phone,
            'is_active' => $data['is_active'] ?? $user->is_active,
            ...( !empty($data['password']) ? ['password' => Hash::make($data['password'])] : [] ),
        ]);

        $role = Role::where('name', $data['role'])->first();
        if ($role) {
            $user->roles()->sync([$role->id]);
        }

        return response()->json(['success' => true, 'data' => $user->load('roles')]);
    }

    public function destroy(User $user): JsonResponse
    {
        if ($user->id === auth()->id()) {
            return response()->json(['message' => 'Cannot delete yourself.'], 403);
        }
        $user->delete();
        return response()->json(['success' => true]);
    }

    public function show(User $user): View
    {
        return view('admin.user-show', compact('user'));
    }

    // unused stubs
    public function create(): View { return view('admin.users'); }
    public function edit($id): View { return view('admin.users'); }
}
