<?php

namespace App\Exports;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Degree;
use App\Models\ExamAttempts;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExamResultsExport implements FromView
{
    protected $exam;

    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
    }

    public function view(): View
    {
        $exam = Exam::with(['teacher', 'sectionExams.section.students.classroom'])->findOrFail($this->exam->id);

        $students = $exam->sectionExams
            ->flatMap(fn($se) => $se->section->students)
            ->unique('id')
            ->values();

        $attempts = ExamAttempts::where('exam_id', $exam->id)->get()->groupBy('student_id');
        $degrees  = Degree::where('exam_id', $exam->id)->get()->keyBy('student_id');

        // Prepare last attempts map
        $lastAttempts = $attempts->map(fn($group) => $group->sortByDesc('attempt_number')->first());

        $testedStudents = $students->filter(
            fn($student) =>
            isset($lastAttempts[$student->id])
        )->count();

        $passed = $failed = 0;

        foreach ($students as $student) {
            $manualDegree = $degrees[$student->id] ?? null;
            $lastAttempt  = $lastAttempts[$student->id] ?? null;

            // Teacher updated degree first
            $grade = $manualDegree->score ?? $lastAttempt->grade_obtained ?? null;

            if ($grade !== null) {
                if ($grade >= $exam->maximum_grade * 0.5) {
                    $passed++;
                } else {
                    $failed++;
                }
            }
        }

        return view('exports.teachers.exam_results', [
            'exam'           => $exam,
            'students'       => $students,
            'attempts'       => $lastAttempts,
            'degrees'        => $degrees,
            'testedStudents' => $testedStudents,
            'passed'         => $passed,
            'failed'         => $failed,
        ]);
    }
}
