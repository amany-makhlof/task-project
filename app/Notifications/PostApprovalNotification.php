<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Post;

class PostApprovalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $post;

    /**
     * Create a new notification instance.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database', 'mail']; // إرسال الإشعار عبر البريد وقاعدة البيانات
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Post Pending Approval')
                    ->line("A new post titled '{$this->post->title}' has been submitted for approval.")
                    ->action('Review Post', url("/admin/posts/{$this->post->id}"))
                    ->line('Please review and approve or reject it.');
    }

    /**
     * Get the array representation of the notification for database storage.
     */
    public function toArray($notifiable)
    {
        return [
            'post_id' => $this->post->id,
            'title' => $this->post->title,
            'message' => "A new post titled '{$this->post->title}' is pending approval."
        ];
    }
}
