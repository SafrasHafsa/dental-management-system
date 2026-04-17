<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Roles ────────────────────────────────────────────
        $roles = [
            ['name' => 'admin',   'display_name' => 'Administrator'],
            ['name' => 'doctor',  'display_name' => 'Doctor'],
            ['name' => 'staff',   'display_name' => 'Staff'],
            ['name' => 'patient', 'display_name' => 'Patient'],
        ];

        foreach ($roles as $r) {
            Role::firstOrCreate(['name' => $r['name']], $r);
        }

        // ─── Permissions ──────────────────────────────────────
        $permissions = [
            // Dashboard
            ['name' => 'dashboard.view',         'module' => 'dashboard',   'display_name' => 'View Dashboard'],

            // Patients
            ['name' => 'patients.view',           'module' => 'patients',    'display_name' => 'View Patients'],
            ['name' => 'patients.create',         'module' => 'patients',    'display_name' => 'Create Patients'],
            ['name' => 'patients.edit',           'module' => 'patients',    'display_name' => 'Edit Patients'],
            ['name' => 'patients.delete',         'module' => 'patients',    'display_name' => 'Delete Patients'],
            ['name' => 'patients.medical_history','module' => 'patients',    'display_name' => 'View Medical History'],

            // Appointments
            ['name' => 'appointments.view',       'module' => 'appointments','display_name' => 'View Appointments'],
            ['name' => 'appointments.create',     'module' => 'appointments','display_name' => 'Create Appointments'],
            ['name' => 'appointments.edit',       'module' => 'appointments','display_name' => 'Edit Appointments'],
            ['name' => 'appointments.approve',    'module' => 'appointments','display_name' => 'Approve Appointments'],
            ['name' => 'appointments.cancel',     'module' => 'appointments','display_name' => 'Cancel Appointments'],

            // Clinical
            ['name' => 'clinical.view',           'module' => 'clinical',    'display_name' => 'View Clinical Notes'],
            ['name' => 'clinical.manage',         'module' => 'clinical',    'display_name' => 'Manage Clinical Notes'],

            // Billing
            ['name' => 'billing.view',            'module' => 'billing',     'display_name' => 'View Invoices'],
            ['name' => 'billing.create',          'module' => 'billing',     'display_name' => 'Create Invoices'],
            ['name' => 'billing.edit',            'module' => 'billing',     'display_name' => 'Edit Invoices'],
            ['name' => 'billing.delete',          'module' => 'billing',     'display_name' => 'Delete Invoices'],
            ['name' => 'billing.payments',        'module' => 'billing',     'display_name' => 'Record Payments'],

            // Inventory
            ['name' => 'inventory.view',          'module' => 'inventory',   'display_name' => 'View Inventory'],
            ['name' => 'inventory.manage',        'module' => 'inventory',   'display_name' => 'Manage Inventory'],
            ['name' => 'inventory.purchase_orders','module' => 'inventory',  'display_name' => 'Manage Purchase Orders'],

            // Reports
            ['name' => 'reports.view',            'module' => 'reports',     'display_name' => 'View Reports'],

            // Users / Settings (admin only)
            ['name' => 'users.manage',            'module' => 'admin',       'display_name' => 'Manage Users'],
            ['name' => 'settings.manage',         'module' => 'admin',       'display_name' => 'Manage Settings'],
            ['name' => 'services.manage',         'module' => 'admin',       'display_name' => 'Manage Services'],
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p['name']], $p);
        }

        // ─── Role → Permission assignments ────────────────────

        $adminRole   = Role::where('name', 'admin')->first();
        $doctorRole  = Role::where('name', 'doctor')->first();
        $staffRole   = Role::where('name', 'staff')->first();
        $patientRole = Role::where('name', 'patient')->first();

        // Admin gets everything
        $adminRole->permissions()->sync(Permission::pluck('id'));

        // Doctor permissions
        $doctorPermissions = Permission::whereIn('name', [
            'dashboard.view',
            'patients.view', 'patients.medical_history',
            'appointments.view',
            'clinical.view', 'clinical.manage',
            'billing.view',
        ])->pluck('id');
        $doctorRole->permissions()->sync($doctorPermissions);

        // Staff permissions
        $staffPermissions = Permission::whereIn('name', [
            'dashboard.view',
            'patients.view', 'patients.create', 'patients.edit',
            'appointments.view', 'appointments.create', 'appointments.edit',
            'appointments.approve', 'appointments.cancel',
            'clinical.view',
            'billing.view', 'billing.create', 'billing.edit', 'billing.payments',
            'inventory.view', 'inventory.manage',
        ])->pluck('id');
        $staffRole->permissions()->sync($staffPermissions);

        // Patient permissions (own data only — enforced by policies)
        $patientPermissions = Permission::whereIn('name', [
            'appointments.view', 'appointments.create',
            'billing.view',
        ])->pluck('id');
        $patientRole->permissions()->sync($patientPermissions);
    }
}
