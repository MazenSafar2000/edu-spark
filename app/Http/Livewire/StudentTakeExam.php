<?php

namespace App\Http\Livewire;

use App\Models\Degree;
use App\Models\Exam;
use App\Models\ExamAttempts;
use App\Models\Question;
use App\Models\StudentExamAnswers;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentTakeExam extends Component
{
    // Route param
    public $attemptId;
    public $examId;

    // Core state
    public $attempt;
    public $exam;

    // Questions & paging
    public $questions;            // ordered collection
    public $questionCount = 0;
    public $questionsPerPage = 1;
    public $pageIndex = 0;        // page-based (not question-based)
    public $totalPages = 0;
    public  $allQuestions;

    // Answers + scoring helpers
    public $answers = [];         // keyed by question_id => value
    public $questionScores = [];  // keyed by question_id => score (from pivot or question)

    // Timer
    public $timeLeft;             // seconds
    public $syncInterval = 10;    // seconds between DB syncs
    public $lastSyncedAt;         // unix timestamp in seconds
    public $lastServerTimeCheck = 0; // unix timestamp in seconds
    public $serverTimeCheckInterval = 30; // seconds between server time checks

    protected $listeners = [
        // client->server events
        'tick'               => 'serverTick',
        'saveAnswer'         => 'saveAnswer',
        'restoreClientState' => 'restoreClientState',
        'submitExam'         => 'submitExam',
        'goToPage'           => 'goToPage',
    ];

    public function mount($attemptId)
    {
        $this->attemptId = (int) $attemptId;
        $this->attempt   = ExamAttempts::with('exam')->findOrFail($this->attemptId);
        $this->exam      = $this->attempt->exam;
        $this->examId    = $this->exam->id;

        // Security
        if ((int)$this->attempt->student_id !== (int)Auth::user()->student->id) {
            abort(403, 'غير مسموح لك بالوصول إلى هذا الامتحان.');
        }

        if ($this->attempt->status !== 'in_progress') {
            session()->flash('error', 'تم إكمال هذا الامتحان أو لم يعد متاحاً.');
            return redirect()->route('student.dashboard');
        }

        // If exam window ended, finalize
        if (now()->gt($this->exam->end_at)) {
            $this->forceFinalizeAsIs();
            session()->flash('error', 'انتهت مدة الامتحان.');
            return redirect()->route('student.dashboard');
        }

        // Ensure attempt has a deadline (backward compatibility)
        if (empty($this->attempt->deadline_at)) {
            $deadlineAt = min(
                $this->attempt->started_at->copy()->addMinutes((int)$this->exam->duration),
                $this->exam->end_at
            );
            $this->attempt->update(['deadline_at' => $deadlineAt]);
            $this->attempt->refresh();
        }

        // Derive time left from server deadline (authoritative)
        $this->timeLeft = $this->attempt->deadline_at->isPast()
            ? 0
            : now()->diffInSeconds($this->attempt->deadline_at);

        if ($this->timeLeft <= 0) {
            $this->submitExam();
            return;
        }

        // Ordered questions (sanitize IDs for FIELD())
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

        $this->questions         = $questions->values();
        $this->questionCount     = $this->questions->count();
        $this->questionsPerPage  = max(1, (int)($this->exam->question_per_page ?? 1));
        $this->totalPages        = (int) ceil($this->questionCount / $this->questionsPerPage);
        $this->pageIndex         = (int)($this->attempt->current_question_index ?? 0);

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

        $this->lastSyncedAt = time();
    }


    public function render()
    {
        return view('livewire.student-take-exam', [
            'attemptId'       => $this->attemptId,
            'examId'          => $this->examId,
            'timeLeft'        => $this->timeLeft,
            'pageIndex'       => $this->pageIndex,
            'totalPages'      => $this->totalPages,
            'allQuestions'    => $this->allQuestions,
            'currentQuestions' => $this->getCurrentPageQuestions(),
            'answers'         => $this->answers,
        ]);
    }

    /** Slice current page questions */
    protected function getCurrentPageQuestions()
    {
        $start = $this->pageIndex * $this->questionsPerPage;
        return $this->questions->slice($start, $this->questionsPerPage);
    }

    /** Client asks to change page */
    public function goToPage($index)
    {
        $index = (int)$index;
        if ($index >= 0 && $index < $this->totalPages) {
            $this->pageIndex = $index;
            $this->persistProgress();
        }
    }

    public function nextPage()
    {
        if ($this->pageIndex < $this->totalPages - 1) {
            $this->pageIndex++;
            $this->persistProgress();
        }
    }

    public function previousPage()
    {
        if ($this->pageIndex > 0) {
            $this->pageIndex--;
            $this->persistProgress();
        }
    }


    /** Save a single answer (from client event) */
    // public function saveAnswer($questionId, $value)
    // {
    //     $questionId = (int)$questionId;
    //     $this->answers[$questionId] = is_string($value) ? trim($value) : $value;

    //     // Write to student_exam_answers immediately (idempotent)
    //     StudentExamAnswers::updateOrCreate(
    //         ['attempt_id' => $this->attempt->id, 'question_id' => $questionId],
    //         [
    //             'answer'     => $this->answers[$questionId],
    //             'is_correct' => $this->computeCorrectness($questionId, $this->answers[$questionId]),
    //         ]
    //     );

    //     $this->maybeSync();
    // }

    /** Handle answer change from frontend */
    protected function upsertAnswer(int $questionId, $value): void
    {
        $this->answers[$questionId] = is_string($value) ? trim($value) : $value;

        StudentExamAnswers::updateOrCreate(
            ['attempt_id' => $this->attempt->id, 'question_id' => $questionId],
            [
                'answer'     => $this->answers[$questionId],
                'is_correct' => $this->computeCorrectness($questionId, $this->answers[$questionId]),
            ]
        );
    }
    public function saveAnswer($questionId, $value)
    {
        $this->upsertAnswer((int)$questionId, $value);
        $this->maybeSync();
    }
    public function updateAnswer($questionId, $value)
    {
        $this->upsertAnswer((int)$questionId, $value);
        $this->maybeSync();
    }

    /** Called every second by client when online */
    /** Check server time and correct drift */
    public function serverTick()
    {
        // Client shows a second-by-second countdown for UX
        if ($this->timeLeft > 0) {
            $this->timeLeft--;
        }

        // Periodically correct from server-side deadline
        $this->maybeSync();

        if ($this->timeLeft <= 0) {
            $this->submitExam();
        }
    }

    protected function checkServerTime()
    {
        $this->attempt->refresh();
        if ($this->attempt->deadline_at) {
            $serverTimeLeft = $this->attempt->deadline_at->isPast()
                ? 0
                : now()->diffInSeconds($this->attempt->deadline_at);

            if (abs($this->timeLeft - $serverTimeLeft) > 5) {
                $this->timeLeft = $serverTimeLeft;
            }
        }
        $this->lastServerTimeCheck = time();
    }


    /** Merge client local state (after reconnect or tab restore) */
    public function restoreClientState($payload)
    {
        // $payload = ['timeLeft' => int, 'answers' => {qid: val}]
        $timeLeft  = isset($payload['timeLeft']) ? (int)$payload['timeLeft'] : $this->timeLeft;
        $answers   = isset($payload['answers']) && is_array($payload['answers']) ? $payload['answers'] : [];

        // Update answers into DB
        foreach ($answers as $qid => $val) {
            $qid = (int)$qid;
            $this->answers[$qid] = is_string($val) ? trim($val) : $val;

            StudentExamAnswers::updateOrCreate(
                ['attempt_id' => $this->attempt->id, 'question_id' => $qid],
                [
                    'answer'     => $this->answers[$qid],
                    'is_correct' => $this->computeCorrectness($qid, $this->answers[$qid]),
                ]
            );
        }

        // Clamp timeLeft (never extend beyond server if client clocks drift)
        $this->timeLeft  = max(0, min($this->timeLeft, $timeLeft));
        $this->persistProgress();
    }

    /** Persist attempt lightweight progress */
    protected function persistProgress()
    {
        // Keep writing time_left as a convenience (UI/debug), but the real authority is deadline_at
        $this->attempt->update([
            'time_left'              => max(0, (int)$this->timeLeft),
            'current_question_index' => $this->pageIndex,
        ]);
        $this->lastSyncedAt = time();
    }


    /** Sync to DB every $syncInterval seconds to avoid hammering */
    protected function maybeSync()
    {
        if ((time() - $this->lastSyncedAt) >= $this->syncInterval) {
            $this->persistProgress();
        }

        // Check server time periodically to correct drift
        if ((time() - $this->lastServerTimeCheck) >= $this->serverTimeCheckInterval) {
            $this->checkServerTime();
        }
    }



    /** Compute correctness for MCQ/TrueFalse */
    protected function computeCorrectness(int $questionId, $answer)
    {
        $q = $this->questions->firstWhere('id', $questionId);
        if (!$q) return null;

        if (in_array($q->type, ['MCQ', 'TrueFalse'])) {
            // correct_answer is stored as string; for MCQ you can store the exact text or an index
            return (string)$answer === (string)$q->correct_answer;
        }

        // If you later add essay types, return null for manual grading
        return null;
    }

    /** Compute final numeric score using per-question scores (pivot or default) */
    protected function computeFinalScore(): float
    {
        $answers = StudentExamAnswers::where('attempt_id', $this->attempt->id)->get();
        $sum = 0.0;

        foreach ($answers as $ans) {
            if ($ans->is_correct) {
                $sum += (float)($this->questionScores[$ans->question_id] ?? 1.0);
            }
        }
        return $sum;
    }

    /** Compute exam total marks (from pivot if available, else question->score) */
    protected function computeExamTotalMarks(): float
    {
        // Prefer exam->total_marks if you precomputed it
        if (!is_null($this->exam->total_marks) && $this->exam->total_marks > 0) {
            return (float)$this->exam->total_marks;
        }

        // Else sum of this exam's question scores (pivot overrides)
        $sum = 0.0;
        foreach ($this->questions as $q) {
            $sum += (float)($q->pivot->score ?? $q->score ?? 1.0);
        }
        return $sum;
    }

    /** Finalize attempt */
    public function submitExam()
    {
        // Clamp to exam window end just in case
        if (now()->gt($this->exam->end_at)) {
            $this->timeLeft = 0;
        }

        // If someone already finalized in another tab, bail gracefully
        if ($this->attempt->status !== 'in_progress') {
            return redirect()->route('student.dashboard');
        }

        $scoreObtained = $this->computeFinalScore();
        $totalMarks    = $this->computeExamTotalMarks();
        $maximumGrade  = (float)($this->exam->maximum_grade ?? 100);
        $gradeObtained = $totalMarks > 0 ? ($scoreObtained / $totalMarks) * $maximumGrade : 0;

        // Only transition if still in_progress
        $updated = ExamAttempts::where('id', $this->attempt->id)
            ->where('status', 'in_progress')
            ->update([
                'status'         => 'completed',
                'ended_at'       => now(),
                'time_left'      => 0,
                'score_obtained' => $scoreObtained,
                'grade_obtained' => $gradeObtained,
            ]);

        if ($updated) {
            session()->flash('success', 'تم تسليم الامتحان بنجاح.');
        }

        return redirect()->route('student.dashboard');
    }


    /** In case exam expired while mounting */
    protected function forceFinalizeAsIs()
    {
        $scoreObtained   = $this->computeFinalScore();
        $totalMarks      = $this->computeExamTotalMarks();
        $maximumGrade    = (float)($this->exam->maximum_grade ?? 100);
        $gradeObtained   = $totalMarks > 0 ? ($scoreObtained / $totalMarks) * $maximumGrade : 0;

        $this->attempt->update([
            'status'          => 'completed',
            'ended_at'        => now(),
            'time_left'       => 0,
            'score_obtained'  => $scoreObtained,
            'grade_obtained'  => $gradeObtained,
        ]);
    }
}
