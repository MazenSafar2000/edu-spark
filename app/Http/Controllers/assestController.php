<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Section;
use Illuminate\Http\Request;

class assestController extends Controller
{
    public function getClasses($grade_id)
    {
        $classes = Classroom::where('Grade_id', $grade_id)->pluck('Name_Class', 'id');
        return response()->json($classes);
    }

    public function getSections($class_id)
    {
        $sections = Section::where('Class_id', $class_id)->pluck('Name_Section', 'id');
        return response()->json($sections);
    }
}
