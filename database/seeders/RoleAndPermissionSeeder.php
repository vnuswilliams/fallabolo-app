<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        foreach (PermissionEnum::cases() as $permission) {
            Permission::updateOrCreate(['name' => $permission->value]);
        }

        // Create Roles and Assign Permissions
        $recruiterRole = Role::updateOrCreate(['name' => RoleEnum::RECRUITER->value]);
        $recruiterRole->syncPermissions([
            PermissionEnum::POST_JOB->value,
            PermissionEnum::VIEW_CANDIDATES->value,
            PermissionEnum::MANAGE_OFFERS->value,
        ]);

        $candidateRole = Role::updateOrCreate(['name' => RoleEnum::CANDIDATE->value]);
        $candidateRole->syncPermissions([
            PermissionEnum::APPLY_JOB->value,
            PermissionEnum::UPDATE_PROFILE->value,
            PermissionEnum::VIEW_MATCHES->value,
        ]);

        $adminRole = Role::updateOrCreate(['name' => RoleEnum::ADMIN->value]);
        $adminRole->syncPermissions(Permission::all());
    }
}
