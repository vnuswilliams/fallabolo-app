<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password'  => $this->passwordRules(),
            'role'      => $this->roleRules(),
            'agree'     => ['required', 'accepted'],
            'updates'   => ['nullable', 'boolean'],
        ])->validate();

        $user = User::create([
            'name'     => $input['name'],
            'email'    => $input['email'],
            'password' => $input['password'],
            'role'     => $input['role'],
            'updates'  => (bool) ($input['updates'] ?? false),
        ]);

        $user->syncRoles($input['role']);

        // Pose le cookie pour ne plus afficher la landing page sur /
        Cookie::queue(
            Cookie::make(
                name    : 'registered',
                value   : '1',
                minutes : 60 * 24 * 365, // 1 an
                secure  : true,
                httpOnly: true,
                sameSite: 'Lax',
            )
        );

        return $user;
    }
}
