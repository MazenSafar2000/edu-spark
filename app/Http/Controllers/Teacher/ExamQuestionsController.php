<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamQuestions;
use App\Models\Question;
use App\Models\QuestionsCategotry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($exam_id)
    {
        $exam = Exam::findOrFail($exam_id);
        $totalMarks = $exam->questions->sum(fn($q) => $q->pivot->score);

        $teacherId = Auth::user()->teacher->id;
        $categories = QuestionsCategotry::with('questionsBank')
            ->whereHas('questionsBank', function ($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            })->get();

        return view("pages.Teacher.exams.questions.index", compact('exam', 'totalMarks', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExamQuestions  $examQuestions
     * @return \Illuminate\Http\Response
     */
    public function show(ExamQuestions $examQuestions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExamQuestions  $examQuestions
     * @return \Illuminate\Http\Response
     */
    public function edit(ExamQuestions $examQuestions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamQuestions  $examQuestions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamQuestions $examQuestions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExamQuestions  $examQuestions
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamQuestions $examQuestions)
    {
        //
    }

    public function getQuestionsByCategory($category_id)
    {
        $questions = Question::where('QCategory_id', $category_id)->get();

        return response()->json([
            'questions' => $questions,
        ]);
    }

    public function storeFromBank(Request $request, Exam $exam)
    {
        $request->validate([
            'question_ids' => 'required|array',
            'question_ids.*' => 'exists:questions,id',
        ]);

        foreach ($request->question_ids as $questionId) {
            // Avoid duplicates
            $question = Question::find($questionId);
            ExamQuestions::firstOrCreate([
                'exam_id' => $exam->id,
                'question_id' => $questionId,
                'score' => $question->score,
            ]);
        }

        // تحديث مجموع الدرجات
        $totalMarks = DB::table('exam_questions')
            ->join('questions', 'exam_questions.question_id', '=', 'questions.id')
            ->where('exam_questions.exam_id', $exam->id)
            ->sum('questions.score');

        $exam->update([
            'total_marks' => $totalMarks,
        ]);


        return redirect()->back()->with('success', 'تمت إضافة الأسئلة من بنك الأسئلة بنجاح.');
    }

    public function storeRandomQuestions(Request $request, Exam $exam)
    {
        $request->validate([
            'category_id' => 'required|exists:questions_categories,id',
            'random_count' => 'required|integer|min:1',
        ]);

        $categoryId = $request->category_id;
        $count = $request->random_count;

        $questions = Question::where('QCategory_id', $categoryId)
            ->inRandomOrder()
            ->limit($count)
            ->get();

        foreach ($questions as $question) {
            ExamQuestions::firstOrCreate([
                'exam_id' => $exam->id,
                'question_id' => $question->id,
                'score' => $question->score,
            ]);
        }

        // تحديث مجموع الدرجات
        $totalMarks = DB::table('exam_questions')
            ->join('questions', 'exam_questions.question_id', '=', 'questions.id')
            ->where('exam_questions.exam_id', $exam->id)
            ->sum('questions.score');

        $exam->update([
            'total_marks' => $totalMarks,
        ]);

        return redirect()->back()->with('success', 'تمت إضافة الأسئلة العشوائية بنجاح.');
    }

    public function removeQuestionFromExam($examId, $questionId)
    {
        try {
            // تحقق من أن الربط موجود
            $deleted = DB::table('exam_questions')
                ->where('exam_id', $examId)
                ->where('question_id', $questionId)
                ->delete();

            if ($deleted) {
                // تحديث مجموع الدرجات بعد الحذف
                $totalMarks = DB::table('exam_questions')
                    ->join('questions', 'exam_questions.question_id', '=', 'questions.id')
                    ->where('exam_questions.exam_id', $examId)
                    ->sum('questions.score');

                Exam::where('id', $examId)->update(['total_marks' => $totalMarks]);

                toastr()->error(trans('messages.Delete'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateSettings(Request $request, Exam $exam)
    {
        // dd($request->all());
        $request->validate([
            'maximum_grade' => 'required|numeric|min:1',
        ]);

        $exam->update([
            'shuffle_questions' => $request->has('shuffle_questions'),
            'maximum_grade' => $request->maximum_grade,
        ]);

        return back()->with('success', 'تم تحديث إعدادات الامتحان بنجاح');
    }
}
