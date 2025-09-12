<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Exports\ExamResultsExport;
use App\Models\Degree;
use App\Models\Exam;
use App\Models\ExamAttempts;
use App\Models\ExamQuestions;
use App\Models\Grade;
use App\Models\Question;
use App\Models\QuestionsCategotry;
use App\Models\SectionExam;
use App\Models\Student;
use App\Models\Teacher_section;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['grades'] = Grade::all();
        $data['subjects'] = Teacher_section::all();
        return view("pages.Manager.StudyContent.exams.create", $data);
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
            'Name_ar' => 'required|string|max:255',
            'Name_en' => 'required|string|max:255',
            'description' => 'required|string',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'duration' => 'required|integer|min:1',
            'attempts' => 'required',
            'question_per_page' => 'required',
            'maximum_grade' => 'required',
            'subject_id' => 'required|exists:subjects,id',

            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'teacher_id' => 'required|exists:teachers,id',

        ]);


        try {
            $exam = new Exam();
            $exam->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $exam->description = $request->description;
            $exam->start_at = $request->start_at;
            $exam->end_at = $request->end_at;
            $exam->duration = $request->duration;
            $exam->attempts = $request->attempts;
            $exam->question_per_page = $request->question_per_page;
            if ($request->maximum_grade) {
                $exam->maximum_grade = $request->maximum_grade;
            }
            $exam->subject_id = $request->subject_id;
            $exam->teacher_id = $request->teacher_id;
            $exam->save();

            $sectionExam = new SectionExam();
            $sectionExam->section_id = $request->section_id;
            $sectionExam->exam_id = $exam->id;
            $sectionExam->subject_id = $exam->subject_id;
            $sectionExam->save();

            Flasher::addSuccess(trans('messages.success'));
            return redirect()->route('StudyContent.index');
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
    public function show($id)
    {
        // 
    }

    public function showResults($exam_id)
    {
        $sectionExam = SectionExam::findOrFail($exam_id);
        $exam = $sectionExam->exams;

        $totalMarks = $exam->questions->sum(fn($q) => $q->pivot->score);

        $teacherId = $exam->teacher_id;
        $categories = QuestionsCategotry::with('questionsBank')
            ->whereHas('questionsBank', function ($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            })->get();

        // All students in sections of this exam
        $students = $exam->sectionExams
            ->flatMap(fn($se) => $se->section->students)
            ->unique('id')
            ->values();

        // Latest attempts per student
        $attempts = ExamAttempts::where('exam_id', $exam->id)
            ->with('student')
            ->get()
            ->groupBy('student_id')
            ->map(fn($group) => $group->sortByDesc('attempt_number')->first());

        // Manual degrees (teacher updated grades)
        $degrees = Degree::where('exam_id', $exam->id)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        $totalStudents = $students->count();

        // Attempted = students with exam_attempts
        $studentsAttempted = $attempts->count();

        // Not Attempted = all students - attempted
        $studentsNotAttempted = $totalStudents - $studentsAttempted;

        // Passing grade rule
        $passingGrade = $exam->maximum_grade * 0.5;

        // Count success & fail
        $success = 0;
        $fail = 0;

        $distribution = [
            '0-25' => 0,
            '26-50' => 0,
            '51-75' => 0,
            '76-100' => 0,
        ];

        foreach ($students as $student) {
            // Prefer teacher-updated degree, fallback to last attempt
            $grade = $degrees[$student->id]->score ?? $attempts[$student->id]->grade_obtained ?? null;

            if ($grade !== null) {
                if ($grade >= $passingGrade) $success++;
                else $fail++;

                // Update distribution
                if ($grade <= 25) $distribution['0-25']++;
                elseif ($grade <= 50) $distribution['26-50']++;
                elseif ($grade <= 75) $distribution['51-75']++;
                else $distribution['76-100']++;
            }
        }

        return view('pages.Manager.StudyContent.exams.viewResults', [
            'sectionExam' => $sectionExam,
            'exam' => $exam,
            'categories' => $categories,
            'students' => $students,
            'attempts' => $attempts,
            'degrees' => $degrees,
            'stats' => [
                'total' => $totalStudents,
                'attempted' => $studentsAttempted,
                'not_attempted' => $studentsNotAttempted,
                'success' => $success,
                'fail' => $fail,
            ],
            'distribution' => $distribution,
        ]);
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

        return view("pages.Manager.StudyContent.exams.edit", $data);
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
            'attempts' => 'required',
            'question_per_page' => 'required',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        try {
            $quizz = $exam::findOrFail($exam->id);
            $quizz->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $quizz->description = $request->post('description');
            $quizz->start_at = $request->post('start_at');
            $quizz->end_at = $request->post('end_at');
            $quizz->duration = $request->post('duration');
            $quizz->attempts = $request->post('attempts');
            $quizz->question_per_page = $request->post('question_per_page');
            if ($request->maximum_grade) {
                $quizz->maximum_grade = $request->post('maximum_grade');
            }
            $quizz->subject_id = $request->post('subject_id');
            $quizz->teacher_id = Auth::user()->teacher->id;
            $quizz->save();

            Flasher::addSuccess(trans('messages.Update'));
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
    public function destroy($id)
    {
        try {
            $exam = Exam::findOrFail($id);
            $exam->delete();

            Flasher::addError(trans('messages.Delete'));
            return redirect()->route('StudyContent.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function studentAttempts($examId, $studentId)
    {
        $exam = Exam::findOrFail($examId);
        $student = Student::findOrFail($studentId);

        // fetch all attempts of this student for this exam
        $attempts = ExamAttempts::where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->orderBy('created_at', 'asc')
            ->get();


        return view('pages.Manager.StudyContent.exams.student_attempts', compact('exam', 'student', 'attempts'));
    }

    public function assignZeroForAbsentStudents($examId)
    {
        $exam = Exam::with('sections.students')->findOrFail($examId);

        foreach ($exam->sections as $section) {
            foreach ($section->students as $student) {
                // Check if the student has any attempts
                $hasAttempt = ExamAttempts::where('exam_id', $examId)
                    ->where('student_id', $student->id)
                    ->exists();

                // If not, create a degree with 0 (if not already exists)
                if (!$hasAttempt) {
                    Degree::firstOrCreate(
                        [
                            'exam_id' => $examId,
                            'student_id' => $student->id,
                        ],
                        [
                            'score' => 0,
                            'date' => now(),
                            'feedback' => 'غياب عن الامتحان',
                            'absence' => '1',
                        ]
                    );
                }
            }
        }

        return back()->with('success', 'تم تعيين درجة 0 لكل الطلاب الغائبين عن الامتحان');
    }

    public function exportExamResults($exam_id)
    {
        $exam = Exam::findOrFail($exam_id);
        return Excel::download(new ExamResultsExport($exam), 'exam_' . $exam_id . '_results.xlsx');
    }
}
