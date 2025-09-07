<?php

namespace App\Console\Commands;

use App\Models\Exam;
use App\Models\Quizze;
use App\Models\Student;
use App\Notifications\Parent\ExamStartReminder as ParentExamStartReminder;
use App\Notifications\Student\ExamEndedReminder;
use App\Notifications\Student\ExamStartReminder;
use App\Notifications\Teacher\ExamEnded;
use App\Notifications\Teacher\ExamStarted;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class NotifyExamStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:exam-start-or-end';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify students and teacher when an exam is starting or ending.';

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
        // ===== 1. Exam Starting Notifications (Students & Teacher) =====
        $quizzes = Exam::where('start_at', '<=', $now)
            ->where('start_at', '>=', $now->copy()->subMinute())
            ->get();

        foreach ($quizzes as $quiz) {
            $cacheKey = "quiz_{$quiz->id}_start_notified";

            if (!Cache::has($cacheKey)) {
                // ✅ Notify students
                $students = Student::where('grade_id', $quiz->grade_id)
                    ->where('classroom_id', $quiz->classroom_id)
                    ->where('section_id', $quiz->section_id)
                    ->get();

                foreach ($students as $student) {
                    $student->notify(new ExamStartReminder($quiz));
                }

                // ✅ Notify teacher
                $teacher = $quiz->teacher;
                if ($teacher) {
                    $teacher->notify(new ExamStarted($quiz));
                }

                // ✅ Prevent duplicate notifications for both
                Cache::put($cacheKey, true, now()->addDay());
            }
        }

        // ===== 2. Exam Ending Notifications (Students & Teacher) =====
        $endedExams = Exam::where('end_at', '<=', $now)
            ->where('end_at', '>=', $now->copy()->subMinute())
            ->get();

        foreach ($endedExams as $quiz) {
            $cacheKey = "quiz_{$quiz->id}_end_notified";

            if (!Cache::has($cacheKey)) {
                // Notify teacher
                $teacher = $quiz->teacher;
                if ($teacher) {
                    $teacher->notify(new ExamEnded($quiz));
                }

                // Notify students
                $students = Student::where('grade_id', $quiz->grade_id)
                    ->where('classroom_id', $quiz->classroom_id)
                    ->where('section_id', $quiz->section_id)
                    ->get();

                foreach ($students as $student) {
                    $student->notify(new ExamEndedReminder($quiz));
                }

                Cache::put($cacheKey, true, now()->addDay()); // longer cache = better safety
            }
        }

        $this->info('Exam notifications sent.');
    }
}
