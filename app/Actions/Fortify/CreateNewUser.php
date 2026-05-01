<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, mixed>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
            'registration_role' => ['required', 'in:student,teacher'],
            'institution_name' => ['nullable', 'string', 'max:255', 'required_if:registration_role,teacher'],
            'institution_type' => ['nullable', 'string', 'max:255', 'required_if:registration_role,teacher'],
            'institution_address' => ['nullable', 'string', 'max:1000', 'required_if:registration_role,teacher'],
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'registration_role' => $input['registration_role'],
            'institution_name' => $input['registration_role'] === 'teacher' ? $input['institution_name'] : null,
            'institution_type' => $input['registration_role'] === 'teacher' ? $input['institution_type'] : null,
            'institution_address' => $input['registration_role'] === 'teacher' ? $input['institution_address'] : null,
        ]);

        $user->assignRole($input['registration_role']);

        return $user;
    }
}
