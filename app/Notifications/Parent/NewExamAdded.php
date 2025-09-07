<?php

namespace App\Notifications\Parent;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewExamAdded extends Notification
{
    use Queueable;

    protected $exam;
    protected $student;

    public function __construct($exam, $student)
    {
        $this->exam = $exam;
        $this->student = $student;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'exam_id' => $this->exam->id,
            'title' => 'New exam Assigned',
            'body' => 'Your child has a new exam: ' . $this->exam->name,
            'url' => route('quiz.preview', ['quiz_id' => $this->exam->id,'student_id' => $this->student->id]),
        ];
    }
}
