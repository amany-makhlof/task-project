<?php
namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\ActivityLog;

class LogUserRegistration
{
    public function handle(UserRegistered $event)
    {
        ActivityLog::create([
            'user_id' => $event->user->id,
             'activity' => 'User registered: ' . $event->user->email
        ]);
    }
}
