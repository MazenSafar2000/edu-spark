<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ChMessage;
use App\Models\Teacher_section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = Auth::user()->student;

        $subjects = Teacher_section::with(['teacher.user', 'subject'])
            ->where('section_id', $student->section_id)
            ->get();

        return view('pages.Student.dashboard', compact('subjects'));
    }
}
