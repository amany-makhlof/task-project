<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\User;
use App\Notifications\NewUserNotification;

class NotifyAdminsOfNewUser
{
    public function handle(UserRegistered $event)
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
        })->get();

        foreach ($admins as $admin) {
            $admin->notify(new NewUserNotification($event->user));
        }
    }
}
