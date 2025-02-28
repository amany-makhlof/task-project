<?php

namespace App\Http\Services;

use App\Exceptions\CredentialsNotCorrectException;
use App\Exceptions\EmailNotVerifiedException;
use App\Mail\EmailVerificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class LoginService
{
    public static function authenticate(array $data): User
    {
        if (! auth()->attempt([
            'email' => strtolower($data['email']),
            'password' => $data['password'],
        ])) {
            throw new CredentialsNotCorrectException();
        }

        return auth()->user();
    }
}
