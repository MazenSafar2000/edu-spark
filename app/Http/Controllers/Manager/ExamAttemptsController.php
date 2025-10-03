<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\Exam;
use App\Models\ExamAttempts;
use App\Models\Student;
use Illuminate\Http\Request;
use Flasher\Laravel\Facade\Flasher;

class ExamAttemptsController extends Controller
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
     * @param  \App\Models\ExamAttempts  $examAttempts
     * @return \Illuminate\Http\Response
     */
    public function show(ExamAttempts $examAttempts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExamAttempts  $examAttempts
     * @return \Illuminate\Http\Response
     */
    public function edit(ExamAttempts $examAttempts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamAttempts  $examAttempts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamAttempts $examAttempts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExamAttempts  $examAttempts
     * @return \Illuminate\Http\Response
     */
    public function destroy($attempt_id)
    {
        try {
            $examAttempts = ExamAttempts::findOrFail($attempt_id);
            $examAttempts->delete();

            // find the highest grade among all completed attempts
            $bestAttempt = ExamAttempts::where('student_id', $examAttempts->student_id)
                ->where('exam_id', $examAttempts->exam_id)
                ->where('status', 'completed')
                ->orderByDesc('grade_obtained')
                ->first();

            $finalGrade = $bestAttempt->grade_obtained;

            // save score in degrees table
            Degree::updateOrCreate(
                [
                    'exam_id'    => $examAttempts->exam_id,
                    'student_id' => $examAttempts->student_id,
                ],
                [
                    'score'    => $finalGrade,
                    'date'     => now()->toDateString(),
                    'feedback' => null,
                ]
            );

            Flasher::addSuccess(trans('main_trans.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function showAttemptAnswers($examId, $studentId, $attemptId)
    {
        $attempt = ExamAttempts::with([
            'exam.questions' => function ($q) {
                $q->withPivot('score'); // from exam_questions
            },
            'answers'
        ])->findOrFail($attemptId);

        // decode the saved question order
        $orderedQuestionIds = is_array($attempt->question_order)
            ? $attempt->question_order
            : (is_string($attempt->question_order) ? json_decode($attempt->question_order, true) : []);


        // reorder the questions to match student view
        $questions = $attempt->exam->questions
            ->sortBy(fn($q) => array_search($q->id, $orderedQuestionIds))
            ->values();

        return view('pages.Manager.StudyContent.exams.attempt_answers', compact('attempt', 'questions'));
    }
}
