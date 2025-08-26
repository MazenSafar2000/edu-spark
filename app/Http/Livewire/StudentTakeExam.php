<?php

namespace App\Http\Livewire;

use App\Models\Degree;
use App\Models\Exam;
use App\Models\ExamAttempts;
use App\Models\Question;
use App\Models\StudentExamAnswers;
use App\Services\ExamFinisher;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentTakeExam extends Component
{
    public $attemptId;
    public $examId;

    public $attempt;
    public $exam;

    public $questions;
    public $questionCount = 0;
    public $questionsPerPage = 1;
    public $pageIndex = 0;
    public $totalPages = 0;
    public $allQuestions;

    public $answers = [];
    public $questionScores = [];

    public $timeLeft; // seconds

    protected $listeners = [
        'checkDeadline' => 'checkDeadline',
        'saveAnswer' => 'saveAnswer',
        'goToPage' => 'goToPage',
        'submitExam' => 'submitExam',
    ];

    public function mount($attemptId)
    {
        $this->attemptId = (int)$attemptId;
        $this->attempt = ExamAttempts::with('exam')->findOrFail($this->attemptId);
        $this->exam = $this->attempt->exam;
        $this->examId = $this->exam->id;

        // Security
        if ((int)$this->attempt->student_id !== (int)Auth::user()->student->id) {
            abort(403, 'غير مسموح لك بالوصول إلى هذا الامتحان.');
        }

        if ($this->attempt->status !== 'in_progress') {
            session()->flash('error', 'تم إكمال هذا الامتحان أو لم يعد متاحاً.');
            return redirect()->route('student.dashboard');
        }

        // Ensure attempt has a deadline
        // تأكيد وجود deadline_at (مرة واحدة فقط)
        if (!$this->attempt->deadline_at) {
            $deadlineAt = \Carbon\Carbon::min(
                $this->attempt->started_at->copy()->addMinutes((int) $this->exam->duration),
                $this->exam->end_at
            );
            $this->attempt->update(['deadline_at' => $deadlineAt]);
            $this->attempt->refresh();
        }

        // فرق زمني موقّع
        $diff = now()->diffInSeconds($this->attempt->deadline_at, false);
        $this->timeLeft = max(0, $diff);

        // إنتهى الوقت فعليًا؟
        if ($this->timeLeft <= 0) {
            $this->forceFinishAttempt(); // دالة جديدة مضمونة
            session()->flash('success', 'تم تسليم الامتحان تلقائيًا لانتهاء الوقت.');
            return redirect()->route('student.dashboard');
        }

        // Load questions
        $order = $this->attempt->question_order ?? [];
        if (empty($order)) {
            $order = $this->exam->questions()->pluck('questions.id')->map(fn($id) => (int)$id)->toArray();
        } else {
            $order = collect($order)->map(fn($id) => (int)$id)->toArray();
        }
        $orderList = implode(',', $order);

        $questions = $this->exam->questions()
            ->withPivot('score')
            ->whereIn('questions.id', $order)
            ->when(!empty($order), fn($q) => $q->orderByRaw("FIELD(questions.id, {$orderList})"))
            ->get();

        $this->questions = $questions->values();
        $this->questionCount = $this->questions->count();
        $this->questionsPerPage = max(1, (int)($this->exam->question_per_page ?? 1));
        $this->totalPages = (int)ceil($this->questionCount / $this->questionsPerPage);
        $this->pageIndex = (int)($this->attempt->current_question_index ?? 0);

        // Prepare pages
        $this->allQuestions = [];
        for ($i = 0; $i < $this->totalPages; $i++) {
            $start = $i * $this->questionsPerPage;
            $this->allQuestions[$i] = $this->questions->slice($start, $this->questionsPerPage)->values()->toArray();
        }

        foreach ($this->questions as $q) {
            $this->questionScores[$q->id] = $q->pivot->score ?? $q->score ?? 1;
        }

        $this->answers = StudentExamAnswers::where('attempt_id', $this->attempt->id)
            ->pluck('answer', 'question_id')->toArray();
    }


    public function render()
    {
        return view('livewire.student-take-exam', [
            'attemptId' => $this->attemptId,
            'examId' => $this->examId,
            'timeLeft' => $this->timeLeft,
            'pageIndex' => $this->pageIndex,
            'totalPages' => $this->totalPages,
            'allQuestions' => $this->allQuestions,
            'currentQuestions' => $this->getCurrentPageQuestions(),
            'answers' => $this->answers,
        ]);
    }

    protected function getCurrentPageQuestions()
    {
        $start = $this->pageIndex * $this->questionsPerPage;
        return $this->questions->slice($start, $this->questionsPerPage);
    }

    public function goToPage($pageIndex, $questionId = null)
    {
        $this->attempt->refresh();
        if ($this->attempt->deadline_at->isPast() || $this->attempt->status !== 'in_progress') {
            $this->forceFinishAttempt();
            return;
        }

        $pageIndex = (int)$pageIndex;

        if ($pageIndex >= 0 && $pageIndex < $this->totalPages) {
            $this->pageIndex = $pageIndex;
            $this->attempt->update(['current_question_index' => $this->pageIndex]);

            // Emit event to scroll to specific question (if provided)
            if ($questionId) {
                $this->emit('scrollToQuestion', $questionId);
            }
        }
    }

    public function saveAnswer($questionId, $value)
    {
        $this->attempt->refresh();
        if ($this->attempt->deadline_at->isPast() || $this->attempt->status !== 'in_progress') {
            $this->forceFinishAttempt();
            return;
        }

        $questionId = (int)$questionId;
        $this->answers[$questionId] = $value;

        StudentExamAnswers::updateOrCreate(
            ['attempt_id' => $this->attempt->id, 'question_id' => $questionId],
            [
                'answer' => $value,
                'is_correct' => $this->computeCorrectness($questionId, $value),
            ]
        );
    }

    protected function computeCorrectness(int $questionId, $answer)
    {
        $q = $this->questions->firstWhere('id', $questionId);
        if (!$q) return null;

        if (in_array($q->type, ['MCQ', 'TrueFalse'])) {
            return (string)$answer === (string)$q->correct_answer;
        }

        return null; // Essay/manual grading
    }

    public function checkDeadline()
    {
        $this->attempt->refresh();

        if ($this->attempt->deadline_at->isPast()) {
            $this->timeLeft = 0;
            $this->forceFinishAttempt();
            return;
        }

        $this->timeLeft = now()->diffInSeconds($this->attempt->deadline_at);
    }

    public function submitExam()
    {
        if ($this->attempt->status !== 'in_progress') {
            return redirect()->route('student.dashboard');
        }

        // $scoreObtained = $this->computeFinalScore();
        // $totalMarks = $this->computeExamTotalMarks();
        // $maximumGrade = (float)($this->exam->maximum_grade ?? 100);
        // $gradeObtained = $totalMarks > 0 ? ($scoreObtained / $totalMarks) * $maximumGrade : 0;

        // $this->attempt->update([
        //     'status' => 'completed',
        //     'ended_at' => now(),
        //     'time_left' => 0,
        //     'score_obtained' => $scoreObtained,
        //     'grade_obtained' => $gradeObtained,
        // ]);

        $finisher = app(ExamFinisher::class);
        $finisher->finish($this->attemptId, true);

        session()->flash('success', 'تم تسليم الامتحان بنجاح.');
        return redirect()->route('student.dashboard');
    }

    protected function forceFinishAttempt(): void
    {
        // أعد تحميل من قاعدة البيانات وبقفل تشاركي
        $attempt = ExamAttempts::where('id', $this->attempt->id)->lockForUpdate()->first();

        if (!$attempt || $attempt->status !== 'in_progress') {
            return;
        }

        // لو الوقت انتهى أو النافذة أغلقت
        if (now()->greaterThanOrEqualTo($attempt->deadline_at) || now()->greaterThan($this->exam->end_at)) {

            // احسب الدرجات (نفس طريقتك)
            $scoreObtained = $this->computeFinalScore();
            $totalMarks    = $this->computeExamTotalMarks();
            $maximumGrade  = (float)($this->exam->maximum_grade ?? 100);
            $gradeObtained = $totalMarks > 0 ? ($scoreObtained / $totalMarks) * $maximumGrade : 0;

            $attempt->update([
                'status'         => 'completed',
                'ended_at'       => now(),
                'time_left'      => 0,
                'score_obtained' => $scoreObtained,
                'grade_obtained' => $gradeObtained,
            ]);

            $this->attempt->refresh();
            $this->timeLeft = 0;
        }
    }


    protected function computeFinalScore(): float
    {
        $answers = StudentExamAnswers::where('attempt_id', $this->attempt->id)->get();
        $sum = 0;
        foreach ($answers as $ans) {
            if ($ans->is_correct) {
                $sum += (float)($this->questionScores[$ans->question_id] ?? 1);
            }
        }
        return $sum;
    }

    protected function computeExamTotalMarks(): float
    {
        if (!is_null($this->exam->total_marks) && $this->exam->total_marks > 0) {
            return (float)$this->exam->total_marks;
        }
        $sum = 0;
        foreach ($this->questions as $q) {
            $sum += (float)($q->pivot->score ?? $q->score ?? 1);
        }
        return $sum;
    }
}
