<?php

namespace App\Notifications\Student;

use App\Models\Online_class;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewLiveClassAdded extends Notification
{
    use Queueable;

    public function __construct(public Online_class $zoom) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'        => 'zoom_class',
            'title'       => $this->zoom->title ?? 'New zoom class',
            'zoom_id' => $this->zoom->id,
            'section_id'  => $this->zoom->section_id,
            'subject_id'  => $this->zoom->subject_id,
            'teacher_id'  => $this->zoom->teacher_id,
            'message'     => 'لديك حصة زووم جديدة',
            'url'         => route('subject.viewZoomClass', $this->zoom),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}
