<?php

namespace App\Notifications\Student;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExamEndedReminder extends Notification
{
    use Queueable;

    public $quiz;

    public function __construct($quiz)
    {
        $this->quiz = $quiz;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'body' => "The exam '{$this->quiz->name}' has ended. You can now review your results.",
            'url' => route('student.exams.preview', $this->quiz->id),
        ];
    }
}
