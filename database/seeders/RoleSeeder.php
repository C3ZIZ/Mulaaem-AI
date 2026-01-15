<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\UserRole;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        //Permissions - Create permissions FIRST
        $permissions = [
            'view_jobs',
            'create_jobs',
            'publish_jobs',
            'view_applications',
            'process_applications'
        ];

        foreach ($permissions as $perm) {
            Permission::create(['name' => $perm]);
        }

        // Create roles AFTER permissions
        $adminRole = Role::create(['name' => UserRole::Admin->value]);
        $recruiterRole = Role::create(['name' => UserRole::Recruiter->value]);
        $candidateRole = Role::create(['name' => UserRole::Candidate->value]);

        // Assign Permissions to recruiter
        $recruiterRole->givePermissionTo([
            'view_jobs',
            'create_jobs',
            'publish_jobs',
            'view_applications',
            'process_applications'
        ]);

        // Admin everything
        $adminRole->givePermissionTo(Permission::all());

        // Admin User
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@mulaaem.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($adminRole);

        // Recruiter User
        $recruiter = User::factory()->create([
            'name' => 'Recruiter Sarah',
            'email' => 'recruiter@mulaaem.com',
            'password' => bcrypt('password'),
        ]);
        $recruiter->assignRole($recruiterRole);

        // Candidate User
        $candidate = User::factory()->create([
            'name' => 'Candidate John',
            'email' => 'candidate@mulaaem.com',
            'password' => bcrypt('password'),
        ]);
        $candidate->assignRole($candidateRole);
    }
}
