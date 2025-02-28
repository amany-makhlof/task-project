<?php

namespace App\Listeners;

use App\Events\PostApproved;
use App\Notifications\PostApprovalNotification;

class SendPostApprovalNotification
{
    public function handle(PostApproved $event): void
    {
        $event->post->user->notify(new PostApprovalNotification($event->post));
    }
}
