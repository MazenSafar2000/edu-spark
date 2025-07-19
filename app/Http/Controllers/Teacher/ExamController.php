<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\Question;
use App\Models\Student;
use App\Models\Teacher_section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = Exam::get()->where('teacher_id', Auth::user()->teacher->id);
        return view('pages.teacher.exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['grades'] = Grade::all();
        return view("pages.Teacher.exams.create", $data);
    }

    // this functoin for section study content page
    public function createNew($id)
    {
        $teacher_section = Teacher_section::findOrFail($id);

        return view("pages.Teacher.sections.createExam", compact('teacher_section'));
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
            'Name_en' => 'required|string|max:255',
            'Name_ar' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'duration' => 'required|integer|min:1',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'show_answers_to_student' => 'nullable|boolean'
        ]);

        try {
            $exam = new Exam();
            $exam->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $exam->subject_id = $request->subject_id;
            $exam->grade_id = $request->grade_id;
            $exam->classroom_id = $request->classroom_id;
            $exam->section_id = $request->section_id;
            $exam->teacher_id = Auth::user()->teacher->id;
            $exam->duration = $request->duration;
            $exam->start_at = $request->start_at;
            $exam->end_at = $request->end_at;
            $exam->show_answers_to_student = $request->boolean('show_answers_to_student');
            $exam->created_by_teacher_id = Auth::user()->teacher->id;
            $exam->save();

            // $students = Student::where('grade_id', $request->Grade_id)
            //     ->where('classroom_id', $request->Classroom_id)
            //     ->where('section_id', $request->section_id)
            //     ->get();


            // $examTitle = $exam->getTranslation('name', app()->getLocale());

            // foreach ($students as $student) {
            //     $student->notify(new NewExamAdded($exam->id, $examTitle, auth()->user()->Name));
            //     $student->myparent->notify(new ParentNewExamAdded($exam, $student));
            // }

            toastr()->success(trans('messages.success'));
            return redirect()->route('exams.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        $questions = Question::where('exam_id', $exam->id)->get();
        $exam = Exam::findOrFail($exam->id);

        return view('pages.Teacher.exams.questions.index', compact('questions', 'exam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        $data['exam'] = $exam;
        $data['grades'] = Grade::all();

        return view("pages.Teacher.exams.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {

        $request->validate([
            'Name_en' => 'required|string|max:255',
            'Name_ar' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'duration' => 'required|integer|min:1',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
        ]);

        try {
            $quizz = $exam::findOrFail($exam->id);
            $quizz->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $quizz->subject_id = $request->subject_id;
            $quizz->grade_id = $request->grade_id;
            $quizz->classroom_id = $request->classroom_id;
            $quizz->section_id = $request->section_id;
            $quizz->duration = $request->duration;
            $quizz->teacher_id = Auth::user()->teacher->id;
            $quizz->start_at = $request->start_at;
            $quizz->end_at = $request->end_at;
            $quizz->save();

            toastr()->success(trans('messages.Update'));
            return redirect()->route('exams.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        try {
            $exam->delete();

            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
