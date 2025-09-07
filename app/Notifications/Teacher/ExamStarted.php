<?php

namespace App\Notifications\Teacher;

use App\Models\Quizze;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExamStarted extends Notification
{
    use Queueable;

    public $exam;

    public function __construct(Quizze $exam)
    {
        $this->exam = $exam;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'quiz_id' => $this->exam->id,
            'title' => 'Exam Started',
            'body' => 'Your exam "' . $this->exam->name . '" has just started.',
        ];
    }
}
