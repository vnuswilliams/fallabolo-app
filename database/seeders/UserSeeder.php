<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Recruteur TechCorp',
                'email' => 'recruteur1@test.cm',
                'password' => Hash::make('password'),
                'role' => RoleEnum::RECRUITER,
            ],
            [
                'name' => 'Recruteur FinGroup',
                'email' => 'recruteur2@test.cm',
                'password' => Hash::make('password'),
                'role' => RoleEnum::RECRUITER,
            ],
            [
                'name' => 'Recruteur AgenceDig',
                'email' => 'recruteur3@test.cm',
                'password' => Hash::make('password'),
                'role' => RoleEnum::RECRUITER,
            ],
            [
                'name' => 'Jean Ekotto',
                'email' => 'candidat1@test.cm',
                'password' => Hash::make('password'),
                'role' => RoleEnum::CANDIDATE,
            ],
            [
                'name' => 'Marie Mballa',
                'email' => 'candidat2@test.cm',
                'password' => Hash::make('password'),
                'role' => RoleEnum::CANDIDATE,
            ],
            [
                'name' => 'Alain Nkodo',
                'email' => 'candidat3@test.cm',
                'password' => Hash::make('password'),
                'role' => RoleEnum::CANDIDATE,
            ],
            [
                'name' => 'Admin MatchRH',
                'email' => 'admin@matchrh.cm',
                'password' => Hash::make('password'),
                'role' => RoleEnum::ADMIN,
            ],
            [
                'name' => 'Bénévole Manager',
                'email' => 'benevole@test.cm',
                'password' => Hash::make('password'),
                'role' => RoleEnum::RECRUITER,
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);
            $user->assignRole($userData['role']->value);
        }
    }
}
