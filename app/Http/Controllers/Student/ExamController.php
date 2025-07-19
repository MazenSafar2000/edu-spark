<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\Exam;
use App\Models\Question;
use App\Models\studentExamSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{

    public function show($exam_id)
    {
        $student_id = Auth::user()->student->id;
        $exam = Exam::findOrFail($exam_id);

        return view('pages.Student.exams.exam_page', compact('exam_id', 'student_id', 'exam'));
    }

    public function startExam($exam_id)
    {
        $student = auth()->user()->student;
        $exam = Exam::findOrFail($exam_id);

        // Check if the exam is active
        $now = now();
        if ($now->lt($exam->start_at) || $now->gt($exam->end_at)) {
            abort(403, 'الامتحان غير متاح حالياً');
        }

        // Check if already submitted
        if (Degree::where('exam_id', $exam_id)->where('student_id', $student->id)->exists()) {
            return redirect()->back()->with('error', 'لقد قمت بتقديم هذا الامتحان مسبقًا.');
        }

        // Get or create session
        $session = studentExamSession::firstOrCreate(
            ['student_id' => $student->id, 'exam_id' => $exam->id],
            ['started_at' => now()]
        );

        // Redirect to exam page
        return redirect()->route('student.exam.show', [$exam_id]);
    }

    public function showExam($exam_id)
    {
        $student = auth()->user()->student;
        $exam = Exam::findOrFail($exam_id);
        $session = StudentExamSession::where('student_id', $student->id)
            ->where('exam_id', $exam_id)->firstOrFail();

        // Calculate remaining time
        $elapsed = now()->diffInSeconds($session->started_at);
        $time_limit = $exam->duration * 60;
        if ($elapsed >= $time_limit) {
            return $this->forceSubmit($exam_id);
        }

        // Load 5 questions
        $page = $session->current_question_index;
        $questions = Question::where('exam_id', $exam_id)
            ->skip($page * 5)
            ->take(5)
            ->get();

        return view('pages.Student.exams.exam_page', compact('exam', 'questions', 'session', 'time_limit', 'elapsed'));
    }

    public function saveAnswers(Request $request, $exam_id)
    {
        $student = auth()->user()->student;
        $session = StudentExamSession::where('student_id', $student->id)
            ->where('exam_id', $exam_id)->firstOrFail();

        $answers = $request->input('answers', []); // ['question_id' => 'selected_option']
        $storedAnswers = $session->answers ? json_decode($session->answers, true) : [];

        foreach ($answers as $question_id => $ans) {
            $storedAnswers[$question_id] = $ans;
        }

        $session->answers = json_encode($storedAnswers);
        $session->current_question_index++;
        $session->save();

        return redirect()->route('student.exam.show', [$exam_id]);
    }

    public function reviewExam($exam_id)
    {
        $exam = Exam::findOrFail($exam_id);
        $student = auth()->user()->student;
        $session = StudentExamSession::where('student_id', $student->id)
            ->where('exam_id', $exam_id)->firstOrFail();

        $questions = Question::where('exam_id', $exam_id)->get();
        $answers = json_decode($session->answers, true);

        $elapsed = now()->diffInSeconds($session->started_at);
        $time_limit = $exam->duration * 60;
        if ($elapsed >= $time_limit) {
            return $this->forceSubmit($exam_id);
        }

        return view('pages.Student.exams.reviewExam', compact('questions', 'answers', 'exam', 'time_limit', 'elapsed'));
    }

    public function submitExam($exam_id)
    {
        $student = auth()->user()->student;
        $session = StudentExamSession::where('student_id', $student->id)
            ->where('exam_id', $exam_id)->firstOrFail();

        if ($session->is_submitted) return back();

        $total_score = 0;
        $answers = json_decode($session->answers, true);
        $questions = Question::where('exam_id', $exam_id)->get();

        foreach ($questions as $question) {
            if (isset($answers[$question->id]) && $answers[$question->id] === $question->right_answer) {
                $total_score += $question->score;
            }
        }

        Degree::create([
            'exam_id' => $exam_id,
            'student_id' => $student->id,
            'score' => $total_score,
            'date' => now(),
        ]);

        $session->update(['is_submitted' => true, 'finished_at' => now()]);

        return redirect()->route('subject.viewExam', [$exam_id]);
    }

    // Forced submit after timeout
    public function forceSubmit($exam_id)
    {
        return $this->submitExam($exam_id);
    }
}
