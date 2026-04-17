<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClinicSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = ClinicSetting::allKeyed();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'clinic_name'         => 'required|string|max:200',
            'clinic_phone'        => 'nullable|string|max:50',
            'clinic_email'        => 'nullable|email|max:100',
            'clinic_address'      => 'nullable|string|max:500',
            'tax_rate'            => 'required|numeric|min:0|max:100',
            'currency_symbol'     => 'required|string|max:10',
            'working_hours_start' => 'nullable|string',
            'working_hours_end'   => 'nullable|string',
        ]);

        $fields = [
            'clinic_name'         => ['type' => 'string',  'group' => 'general'],
            'clinic_phone'        => ['type' => 'string',  'group' => 'general'],
            'clinic_email'        => ['type' => 'string',  'group' => 'general'],
            'clinic_address'      => ['type' => 'string',  'group' => 'general'],
            'tax_rate'            => ['type' => 'integer', 'group' => 'billing'],
            'currency_symbol'     => ['type' => 'string',  'group' => 'billing'],
            'working_hours_start' => ['type' => 'string',  'group' => 'schedule'],
            'working_hours_end'   => ['type' => 'string',  'group' => 'schedule'],
        ];

        foreach ($fields as $key => $meta) {
            ClinicSetting::updateOrInsert(
                ['key' => $key],
                ['value' => $request->input($key), 'type' => $meta['type'], 'group' => $meta['group'], 'updated_at' => now()]
            );
        }

        return back()->with('success', 'Settings saved successfully.');
    }
}
