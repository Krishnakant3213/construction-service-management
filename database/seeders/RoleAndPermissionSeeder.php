<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ── Create Permissions ──
        $permissions = [
            // Lead permissions
            'leads.view',
            'leads.create',
            'leads.edit',
            'leads.delete',
            // Site visit permissions
            'site-visits.view',
            'site-visits.create',
            'site-visits.edit',
            'site-visits.delete',
            // Quotation permissions
            'quotations.view',
            'quotations.create',
            'quotations.edit',
            'quotations.delete',
            'quotations.approve',
            'quotations.send',
            // Project permissions
            'projects.view',
            'projects.create',
            'projects.edit',
            'projects.delete',
            // Payment permissions
            'payments.view',
            'payments.create',
            'payments.edit',
            'payments.delete',
            // Service permissions
            'services.view',
            'services.create',
            'services.edit',
            'services.delete',
            // User management
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            // Settings
            'settings.view',
            'settings.edit',
            // Reports
            'reports.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ── Create Roles ──

        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        // Super admin gets all permissions automatically via Gate::before

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permissions);

        $salesExecutive = Role::firstOrCreate(['name' => 'sales-executive']);
        $salesExecutive->syncPermissions([
            'leads.view',
            'leads.create',
            'leads.edit',
            'site-visits.view',
            'site-visits.create',
            'site-visits.edit',
            'quotations.view',
            'quotations.create',
            'quotations.edit',
            'quotations.send',
            'projects.view',
            'services.view',
            'reports.view',
        ]);

        $siteEngineer = Role::firstOrCreate(['name' => 'site-engineer']);
        $siteEngineer->syncPermissions([
            'leads.view',
            'site-visits.view',
            'site-visits.edit',
            'projects.view',
            'projects.edit',
            'services.view',
        ]);

        $accountant = Role::firstOrCreate(['name' => 'accountant']);
        $accountant->syncPermissions([
            'quotations.view',
            'projects.view',
            'payments.view',
            'payments.create',
            'payments.edit',
            'reports.view',
        ]);
    }
}
