<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // General
            ['name' => 'Dental Consultation',      'category' => 'General',    'duration_minutes' => 30,  'base_price' => 500.00],
            ['name' => 'Teeth Cleaning (Prophylaxis)', 'category' => 'General', 'duration_minutes' => 60, 'base_price' => 1500.00],
            ['name' => 'Dental X-Ray (Periapical)', 'category' => 'General',   'duration_minutes' => 15,  'base_price' => 300.00],
            ['name' => 'Dental X-Ray (Panoramic)',  'category' => 'General',   'duration_minutes' => 15,  'base_price' => 800.00],
            // Restorative
            ['name' => 'Tooth Filling (Composite)', 'category' => 'Restorative','duration_minutes' => 60, 'base_price' => 2000.00],
            ['name' => 'Tooth Filling (Amalgam)',   'category' => 'Restorative','duration_minutes' => 60, 'base_price' => 1500.00],
            ['name' => 'Dental Crown (PFM)',        'category' => 'Restorative','duration_minutes' => 90, 'base_price' => 8000.00],
            ['name' => 'Dental Crown (Zirconia)',   'category' => 'Restorative','duration_minutes' => 90, 'base_price' => 12000.00],
            // Surgical
            ['name' => 'Tooth Extraction (Simple)', 'category' => 'Surgical',  'duration_minutes' => 30,  'base_price' => 800.00],
            ['name' => 'Tooth Extraction (Surgical)','category' => 'Surgical', 'duration_minutes' => 60,  'base_price' => 2500.00],
            ['name' => 'Root Canal Treatment',      'category' => 'Endodontic','duration_minutes' => 120, 'base_price' => 6000.00],
            // Orthodontics
            ['name' => 'Braces Consultation',       'category' => 'Orthodontics','duration_minutes' => 45,'base_price' => 0.00],
            ['name' => 'Metal Braces',              'category' => 'Orthodontics','duration_minutes' => 120,'base_price' => 35000.00],
            ['name' => 'Ceramic Braces',            'category' => 'Orthodontics','duration_minutes' => 120,'base_price' => 50000.00],
            // Cosmetic
            ['name' => 'Teeth Whitening',           'category' => 'Cosmetic',  'duration_minutes' => 90,  'base_price' => 5000.00],
            ['name' => 'Dental Veneers (per tooth)','category' => 'Cosmetic',  'duration_minutes' => 90,  'base_price' => 10000.00],
        ];

        foreach ($services as $s) {
            Service::firstOrCreate(['name' => $s['name']], array_merge($s, ['is_active' => true]));
        }
    }
}
