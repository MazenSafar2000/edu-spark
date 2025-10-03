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
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{

    public function dashboard()
    {
        $userId = auth()->id();
        $teacher = Teacher::where('user_id', $userId)->firstOrFail();

        $sectionCount = $teacher->sections()->count();
        $studentCount = Student::whereIn('section_id', $teacher->sections->pluck('id'))->count();

        $sections = $teacher->teacherSections()
            ->with(['section.students', 'section.My_classs.Grades', 'subject'])
            ->get();

        return view('pages.Teacher.dashboard', compact('sectionCount', 'studentCount', 'sections'));
    }

    public function profile()
    {
        $teacher = Auth::user()->teacher;
        return view('pages.Teacher.profile', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $teacher = Auth::user()->teacher;
        $user = $teacher->user;

        $validated = $request->validate([
            'Name_ar'     => ['required', 'string', 'max:255'],
            'Name_en'     => ['required', 'string', 'max:255'],
            'National_ID' => [
                'required',
                'string',
                'regex:/^\d{9}$/',
                Rule::unique('users', 'National_ID')->ignore($user->id),
            ],
            'email'       => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password'    => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        DB::transaction(function () use ($validated, $user, $teacher) {
            $emailChanged = $validated['email'] !== $user->email;

            $user->name  = ['en' => $validated['Name_en'], 'ar' => $validated['Name_ar']];
            $user->email = $validated['email'];
            $user->National_ID = $validated['National_ID'];

            if ($emailChanged) {
                $user->email_verified_at = null;
            }

            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            if ($user->role !== 'teacher') {
                $user->role = 'teacher';
            }

            $user->save();
            $teacher->save();
        });

        Flasher::addSuccess(trans('main_trans.success'));
        return redirect()->route('teacher.profile')->with('status', trans('main_trans.success'));
    }

    public function sections()
    {
        $userId = auth()->id();
        $teacher = Teacher::where('user_id', $userId)->firstOrFail();

        $sectionCount = $teacher->sections()->count();
        $studentCount = Student::whereIn('section_id', $teacher->sections->pluck('id'))->count();

        // استدعاء Teacher_section مع العلاقات المطلوبة
        $sections = $teacher->teacherSections()
            ->with(['section.students', 'section.My_classs.Grades', 'subject'])
            ->paginate(10);

        return view('pages.Teacher.sections.index', compact('sectionCount', 'studentCount', 'sections'));
    }

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
                'title' => $item->exams->name,
                'created_at' => $item->created_at,
                'data' => $item,
                'exam_id' => $item->exam_id,
                'section_exam_id' => $item->id,
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
