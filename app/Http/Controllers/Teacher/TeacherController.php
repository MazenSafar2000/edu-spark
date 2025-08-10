<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Exam;
use App\Models\Homework;
use App\Models\Library;
use App\Models\Online_class;
use App\Models\Recorded_class;
use App\Models\Section;
use App\Models\SectionExam;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Teacher_section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{

    public function dashboard()
    {
        $userId = auth()->id();
        $teacher = Teacher::where('user_id', $userId)->firstOrFail();

        $sectionCount = $teacher->sections()->count();
        $studentCount = Student::whereIn('section_id', $teacher->sections->pluck('id'))->count();

        // استدعاء Teacher_section مع العلاقات المطلوبة
        $sections = $teacher->teacherSections()
            ->with(['section.students', 'section.My_classs.Grades', 'subject'])
            ->get();

        return view('pages.Teacher.dashboard', compact('sectionCount', 'studentCount', 'sections'));
    }


    // public function showSectionMaterials($sec_id)
    // {
    //     $teacher_id = Auth::user()->teacher->id;

    //     $teacher_section = Teacher_section::findOrFail($sec_id);
    //     // $section_exam = SectionExam::where('section_id', $sec_id);
    //     // $section = Section::findOrFail($teacher_section->id);
    //     // $section_id = $section->id;
    //     // $subject_id = $teacher_section->subject_id;
    //     // $exam_id = $section_exam->exam_id;


    //     // $books = Library::where([
    //     //     ['teacher_id', $teacher_id],
    //     //     ['section_id', $section_id],
    //     //     ['subject_id', $subject_id],
    //     // ])->orderBy('created_at', 'asc')->get();

    //     // $homeworks = Homework::where([
    //     //     ['teacher_id', $teacher_id],
    //     //     ['section_id', $section_id],
    //     //     ['subject_id', $subject_id],
    //     // ])->orderBy('created_at', 'asc')->get();

    //     // $exams = SectionExam::where([
    //     //     ['section_id', $section_id],
    //     //     ['exam_id', $exam_id],
    //     // ])->orderBy('created_at', 'asc')->get();

    //     // $recorded = Recorded_class::where([
    //     //     ['teacher_id', $teacher_id],
    //     //     ['section_id', $section_id],
    //     //     ['subject_id', $subject_id],
    //     // ])->orderBy('created_at', 'asc')->get();

    //     // $online = Online_class::where([
    //     //     ['teacher_id', $teacher_id],
    //     //     ['section_id', $section_id],
    //     //     ['subject_id', $subject_id],
    //     // ])->orderBy('created_at', 'asc')->get();


    //     // $materials = collect()
    //     //     ->merge($books->map(fn($item) => [
    //     //         'type' => 'book',
    //     //         'title' => $item->title,
    //     //         'created_at' => $item->created_at,
    //     //         'data' => $item,
    //     //     ]))
    //     //     ->merge($homeworks->map(fn($item) => [
    //     //         'type' => 'homework',
    //     //         'title' => $item->title,
    //     //         'created_at' => $item->created_at,
    //     //         'data' => $item,
    //     //     ]))
    //     //     ->merge($exams->map(fn($item) => [
    //     //         'type' => 'exam',
    //     //         'title' => $item->name,
    //     //         'created_at' => $item->created_at,
    //     //         'data' => $item,
    //     //     ]))
    //     //     ->merge($recorded->map(fn($item) => [
    //     //         'type' => 'recorded',
    //     //         'title' => $item->title,
    //     //         'created_at' => $item->created_at,
    //     //         'data' => $item,
    //     //     ]))
    //     //     ->merge($online->map(fn($item) => [
    //     //         'type' => 'online',
    //     //         'title' => $item->topic,
    //     //         'created_at' => $item->created_at,
    //     //         'data' => $item,
    //     //     ]))
    //     //     ->sortBy('created_at')
    //     //     ->values();

    //     return view(
    //         'pages.Teacher.sections.section-materials',
    //         compact(
    //             //     'section',
    //             'teacher_section',
    //             //     'materials'
    //         )
    //     );
    // }

    public function showSectionMaterials($teacherSectionId)
    {
        // الحصول على Teacher_section مع علاقاته
        $teacherSection = Teacher_section::with(['section.students', 'subject'])
            ->where('teacher_id', auth()->user()->teacher->id)
            ->findOrFail($teacherSectionId);

        $section_id = $teacherSection->section_id;
        $subject_id = $teacherSection->subject_id;
        $teacher_id = $teacherSection->teacher_id;

        // استدعاء كل المواد
        $books = Library::where(compact('teacher_id', 'section_id', 'subject_id'))->get();
        $homeworks = Homework::where(compact('teacher_id', 'section_id', 'subject_id'))->get();
        $exams = SectionExam::where('section_id', $section_id)->get();
        $recorded = Recorded_class::where(compact('teacher_id', 'section_id', 'subject_id'))->get();
        $online = Online_class::where(compact('teacher_id', 'section_id', 'subject_id'))->get();

        // دمج كل المواد في Collection واحد
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
            ->merge($exams->map(fn($item) => [
                'type' => 'exam',
                'title' => $item->exam->name ?? 'Exam',
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
            ->sortByDesc('created_at')
            ->values();

        return view('pages.Teacher.sections.section-materials', [
            'teacher_section' => $teacherSection,
            'materials' => $materials
        ]);
    }
}
