<?php

namespace App\Notifications\Student;

use App\Models\Library;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBookAdded extends Notification
{
    use Queueable;

    public function __construct(public Library $library) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title'       => $this->library->title ?? 'New Book',
            'library_id'  => $this->library->id,
            'section_id'  => $this->library->section_id,
            'subject_id'  => $this->library->subject_id,
            'teacher_id'  => $this->library->teacher_id,
            'message'     => 'A new book was added to your section.',
            'url'         => route('subject.viewBook', $this->library),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}
