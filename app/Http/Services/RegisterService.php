<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Events\UserRegistered;
use App\Notifications\NewUserNotification;
use Illuminate\Support\Facades\Notification;

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
            $admins = User::whereHas('roles', function ($query) {
                $query->where('name', 'Admin');
            })->get();

            event(new UserRegistered($user));
            Notification::send($admins, new NewUserNotification($user));
        }

        return $user;
    }
}
