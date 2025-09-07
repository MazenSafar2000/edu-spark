<?php

namespace App\Notifications\Parent;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewHomeworkAdded extends Notification
{
    use Queueable;
    protected $homework;
    protected $student;

    public function __construct($homework,$student)
    {
        $this->homework = $homework;
        $this->student = $student;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'homework_id' => $this->homework->id,
            'title' => 'New Homework Assigned',
            'body' => 'Your child has a new homework: ' . $this->homework->title,
            'url' => route('homework.preview', ['homework_id' => $this->homework->id,'student_id' => $this->student->id]),

        ];
    }
}
