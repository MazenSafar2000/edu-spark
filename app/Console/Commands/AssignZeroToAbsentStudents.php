<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Degree;
use App\Models\ExamAttempts;

class AssignZeroToAbsentStudents extends Command
{
    protected $signature = 'exams:assign-zeros';
    protected $description = 'Assign 0 degree to students who did not attempt exams after end time';

    public function handle()
    {
        $now = now();

        // Get exams that already finished
        $exams = Exam::with('sections.students')
            ->where('end_at', '<', $now)
            ->get();

        foreach ($exams as $exam) {
            foreach ($exam->sections as $section) {
                foreach ($section->students as $student) {
                    $hasAttempt = ExamAttempts::where('exam_id', $exam->id)
                        ->where('student_id', $student->id)
                        ->exists();

                    if (!$hasAttempt) {
                        Degree::firstOrCreate(
                            [
                                'exam_id' => $exam->id,
                                'student_id' => $student->id,
                            ],
                            [
                                'score' => 0,
                                'date' => $now,
                                'feedback' => 'غياب عن الامتحان',
                                'absence' => '1',
                            ]
                        );
                        $this->info("Assigned 0 to student {$student->id} for exam {$exam->id}");
                    }
                }
            }
        }

        return Command::SUCCESS;
    }
}
