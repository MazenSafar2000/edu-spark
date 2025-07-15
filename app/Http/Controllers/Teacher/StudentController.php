<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;

        // Get all section_ids the teacher teaches in
        $section_ids = $teacher->sections()->pluck('sections.id')->toArray();

        // Filter students by those sections
        $data['students'] = Student::whereIn('section_id', $section_ids)->get();

        $data['grades'] = Grade::all();

        return view('Pages.Teacher.students.index', $data);
    }

    public function show($id)
    {
        $Student = Student::findorfail($id);
        return view('pages.Teacher.students.show', compact('Student'));
    }
}
