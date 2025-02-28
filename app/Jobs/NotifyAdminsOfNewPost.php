<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
use App\Notifications\PostApprovalNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyAdminsOfNewPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle(): void
    {
        // جلب جميع الإدمن وإرسال الإشعار لهم
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
        })->get();

        foreach ($admins as $admin) {
            $admin->notify(new PostApprovalNotification($this->post));
        }
    }
}
