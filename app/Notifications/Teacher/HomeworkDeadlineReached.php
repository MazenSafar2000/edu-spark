<?php

namespace App\Notifications\Teacher;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HomeworkDeadlineReached extends Notification
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
            'body' => "The homework '{$this->homework->title}' has reached its deadline. You can now review student submissions.",
            'url' => route('teacher.homeworks.submissions', $this->homework->id),
        ];
    }
}
