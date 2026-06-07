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
            Permission::findOrCreate($permission->value);
        }

        // Create Roles and Assign Permissions
        $recruiterRole = Role::findOrCreate(RoleEnum::RECRUITER->value);
        $recruiterRole->givePermissionTo([
            PermissionEnum::POST_JOB->value,
            PermissionEnum::VIEW_CANDIDATES->value,
            PermissionEnum::MANAGE_OFFERS->value,
        ]);

        $candidateRole = Role::findOrCreate(RoleEnum::CANDIDATE->value);
        $candidateRole->givePermissionTo([
            PermissionEnum::APPLY_JOB->value,
            PermissionEnum::UPDATE_PROFILE->value,
            PermissionEnum::VIEW_MATCHES->value,
        ]);
    }
}
