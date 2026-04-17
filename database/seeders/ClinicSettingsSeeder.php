<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClinicSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'clinic_name',      'value' => 'SmileCare Dental Clinic', 'type' => 'string',  'group' => 'general'],
            ['key' => 'clinic_address',   'value' => '123 Mabini St., Manila',  'type' => 'string',  'group' => 'general'],
            ['key' => 'clinic_phone',     'value' => '+63 2 8123-4567',         'type' => 'string',  'group' => 'general'],
            ['key' => 'clinic_email',     'value' => 'info@smilecare.ph',       'type' => 'string',  'group' => 'general'],
            ['key' => 'clinic_logo',      'value' => null,                      'type' => 'string',  'group' => 'general'],
            ['key' => 'currency',         'value' => 'PHP',                     'type' => 'string',  'group' => 'billing'],
            ['key' => 'currency_symbol',  'value' => '₱',                      'type' => 'string',  'group' => 'billing'],
            ['key' => 'tax_rate',         'value' => '0',                       'type' => 'integer', 'group' => 'billing'],
            ['key' => 'invoice_prefix',   'value' => 'INV',                     'type' => 'string',  'group' => 'billing'],
            ['key' => 'appointment_prefix','value' => 'APT',                    'type' => 'string',  'group' => 'appointments'],
            ['key' => 'patient_prefix',   'value' => 'PT',                      'type' => 'string',  'group' => 'appointments'],
            ['key' => 'low_stock_alert',  'value' => '1',                       'type' => 'boolean', 'group' => 'inventory'],
            ['key' => 'working_hours_start','value' => '08:00',                 'type' => 'string',  'group' => 'schedule'],
            ['key' => 'working_hours_end',  'value' => '17:00',                 'type' => 'string',  'group' => 'schedule'],
        ];

        foreach ($settings as $s) {
            DB::table('clinic_settings')->updateOrInsert(['key' => $s['key']], $s);
        }
    }
}
