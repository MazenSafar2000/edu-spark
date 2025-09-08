<?php

namespace App\Notifications\Student;

use App\Models\Recorded_class;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewRecordedClassAdded extends Notification
{
    use Queueable;

    public function __construct(public Recorded_class $recording) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'        => 'recorded_class',
            'title'       => $this->recording->title ?? 'New recorded class',
            'recording_id' => $this->recording->id,
            'section_id'  => $this->recording->section_id,
            'subject_id'  => $this->recording->subject_id,
            'teacher_id'  => $this->recording->teacher_id,
            'message'     => 'A new recorded class has been posted for your section.',
            'url'         => route('subject.viewRecoreded', $this->recording),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}
