<?php

namespace App\Notifications\Parent;

use App\Models\Exam;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewExamAdded extends Notification
{
    use Queueable;

    public function __construct(public Exam $exam, public Student $child) {}

    public function via($notifiable): array
    {
        // Persist + realtime broadcast
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        $title = $this->examTitle();

        return [
            'type'        => 'child_exam_assigned',
            'title'       => $title,
            'message'     => "New exam for {$this->child->user->name}: {$title}",
            'exam_id'     => $this->exam->id,
            'child_id'    => $this->child->id,
            'child_name'  => $this->child->user->name,
            'subject_id'  => $this->exam->subject_id ?? null,
            'section_id'  => $this->child->section_id,
            'start_at'    => optional($this->exam->start_at)->toIso8601String(),
            'end_at'      => optional($this->exam->end_at)->toIso8601String(),
            'url'         => route('exam.details', ['examId' => $this->exam->id, 'studentId' => $this->child->id]),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable) + [
            'notified_at' => now()->toISOString(),
        ]);
    }

    private function examTitle(): string
    {
        if (method_exists($this->exam, 'getTranslation')) {
            return $this->exam->getTranslation('name', app()->getLocale());
        }
        return (string) $this->exam->name;
    }
}
