<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Models\Homework;
use App\Models\Library;
use App\Models\Online_class;
use App\Models\QuestionsBank;
use App\Models\Recorded_class;
use App\Models\SectionExam;
use App\Models\Specialization;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Teacher_section;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Flasher\Laravel\Facade\Flasher;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Teachers = Teacher::paginate(20);
        $Specializations = Specialization::paginate(20);
        return view('pages.Manager.Teachers.index', compact('Teachers', 'Specializations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specializations = Specialization::all();
        $genders = Gender::all();
        return view('pages.Manager.Teachers.create', compact('specializations', 'genders'), ['Teacher' => new Teacher()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Name_ar' => 'required|string|max:255',
            'Name_en' => 'required|string|max:255',
            'National_ID' => 'required|string|min:9|max:9|regex:/[0-9]{9}/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'Gender_id' => 'required|exists:genders,id',
            'Specialization_id' => 'required|exists:specializations,id',
            'Joining_Date' => 'required|date',
            'Address' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            // 1. Create user
            $user = User::create([
                'name' => [
                    'ar' => $request->Name_ar,
                    'en' => $request->Name_en
                ],
                'email' => $request->email,
                'National_ID' => $request->National_ID,
                'password' => Hash::make($request->password),
                'role' => 'teacher', // if you're using role column
            ]);

            // 2. Create teacher profile
            $teacher = Teacher::create([
                'user_id' => $user->id,
                // 'National_ID' => $request->National_ID,
                'Gender_id' => $request->Gender_id,
                'Specialization_id' => $request->Specialization_id,
                'Joining_Date' => $request->Joining_Date,
                'Address' => $request->Address,
            ]);

            // 3.create QBank for this teacher
            QuestionsBank::create([
                'teacher_id' => $teacher->id,
            ]);

            DB::commit();

            Flasher::addSuccess(trans('messages.success'));
            return redirect()->route('Teachers.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teacher = Teacher::findOrFail($id);

        $sectionCount = $teacher->sections()->count();
        $studentCount = Student::whereIn('section_id', $teacher->sections->pluck('id'))->count();

        // استدعاء Teacher_section مع العلاقات المطلوبة
        $sections = $teacher->teacherSections()
            ->with(['section.students', 'section.My_classs.Grades', 'subject'])
            ->get();

        return view('pages.Manager.Teachers.view', compact('teacher', 'sectionCount', 'studentCount', 'sections'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Teacher = Teacher::findOrfail($id);
        $genders = Gender::all();
        $specializations = Specialization::all();

        return view('pages.Manager.Teachers.edit', compact('Teacher', 'genders', 'specializations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $teacher = Teacher::findOrFail($id);

            // Update user data
            $user = $teacher->user;
            $user->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $user->email = $request->email;
            $user->National_ID = $request->National_ID;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // Update teacher data
            // $teacher->user->National_ID = $request->National_ID;
            $teacher->Gender_id = $request->Gender_id;
            $teacher->Specialization_id = $request->Specialization_id;
            $teacher->Joining_Date = $request->Joining_Date;
            $teacher->Address = $request->Address;
            $teacher->save();

            DB::commit();

            Flasher::addSuccess(__('messages.Update'));
            return redirect()->route('Teachers.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $user = $teacher->user;
        $teacher->delete();

        if ($user) {
            $user->delete(); // Deletes the associated user record
        }

        Flasher::addError(trans('messages.Delete'));
        return redirect()->route('Teachers.index');
    }

    public function showSectionMaterials($teacherId, $teacherSectionId)
    {
        $teacherSection = Teacher_section::with(['section.students', 'subject'])
            ->where('teacher_id', $teacherId)
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

        return view('pages.Manager.Teachers.TeacherSection.section-materials', [
            'teacher_section' => $teacherSection,
            'materials' => $materials
        ]);
    }
}
