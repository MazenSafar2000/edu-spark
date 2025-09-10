<?php

namespace App\Notifications\Parent;

use App\Models\Homework;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewHomeworkAdded extends Notification
{
    use Queueable;

    public function __construct(public Homework $homework, public Student $child) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        $title = $this->homeworkTitle();

        return [
            'type'        => 'child_homework_assigned',
            'title'       => $title,
            'message'     => "New homework for {$this->child->user->name}: {$title}",
            'homework_id' => $this->homework->id,
            'child_id'    => $this->child->id,
            'child_name'  => $this->child->user->name,
            'subject_id'  => $this->homework->subject_id ?? null,
            'section_id'  => $this->child->section_id,
            'due_at'      => optional($this->homework->due_at)->toIso8601String(),
            'url'         => route('homework.details', ['homeworkId' => $this->homework->id, 'studentId' => $this->child->id]),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable) + [
            'notified_at' => now()->toISOString(),
        ]);
    }

    private function homeworkTitle(): string
    {
        if (method_exists($this->homework, 'getTranslation')) {
            return $this->homework->getTranslation('title', app()->getLocale());
        }
        return (string) ($this->homework->title ?? 'Homework');
    }
}
