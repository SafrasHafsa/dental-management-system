<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'phone'      => ['required', 'string', 'max:20'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->first_name . ' ' . $request->last_name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'password' => $request->password,
            ]);

            $user->roles()->attach(Role::where('name', 'patient')->first()->id);

            $patientNumber = 'PT-' . date('Y') . '-' . str_pad(
                Patient::withTrashed()->count() + 1, 5, '0', STR_PAD_LEFT
            );

            $user->patient()->create([
                'patient_number' => $patientNumber,
                'first_name'     => $request->first_name,
                'last_name'      => $request->last_name,
                'date_of_birth'  => $request->date_of_birth,
                'gender'         => $request->gender,
            ]);

            Auth::login($user);
        });

        return redirect()->route('patient.dashboard')
            ->with('success', 'Welcome! Your account has been created.');
    }
}
