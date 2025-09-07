<?php

namespace App\Notifications\Student;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewHomeworkAdded extends Notification
{
    use Queueable;
    protected $homeworkId;
    protected $homeworkTitle;
    protected $teacherName;

    public function __construct($homeworkId, $homeworkTitle, $teacherName)
    {
        $this->homeworkId = $homeworkId;
        $this->homeworkTitle = $homeworkTitle;
        $this->teacherName = $teacherName;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'new homework added',
            'body' => 'teacher ' . $this->teacherName . ' added anew homework: ' . $this->homeworkTitle,
            'url' => route('student.homeworks.preview', $this->homeworkId) // url to redirect to reading the notification details
        ];
    }

}
