<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $user    = Auth::user()->load('patient');
        $patient = $user->patient;

        return view('patient.profile', compact('user', 'patient'));
    }

    public function update(Request $request): RedirectResponse
                {
        $user = Auth::user();

        $request->validate([
            'name'                  => 'required|string|max:100',
            'phone'                 => 'nullable|string|max:20',
            'avatar'                => 'nullable|image|max:2048',
            'current_password'      => 'nullable|required_with:password',
            'password'              => 'nullable|min:8|confirmed',
        ]);

        $updateData = [
            'name'  => $request->name,
            'phone' => $request->phone,
        ];

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $updateData['avatar'] = $path;
        }

        $user->update($updateData);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $updateData['avatar'] = $path;
        }

        $user->update($updateData);

            if ($request->filled('password')) {
                abort_unless(Hash::check($request->current_password, $user->password), 422, 'Current password is incorrect.');
                $user->update(['password' => bcrypt($request->password)]);
            }

        if ($user->patient) {
            $user->patient->update([
                'first_name' => $request->input('first_name', $user->patient->first_name),
                'last_name'  => $request->input('last_name',  $user->patient->last_name),
                'date_of_birth' => $request->date_of_birth,
                'gender'     => $request->gender,
                'address'    => $request->address,
            ]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }
}
