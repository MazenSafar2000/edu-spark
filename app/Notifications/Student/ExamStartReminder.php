<?php

namespace App\Notifications\Student;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExamStartReminder extends Notification
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
            'body' => "{$this->quiz->getTranslation('name', app()->getLocale())} exam started now",
            'url' => route('student.exams.preview', $this->quiz->id),

        ];
    }
}
