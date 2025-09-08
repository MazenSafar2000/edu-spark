<?php

namespace App\Notifications\Student;

use App\Models\Exam;
use App\Models\SectionExam;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewExamAdded extends Notification
{
    use Queueable;

    public function __construct(
        public Exam $exam,
        public int $sectionId,
        public int $subjectId
    ) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'        => 'exam',
            'title'       => $this->exam->name,
            'exam_id'     => $this->exam->id,
            'section_id'  => $this->sectionId,
            'subject_id'  => $this->subjectId,
            'start_at'    => optional($this->exam->start_at)->toDateTimeString(),
            'end_at'      => optional($this->exam->end_at)->toDateTimeString(),
            'duration'    => $this->exam->duration,
            'message'     => 'A new exam has been assigned to your section.',
            'url'         => route('subject.viewExam', $this->exam),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}
