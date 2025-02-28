<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterService
{
    public static function register(array $data): User
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            $user = User::create([
                'email' => $data['email'],
                'name' => $data['name'],
                'password' => Hash::make($data['password'])
            ]);
        }

        return $user;
    }
}
