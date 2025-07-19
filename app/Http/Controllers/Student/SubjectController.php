<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Homework;
use App\Models\Homework_submission;
use App\Models\Library;
use App\Models\Online_class;
use App\Models\Recorded_class;
use App\Models\Subject;
use App\Models\Teacher_section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{

    public function showSubjectContent($subject_id)
    {
        $teacher_section = Teacher_section::findOrFail($subject_id);

        // Extract filter info from subject
        $grade_id = $teacher_section->section->My_classs->Grades->id;
        $classroom_id = $teacher_section->section->My_classs->id;
        $teacher_id = $teacher_section->teacher_id;

        // dd($grade_id, $classroom_id, $teacher_id);

        // Fetch all related materials
        $books = Library::where([
            ['Grade_id', $grade_id],
            ['Classroom_id', $classroom_id],
            ['teacher_id', $teacher_id],
            ['subject_id', $subject_id],
        ])->orderBy('created_at', 'asc')->get();

        $homeworks = Homework::where([
            ['grade_id', $grade_id],
            ['classroom_id', $classroom_id],
            ['teacher_id', $teacher_id],
            ['subject_id', $subject_id],
        ])->orderBy('created_at', 'asc')->get();

        $quizzes = Exam::where([
            ['grade_id', $grade_id],
            ['classroom_id', $classroom_id],
            ['teacher_id', $teacher_id],
            ['subject_id', $subject_id],
        ])->orderBy('created_at', 'asc')->get();

        $recorded = Recorded_class::where([
            ['grade_id', $grade_id],
            ['classroom_id', $classroom_id],
            ['teacher_id', $teacher_id],
            ['subject_id', $subject_id],
        ])->orderBy('created_at', 'asc')->get();

        $online = Online_class::where([
            ['grade_id', $grade_id],
            ['classroom_id', $classroom_id],
            ['teacher_id', $teacher_id],
            ['subject_id', $subject_id],
        ])->orderBy('created_at', 'asc')->get();



        // Merge all in a single collection
        $materials = collect()
            ->merge($books->map(fn($item) => [
                'type' => 'book',
                'title' => $item->title,
                'created_at' => $item->created_at,
                'data' => $item,
            ]))
            ->merge($homeworks->map(fn($item) => [
                'type' => 'homework',
                'title' => $item->title,
                'created_at' => $item->created_at,
                'data' => $item,
            ]))
            ->merge($quizzes->map(fn($item) => [
                'type' => 'exam',
                'title' => $item->name,
                'created_at' => $item->created_at,
                'data' => $item,
            ]))
            ->merge($recorded->map(fn($item) => [
                'type' => 'recorded',
                'title' => $item->title,
                'created_at' => $item->created_at,
                'data' => $item,
            ]))
            ->merge($online->map(fn($item) => [
                'type' => 'online',
                'title' => $item->topic,
                'created_at' => $item->created_at,
                'data' => $item,
            ]))
            ->sortBy('created_at')
            ->values();

        return view('pages.Student.courses.index', compact('teacher_section', 'materials'));
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
