<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher_section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    // Get Classrooms
    public function getClassrooms($id)
    {
        return Classroom::where("Grade_id", $id)->pluck("Name_Class", "id");
        return response()->json($classrooms);
    }

    //Get Sections
    public function Get_Sections($id)
    {
        return Section::where("Class_id", $id)->pluck("Name_Section", "id");
        return response()->json($sections);
    }


    // Teacher Filter
    public function getClassroomsByGrade($grade_id)
    {
        $locale = App::getLocale(); // Detect current app locale (e.g., 'ar' or 'en')
        $teacher = Auth::user()->teacher;

        $classroomIds = Section::whereHas('teacherSections', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->whereHas('My_classs', function ($q) use ($grade_id) {
            $q->where('Grade_id', $grade_id);
        })->pluck('Class_id')->unique();

        $classrooms = Classroom::whereIn('id', $classroomIds)->get();

        // Return localized names
        $classrooms = $classrooms->map(function ($classroom) use ($locale) {
            return [
                'id' => $classroom->id,
                'name' => is_array($classroom->Name_Class)
                    ? $classroom->Name_Class[$locale] ?? $classroom->Name_Class['en']
                    : $classroom->Name_Class // fallback if not using JSON
            ];
        });

        return response()->json($classrooms);
    }

    public function getSectionsByClassroom($classroom_id)
    {
        $locale = App::getLocale();
        $teacher = Auth::user()->teacher;

        $sections = Section::where('Class_id', $classroom_id)
            ->whereHas('teacherSections', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })->get();

        $sections = $sections->map(function ($section) use ($locale) {
            return [
                'id' => $section->id,
                'name' => is_array($section->Name_Section)
                    ? $section->Name_Section[$locale] ?? $section->Name_Section['en']
                    : $section->Name_Section
            ];
        });

        return response()->json($sections);
    }


    public function getSubjectsBySection($section_id)
    {
        $locale = App::getLocale();
        $teacher = Auth::user()->teacher;

        $subjectIds = Teacher_section::where('teacher_id', $teacher->id)
            ->where('section_id', $section_id)
            ->pluck('subject_id');

        $subjects = Subject::whereIn('id', $subjectIds)->get();

        $subjects = $subjects->map(function ($subject) use ($locale) {
            return [
                'id' => $subject->id,
                'name' => is_array($subject->name)
                    ? $subject->name[$locale] ?? $subject->name['en']
                    : $subject->name
            ];
        });

        return response()->json($subjects);
    }
    // End teacher filter
}
