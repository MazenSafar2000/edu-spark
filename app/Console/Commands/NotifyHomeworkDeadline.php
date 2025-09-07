<?php

namespace App\Console\Commands;

use App\Models\Homework;
use App\Models\Student;
use App\Notifications\Student\HomeworkDeadlineReminder;
use App\Notifications\Teacher\HomeworkDeadlineReached;
use Illuminate\Console\Command;

class NotifyHomeworkDeadline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:homework-deadline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify students before homework deadline';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = now();

        // Notify students 10 minutes before the homework deadline
        $homeworks = Homework::where('due_date', '>=', $now)
            ->where('due_date', '<=', $now->copy()->addMinutes(10)) // Adjusted from subMinute() to addMinutes()
            ->get();

        foreach ($homeworks as $homework) {
            $students = Student::where('grade_id', $homework->grade_id)
                ->where('classroom_id', $homework->classroom_id)
                ->where('section_id', $homework->section_id)
                ->get();

            foreach ($students as $student) {
                dispatch(function () use ($student, $homework) {
                    $student->notify(new HomeworkDeadlineReminder($homework));
                });
            }

            $teacher = $homework->teacher;

            // ✅ Prevent duplicate notifications
            $alreadyNotified = $teacher->notifications()
                ->where('type', HomeworkDeadlineReached::class)
                ->where('data->homework_id', $homework->id)
                ->exists();

            if (! $alreadyNotified) {
                $teacher->notify(new HomeworkDeadlineReached($homework));
            }
        }


        $this->info('Homework deadline notifications sent.');
    }
}
