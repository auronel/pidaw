<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'dni' => ['required', 'regex:/^[1-9]{8}[A-Z]$/', 'unique:users'],
            'name' => ['required', 'regex:/^[a-zA-Z À-ž]+$/', 'max:60'],
            'apellidos' => ['required', 'regex:/^[a-zA-Z À-ž]+$/', 'max:60'],
            'telefono' => ['required', 'regex:/^[0-9]{9}$/', 'unique:users'],
            'email' => ['required', 'string', 'email:filter,dns', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return User::create([
            'dni' => $input['dni'],
            'name' => $input['name'],
            'apellidos' => $input['apellidos'],
            'telefono' => $input['telefono'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
