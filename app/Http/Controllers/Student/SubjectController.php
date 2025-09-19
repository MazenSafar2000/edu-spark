<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempts;
use App\Models\Homework;
use App\Models\Homework_submission;
use App\Models\Library;
use App\Models\Online_class;
use App\Models\Recorded_class;
use App\Models\SectionExam;
use App\Models\Subject;
use App\Models\Teacher_section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function showSubjectContent($teacherSectionId)
    {
        // Get Teacher_section with relationships
        $teacherSection = Teacher_section::with(['section.My_classs.Grades', 'subject'])
            ->findOrFail($teacherSectionId);

        // Extract IDs for filtering
        $gradeId      = $teacherSection->section->My_classs->Grades->id;
        $classroomId  = $teacherSection->section->My_classs->id;
        $sectionId    = $teacherSection->section->id;
        $subjectId    = $teacherSection->subject_id; 
        $teacherId    = $teacherSection->teacher_id;

        // Define a helper query builder function
        $filter = fn($model) => $model::where([
            ['grade_id', $gradeId],
            ['classroom_id', $classroomId],
            ['teacher_id', $teacherId],
            ['subject_id', $subjectId],
        ])->orderBy('created_at', 'asc');

        // Get materials
        $books     = $filter(Library::class)->get();
        $homeworks = $filter(Homework::class)->get();
        $recorded  = $filter(Recorded_class::class)->get();
        $online    = $filter(Online_class::class)->get();
        $exams = Exam::whereHas('sections', function ($q) use ($sectionId) {
            $q->where('section_id', $sectionId);
        })
            ->where('subject_id', $subjectId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Merge all materials into one collection
        $materials = collect()
            ->merge($books->map(fn($item) => [
                'type'       => 'book',
                'title'      => $item->title,
                'created_at' => $item->created_at,
                'data'       => $item,
            ]))
            ->merge($homeworks->map(fn($item) => [
                'type'       => 'homework',
                'title'      => $item->title,
                'created_at' => $item->created_at,
                'data'       => $item,
            ]))
            ->merge($exams->map(fn($item) => [
                'type'       => 'exam',
                'title'      => $item->name,
                'created_at' => $item->created_at,
                'data'       => $item,
            ]))
            ->merge($recorded->map(fn($item) => [
                'type'       => 'recorded',
                'title'      => $item->title,
                'created_at' => $item->created_at,
                'data'       => $item,
            ]))
            ->merge($online->map(fn($item) => [
                'type'       => 'online',
                'title'      => $item->topic,
                'created_at' => $item->created_at,
                'data'       => $item,
            ]))
            ->sortBy('created_at')
            ->values();

        return view('pages.Student.courses.index', [
            'teacher_section' => $teacherSection,
            'materials'       => $materials
        ]);
    }


    public function viewBook($id)
    {
        $book = Library::findOrFail($id);

        return view('pages.student.courses.viewBook', compact('book'));
    }

    public function viewHomework($id)
    {
        $student = Auth::user()->student;
        $homework = Homework::findOrFail($id);
        $submission = Homework_submission::where('homework_id', $homework->id)
            ->where('student_id', $student->id)
            ->first();

        return view('pages.Student.homeworks.viewHomework', compact('homework', 'submission'));
    }

    public function viewRecoreded($id)
    {
        $class = Recorded_class::findOrFail($id);

        return view('pages.Student.courses.viewRecoreded', compact('class'));
    }

    public function viewExam($id)
    {
        $exam = Exam::findOrFail($id);

        $student_id = Auth::user()->student->id;

        // Get all attempts of this student for this exam
        $examAttempts = ExamAttempts::where('exam_id', $exam->id)
            ->where('student_id', $student_id)
            ->orderBy('attempt_number')
            ->get();

        return view('pages.Student.exams.viewExam', compact('exam', 'student_id', 'examAttempts'));
    }

    public function viewZoomClass($id)
    {
        $class = Online_class::findOrFail($id);

        return view('pages.Student.courses.viewZoomClass', compact('class'));
    }

    public function viewScores($teacherSectionId)
    {
        $student   = Auth::user()->student;
        $section   = Teacher_section::with('subject', 'section')
            ->findOrFail($teacherSectionId);
        $subjectId = $section->subject_id;
        $sectionId = $section->section_id;

        // --- Exams
        $exams = Exam::where('subject_id', $subjectId)
            ->whereHas('sections', fn($q) => $q->where('section_id', $sectionId))
            ->with([
                'degrees' => fn($q) => $q->where('student_id', $student->id),
                'sections' => fn($q) => $q->where('section_id', $sectionId),
            ])
            ->get();

        $examRows = $exams->map(function ($exam) {
            $degree = $exam->degrees->first();
            $sectionExam = $exam->sectionExams->first();
            $canShow = $sectionExam?->show_answers;

            return [
                'type'     => 'exam',
                'title'    => $exam->name,
                'score'    => ($degree && $canShow)
                    ? $degree->score . '/' . $exam->maximum_grade
                    : null,
                'feedback' => ($degree && $canShow)
                    ? $degree->feedback
                    : null,
            ];
        });

        // --- Homeworks
        $homeworks = Homework::where('subject_id', $subjectId)
            ->where('section_id', $sectionId)
            ->with(['submissions' => fn($q) => $q->where('student_id', $student->id)])
            ->get();

        $homeworkRows = $homeworks->map(function ($hw) {
            $submission = $hw->submissions->first();

            $canShow = $hw->show_grade;

            return [
                'type'     => 'homework',
                'title'    => $hw->title,
                'score'    => ($submission && $submission->degree !== null && $canShow)
                    ? $submission->degree . '/' . $hw->total_degree
                    : null,
                'feedback' => ($submission && $canShow)
                    ? $submission->feedback
                    : null,
            ];
        });

        $rows = collect()->merge($examRows)->merge($homeworkRows)->values();

        return view('pages.Student.courses.scores', [
            'teacher_section' => $section,
            'rows'            => $rows,
        ]);
    }
}
