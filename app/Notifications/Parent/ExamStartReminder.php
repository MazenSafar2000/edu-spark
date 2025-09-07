<?php

namespace App\Notifications\Parent;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExamStartReminder extends Notification
{
    use Queueable;

    public $quiz;
    public $student;

    public function __construct($quiz, $student)
    {
        $this->quiz = $quiz;
        $this->student = $student;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'body' => "{$this->quiz->getTranslation('name', app()->getLocale())} exam started now",
            'url' => route('quiz.preview', ['quiz_id' => $this->quiz->id, 'student_id' => $this->student->id]),
        ];
    }
}
