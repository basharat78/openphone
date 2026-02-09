<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $qcAgentRole = Role::firstOrCreate(['name' => 'qc_agent']);

        // Create permissions
        Permission::firstOrCreate(['name' => 'view qc panel']);
        Permission::firstOrCreate(['name' => 'score calls']);
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'view reports']);

        // Assign permissions to roles
        $qcAgentRole->givePermissionTo(['view qc panel', 'score calls']);
        $adminRole->givePermissionTo(Permission::all());
    }
}
