<?php

namespace App\Exports;

use App\Models\Homework;
use App\Models\Homework_submission;
use App\Models\HomeworkSubmission;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class HomeworkSubmissionsExport implements FromView
{
    protected $homeworkId;

    public function __construct($homeworkId)
    {
        $this->homeworkId = $homeworkId;
    }

    public function view(): View
    {
        $homework = Homework::with(['classroom', 'section', 'grade', 'teacher'])->findOrFail($this->homeworkId);

        // All students in the classroom & section
        $students = $homework->section->students ?? collect();

        // Submissions
        $submissions = Homework_submission::where('homework_id', $this->homeworkId)
            ->get()
            ->keyBy('student_id');

        return view('exports.teachers.homework_submissions', [
            'homework' => $homework,
            'students' => $students,
            'submissions' => $submissions,
        ]);
    }
}
