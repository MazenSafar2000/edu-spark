<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\Exam;
use App\Models\ExamAttempts;
use App\Models\Student;
use Illuminate\Http\Request;
use Flasher\Laravel\Facade\Flasher;

class ExamAttemptsController extends Controller
{
    public function review($attemptId)
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

        return view('pages.Student.exams.viewAttempt', compact('attempt', 'questions'));
    }
}
