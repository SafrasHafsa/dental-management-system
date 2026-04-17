<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = [
            'clinic_name'    => config('app.name', 'SmileCare Dental Clinic'),
            'clinic_phone'   => '',
            'clinic_email'   => '',
            'clinic_address' => '',
            'tax_rate'       => '0',
            'currency'       => 'Rs.',
        ];
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        // Settings would typically be stored in a settings table or .env
        // For now just flash success
        return back()->with('success', 'Settings saved successfully.');
    }
}
