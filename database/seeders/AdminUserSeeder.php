<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Admin ────────────────────────────────────────────
        $admin = User::firstOrCreate(
            ['email' => 'admin@dental.com'],
            [
                'name'     => 'System Admin',
                'password' => Hash::make('Admin@1234'),
                'phone'    => '+772628911',
                'is_active'=> true,
            ]
        );
        $admin->roles()->syncWithoutDetaching([Role::where('name', 'admin')->first()->id]);

        // ─── Sample Doctor ────────────────────────────────────
        $doctor = User::firstOrCreate(
            ['email' => 'dr.Sajith@dental.com'],
            [
                'name'     => 'Sajith Irfan',
                'password' => Hash::make('Doctor@1234'),
                'phone'    => '+772826922',
                'is_active'=> true,
            ]
        );
        $doctor->roles()->syncWithoutDetaching([Role::where('name', 'doctor')->first()->id]);

        if (! $doctor->doctorProfile) {
            $doctor->doctorProfile()->create([
                'specialization' => 'General Dentistry',
                'license_number' => 'PRC-12345',
                'bio'            => 'Experienced general dentist with 10+ years of practice.',
            ]);
        }

        // ─── Sample Staff ─────────────────────────────────────
        $staff = User::firstOrCreate(
            ['email' => 'staff@dental.com'],
            [
                'name'     => 'Hafsa Aman',
                'password' => Hash::make('Staff@1234'),
                'phone'    => '+767141703',
                'is_active'=> true,
            ]
        );
        $staff->roles()->syncWithoutDetaching([Role::where('name', 'staff')->first()->id]);

        // ─── Sample Patient ───────────────────────────────────
        $patientUser = User::firstOrCreate(
            ['email' => 'patient@dental.com'],
            [
                'name'     => 'Aamina Safras',
                'password' => Hash::make('Patient@1234'),
                'phone'    => '+779686785',
                'is_active'=> true,
            ]
        );
        $patientUser->roles()->syncWithoutDetaching([Role::where('name', 'patient')->first()->id]);

        if (! $patientUser->patient) {
            $patientUser->patient()->create([
                'patient_number' => 'PT-2024-00001',
                'first_name'     => 'Aamina',
                'last_name'      => 'Safras',
                'date_of_birth'  => '1990-05-15',
                'gender'         => 'male',
            ]);
        }

        $this->command->info('Default users created:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin',   'admin@dental.com',      'Admin@1234'],
                ['Doctor',  'dr.sajith@dental.com',   'Doctor@1234'],
                ['Staff',   'staff@dental.com',      'Staff@1234'],
                ['Patient', 'patient@dental.com',    'Patient@1234'],
            ]
        );
    }
}
