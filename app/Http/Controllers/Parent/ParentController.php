<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempts;
use App\Models\Homework;
use App\Models\Homework_submission;
use App\Models\Library;
use App\Models\Online_class;
use App\Models\Recorded_class;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher_section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    public function dashboard()
    {
        $sons = Student::where('parent_id', Auth::user()->parents->id)->get();
        $sonsCount = $sons->count();

        return view('pages.Parent.dashboard', compact('sons', 'sonsCount'));
    }

    public function profile()
    {
        return view('pages.Parent.profile');
    }

    public function studentSubjects($studentId)
    {
        $student = Student::findOrFail($studentId);
        $subjects = Teacher_section::with(['teacher.user', 'subject'])
            ->where('section_id', $student->section_id)
            ->get();

        return view('pages.Parent.studentSubjects', compact('student', 'subjects', 'studentId'));
    }

    public function subjectsMaterials($teacherSectionId, $studentId)
    {
        // Get Teacher_section with relationships
        $teacherSection = Teacher_section::with(['section.My_classs.Grades', 'subject'])
            ->findOrFail($teacherSectionId);
        $student = Student::findOrFail($studentId);
        // dd($student->id);

        // Extract IDs for filtering
        $gradeId     = $teacherSection->section->My_classs->Grades->id;
        $classroomId = $teacherSection->section->My_classs->id;
        $sectionId   = $teacherSection->section->id;
        $subjectId   = $teacherSection->subject_id;
        $teacherId   = $teacherSection->teacher_id;

        // Reusable filter
        $filter = fn($model) => $model::where([
            ['grade_id', $gradeId],
            ['classroom_id', $classroomId],
            ['teacher_id', $teacherId],
            ['subject_id', $subjectId],
        ])
            ->orderBy('created_at', 'asc');

        // Fetch data
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

        // Merge all into one collection
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

        return view('pages.Parent.subjectMaterials', compact('student'), [
            'teacher_section' => $teacherSection,
            'materials'       => $materials,
            'student'       => $student,
        ]);
    }

    public function bookDetails($bookId)
    {

        $book = Library::findOrFail($bookId);

        return view('pages.Parent.bookDetails', compact('book'));
    }

    public function homeworkDetails($homeworkId, $studentId)
    {
        $homework = Homework::findOrFail($homeworkId);


        $submission = Homework_submission::where('homework_id', $homework->id)
            ->where('student_id', $studentId)
            ->first();

        return view('pages.Parent.homeworkDetails', compact('homework', 'submission'));
    }

    public function recordedClassDetails($classId)
    {
        $class = Recorded_class::findOrFail($classId);

        return view('pages.Parent.recordedClassDetails', compact('class'));
    }

    public function examDetails($examId, $studentId)
    {
        $exam = Exam::findOrFail($examId);

        $student_id = Student::findOrFail($studentId);

        // Get all attempts of this student for this exam
        $examAttempts = ExamAttempts::where('exam_id', $exam->id)
            ->where('student_id', $student_id)
            ->orderBy('attempt_number')
            ->get();

        return view('pages.Parent.examDetails', compact('exam', 'examAttempts', 'student_id'));
    }

    public function zoomClassDetails($classId)
    {
        $class = Online_class::findOrFail($classId);

        return view('pages.Parent.ZoomClassDetails', compact('class'));
    }
}
