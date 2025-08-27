<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\Exam;
use App\Models\ExamAttempts;
use App\Models\ExamQuestions;
use App\Models\Grade;
use App\Models\Question;
use App\Models\QuestionsCategotry;
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
        $data['subjects'] = Teacher_section::where('teacher_id', Auth::user()->teacher->id)->get();
        return view("pages.Teacher.exams.create", $data);
    }

    // this functoin for section study content page
    public function createNew($id)
    {
        $teacher_section = Teacher_section::findOrFail($id);
        $exams = Exam::where("teacher_id", Auth::user()->teacher->id)->get();

        return view("pages.Teacher.sections.createExam", compact('teacher_section', 'exams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->boolean('show_answers'));

        $request->validate([
            'Name_en' => 'required|string|max:255',
            'Name_ar' => 'required|string|max:255',
            'description' => 'required|string',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'duration' => 'required|integer|min:1',
            'attemptes' => 'required',
            'question_per_page' => 'required',
            'subject_id' => 'required|exists:subjects,id',
            'show_answers' => 'nullable'
        ]);


        try {
            $exam = new Exam();
            $exam->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $exam->description = $request->description;
            $exam->start_at = $request->start_at;
            $exam->end_at = $request->end_at;
            $exam->duration = $request->duration;
            $exam->attemptes = $request->attemptes;
            $exam->question_per_page = $request->question_per_page;
            if ($request->maximum_grade) {
                $exam->maximum_grade = $request->maximum_grade;
            }
            $exam->subject_id = $request->subject_id;
            $exam->show_answers = $request->boolean('show_answers');
            $exam->teacher_id = Auth::user()->teacher->id;
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
    // public function show(Exam $exam)
    // {
    //     $questions = Question::where('exam_id', $exam->id)->get();
    //     $exam = Exam::findOrFail($exam->id);

    //     return view('pages.Teacher.QuestionsBank.QuestionCategory.questions.index', compact('questions', 'exam'));
    // }

    public function show(Exam $exam)
    {
        $exam = Exam::findOrFail($exam->id);

        // $questions = Question::where('exam_id', $exam->id)->get();

        return view('pages.Teacher.exams.view', compact('exam'));
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
        $data['subjects'] = Teacher_section::where('teacher_id', Auth::user()->teacher->id)->get();

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
            'description' => 'required|string',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'duration' => 'required|integer|min:1',
            'attemptes' => 'required',
            'question_per_page' => 'required',
            'subject_id' => 'required|exists:subjects,id',
            'show_answers' => 'nullable'
        ]);

        try {
            $quizz = $exam::findOrFail($exam->id);
            $quizz->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $quizz->description = $request->post('description');
            $quizz->start_at = $request->post('start_at');
            $quizz->end_at = $request->post('end_at');
            $quizz->duration = $request->post('duration');
            $quizz->attemptes = $request->post('attemptes');
            $quizz->question_per_page = $request->post('question_per_page');
            if ($request->maximum_grade) {
                $quizz->maximum_grade = $request->post('maximum_grade');
            }
            $quizz->subject_id = $request->post('subject_id');
            $quizz->show_answers = $request->boolean('show_answers');
            $quizz->teacher_id = Auth::user()->teacher->id;
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

    public function addQuestions($exam_id)
    {
        $exam = Exam::findOrFail($exam_id);

        $questions = ExamQuestions::where('exam_id', $exam_id)->paginate(20);
        $teacherId = Auth::user()->teacher->id;
        $categories = QuestionsCategotry::with('questionsBank')
            ->whereHas('questionsBank', function ($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            })->get();

        return view('pages.Teacher.exams.questions.index', compact('questions', 'exam', 'categories'));
    }

    // public function testedStudents($exam_id)
    // {

    //     // 1. Get exam with linked sections
    //     $exam = Exam::with('subject', 'sectionExams.section')->findOrFail($exam_id);
    //     // dd($exam);

    //     $totalStudents = $exam->sectionExams->students;
    //     dd($totalStudents);

    //     // 2. Collect all students in these sections
    //     $sectionIds = $exam->sectionExams->pluck('section_id');
    //     $students = Student::whereIn('section_id', $sectionIds)->get();

    //     // 3. Get all degrees for this exam
    //     $degrees = Degree::where('exam_id', $exam_id)->get()->keyBy('student_id');

    //     $labels = $degrees->pluck('student.name');
    //     $scores = $degrees->pluck('score');

    //     $passed = $degrees->where('score', '>=', $exam->pass_mark ?? 10)->count();
    //     $failed = $degrees->count() - $passed;

    //     // 4. Attach score to each student
    //     foreach ($students as $student) {
    //         $student->score = $degrees[$student->id]->score ?? null;
    //         $student->feedback = $degrees[$student->id]->feedback ?? null;
    //     }

    //     return view('pages.Teacher.exams.tested_students', compact('exam', 'students', 'degrees', 'labels', 'scores', 'passed', 'failed'));
    // }

    public function testedStudents($exam_id)
    {
        $exam = Exam::with('sectionExams.section.students')->findOrFail($exam_id);

        // Get all students in sections of this exam
        $students = $exam->sectionExams
            ->flatMap(fn($se) => $se->section->students)
            ->unique('id')
            ->values();

        // Get last attempt per student
        $attempts = ExamAttempts::where('exam_id', $exam_id)
            ->with('student')
            ->get()
            ->groupBy('student_id')
            ->map(fn($group) => $group->sortByDesc('attempt_number')->first());

        // Compute stats
        $totalStudents = $students->count();
        $studentsAttempted = $attempts->count();
        $studentsNotAttempted = $totalStudents - $studentsAttempted;

        $passingGrade = $exam->maximum_grade * 0.5;
        $studentsSuccess = $attempts->filter(fn($a) => $a->grade_obtained >= $passingGrade)->count();
        $studentsFail = $studentsAttempted - $studentsSuccess;

        $distribution = [
            '0-25' => 0,
            '26-50' => 0,
            '51-75' => 0,
            '76-100' => 0,
        ];
        foreach ($attempts as $a) {
            if ($a->grade_obtained === null) continue;
            if ($a->grade_obtained <= 25) $distribution['0-25']++;
            elseif ($a->grade_obtained <= 50) $distribution['26-50']++;
            elseif ($a->grade_obtained <= 75) $distribution['51-75']++;
            else $distribution['76-100']++;
        }

        return view('pages.Teacher.exams.tested_students', [
            'exam' => $exam,
            'students' => $students,
            'attempts' => $attempts,
            'stats' => [
                'total' => $totalStudents,
                'attempted' => $studentsAttempted,
                'not_attempted' => $studentsNotAttempted,
                'success' => $studentsSuccess,
                'fail' => $studentsFail,
            ],
            'distribution' => $distribution,
        ]);
    }
}
