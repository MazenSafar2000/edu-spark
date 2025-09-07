<?php

namespace App\Notifications\Student;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HomeworkDeadlineReminder extends Notification
{
    use Queueable;
    public $homework;

    public function __construct($homework)
    {
        $this->homework = $homework;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'body' => "Alert: The assignment deadline'{$this->homework->title}' is approaching",
            'url' => route('student.homeworks.preview', $this->homework->id),
        ];
    }
}
