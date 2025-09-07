<?php

namespace App\Notifications\Teacher;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExamEnded extends Notification
{
    use Queueable;

    public $exam;

    public function __construct($exam)
    {
        $this->exam = $exam;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'body' => "The exam '{$this->exam->name}' has ended. You can now review student scores.",
            'quiz_id' => $this->exam->id,
            'url' => route('student.quizze', $this->exam->id),
        ];
    }
}
