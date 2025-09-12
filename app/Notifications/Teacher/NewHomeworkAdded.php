<?php

namespace App\Notifications\Teacher;

use App\Models\Homework;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewHomeworkAdded extends Notification
{
    use Queueable;

    public function __construct(public Homework $homework) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'        => 'homework',
            'title'       => $this->homework->title ?? 'New homework',
            'homework_id' => $this->homework->id,
            'section_id'  => $this->homework->section_id,
            'subject_id'  => $this->homework->subject_id,
            'teacher_id'  => $this->homework->teacher_id,
            'message'     => 'The manager added a new homework instead of you.',
            'url'         => route('homeworks.index'),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}
