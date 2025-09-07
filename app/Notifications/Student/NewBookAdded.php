<?php

namespace App\Notifications\Student;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBookAdded extends Notification
{
    use Queueable;

    public function __construct(
        protected int $bookId,
        protected string $bookTitle,
        protected string $teacherName
    ) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast']; // add 'mail' later if needed
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'كتاب جديد',
            'body'  => 'المعلم ' . $this->teacherName . ' أضاف كتابًا: ' . $this->bookTitle,
            // ✅ point to the right place for books
            'action_url' => route('subject.viewBook', $this->bookId),
            'meta'  => [
                'library_id' => $this->bookId,
                'type'       => 'library',
            ],
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }

    // Optional: customize JS event name if you want `.listen('.new-book')`
    public function broadcastType(): string
    {
        return 'new-book';
    }
}
