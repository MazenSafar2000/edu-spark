<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Teacher_section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard()
    {
        // $student = auth('student')->user();
        // $section = $student->section;

        // $subjects = $section?->subjects()->with('teacher')->get();

        // $student = Auth::user()->student;
        // $section = $student->section;

        // $teacher_section = Teacher_section::where('section_id', $section->id)->get();

        // $subjects = $teacher_section->subject()->get();

        $student = Auth::user()->student;

        // الحصول على كل teacher_sections المرتبطة بقسم الطالب
        $subjects = Teacher_section::with(['teacher.user', 'subject'])
            ->where('section_id', $student->section_id)
            ->get();
            // dd($subjects);

        return view('pages.Student.dashboard', compact('subjects'));
    }
}
