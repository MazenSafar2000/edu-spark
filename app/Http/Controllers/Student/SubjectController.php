<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
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

    // public function showSubjectContent($subject_id)
    // {
    //     $teacher_section = Teacher_section::findOrFail($subject_id);

    //     // Extract filter info from subject
    //     $grade_id = $teacher_section->section->My_classs->Grades->id;
    //     $classroom_id = $teacher_section->section->My_classs->id;
    //     $section_id = $teacher_section->section->id;
    //     $teacher_id = $teacher_section->teacher_id;

    //     // dd($grade_id, $classroom_id, $teacher_id);

    //     // Fetch all related materials
    //     $books = Library::where([
    //         ['Grade_id', $grade_id],
    //         ['Classroom_id', $classroom_id],
    //         ['teacher_id', $teacher_id],
    //         ['subject_id', $subject_id],
    //     ])->orderBy('created_at', 'asc')->get();

    //     $homeworks = Homework::where([
    //         ['grade_id', $grade_id],
    //         ['classroom_id', $classroom_id],
    //         ['teacher_id', $teacher_id],
    //         ['subject_id', $subject_id],
    //     ])->orderBy('created_at', 'asc')->get();

    //     $quizzes = Exam::sections()->where([
    //         ['section_id', $section_id],
    //         ['subject_id', $subject_id],
    //     ])->orderBy('created_at', 'asc')->get();

    //     $recorded = Recorded_class::where([
    //         ['grade_id', $grade_id],
    //         ['classroom_id', $classroom_id],
    //         ['teacher_id', $teacher_id],
    //         ['subject_id', $subject_id],
    //     ])->orderBy('created_at', 'asc')->get();

    //     $online = Online_class::where([
    //         ['grade_id', $grade_id],
    //         ['classroom_id', $classroom_id],
    //         ['teacher_id', $teacher_id],
    //         ['subject_id', $subject_id],
    //     ])->orderBy('created_at', 'asc')->get();



    //     // Merge all in a single collection
    //     $materials = collect()
    //         ->merge($books->map(fn($item) => [
    //             'type' => 'book',
    //             'title' => $item->title,
    //             'created_at' => $item->created_at,
    //             'data' => $item,
    //         ]))
    //         ->merge($homeworks->map(fn($item) => [
    //             'type' => 'homework',
    //             'title' => $item->title,
    //             'created_at' => $item->created_at,
    //             'data' => $item,
    //         ]))
    //         ->merge($quizzes->map(fn($item) => [
    //             'type' => 'exam',
    //             'title' => $item->name,
    //             'created_at' => $item->created_at,
    //             'data' => $item,
    //         ]))
    //         ->merge($recorded->map(fn($item) => [
    //             'type' => 'recorded',
    //             'title' => $item->title,
    //             'created_at' => $item->created_at,
    //             'data' => $item,
    //         ]))
    //         ->merge($online->map(fn($item) => [
    //             'type' => 'online',
    //             'title' => $item->topic,
    //             'created_at' => $item->created_at,
    //             'data' => $item,
    //         ]))
    //         ->sortBy('created_at')
    //         ->values();

    //     return view('pages.Student.courses.index', compact('teacher_section', 'materials'));
    // }

    public function showSubjectContent($teacherSectionId)
    {
        // Get Teacher_section with relationships
        $teacherSection = Teacher_section::with(['section.My_classs.Grades', 'subject'])
            ->findOrFail($teacherSectionId);

        // Extract IDs for filtering
        $gradeId      = $teacherSection->section->My_classs->Grades->id;
        $classroomId  = $teacherSection->section->My_classs->id;
        $sectionId    = $teacherSection->section->id;
        $subjectId    = $teacherSection->subject_id; // <-- Correct subject_id
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

        // For exams (pivot table case)
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
        $studentDegree = $exam->degree()
            ->where('student_id', $student_id)
            ->first();

        return view('pages.Student.exams.viewExam', compact('exam', 'student_id', 'studentDegree'));
    }
}
