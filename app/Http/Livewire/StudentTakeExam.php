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
    // public $attempt;
    // public $questions;
    // public $currentPage = 1;
    // public $answers = [];
    // public $totalPages;
    // public $timeLeft;

    // public function mount($attemptId)
    // {
    //     $this->attempt = ExamAttempts::findOrFail($attemptId);

    //     if ($this->attempt->student_id !== Auth::user()->student->id) {
    //         abort(403);
    //     }

    //     $start = $this->attempt->started_at;
    //     $durationSeconds = $this->attempt->exam->duration * 60;
    //     $elapsed = now()->diffInSeconds($start);
    //     $this->timeLeft = max($durationSeconds - $elapsed, 0);

    //     $this->answers = $this->attempt->answers ? json_decode($this->attempt->answers, true) : [];

    //     $this->loadQuestions();
    // }

    // private function loadQuestions()
    // {
    //     $exam = $this->attempt->exam;

    //     $this->questions = $exam->questions()
    //         ->skip(($this->currentPage - 1) * $exam->question_per_page)
    //         ->take($exam->question_per_page)
    //         ->get();

    //     $totalQuestions = $exam->questions()->count();
    //     $this->totalPages = ceil($totalQuestions / $exam->question_per_page);
    // }

    // public function updatedAnswers($value, $key)
    // {
    //     $this->attempt->answers = json_encode($this->answers);
    //     $this->attempt->save();
    // }

    // public function goToPage($page)
    // {
    //     if ($page < 1 || $page > $this->totalPages) {
    //         return;
    //     }

    //     $this->currentPage = $page;
    //     $this->loadQuestions();
    // }

    // public function submitExam()
    // {
    //     $score = 0;
    //     $exam = $this->attempt->exam;

    //     foreach ($exam->questions as $question) {
    //         if (isset($this->answers[$question->id]) && $this->answers[$question->id] == $question->correct_answer) {
    //             $score += $question->score;
    //         }
    //     }

    //     $this->attempt->score = $score;
    //     $this->attempt->completed = true;
    //     $this->attempt->ended_at = now();
    //     $this->attempt->save();

    //     session()->flash('message', 'تم إكمال الامتحان بنجاح! نتيجتك: ' . $score);
    //     return redirect()->route('student.exams');
    // }

    // public function render()
    // {
    //     return view('livewire.student-take-exam');
    // }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // public $exam;
    // public $attempt;
    // public $questions;
    // public $currentIndex;
    // public $timeLeft;
    // public $questionPerPage;

    // protected $listeners = ['saveAnswer' => 'saveAnswer', 'timeTick' => 'updateTime'];

    // public function mount($examId)
    // {
    //     $this->exam = Exam::findOrFail($examId);
    //     $studentId = Auth::id();

    //     // ابحث عن محاولة غير مكتملة
    //     $this->attempt = ExamAttempts::where('exam_id', $examId)
    //         ->where('student_id', $studentId)
    //         ->where('status', 'in_progress')
    //         ->first();

    //     if (!$this->attempt) {
    //         $attemptNumber = ExamAttempts::where('exam_id', $examId)
    //             ->where('student_id', $studentId)
    //             ->count() + 1;

    //         $this->attempt = ExamAttempts::create([
    //             'exam_id' => $examId,
    //             'student_id' => $studentId,
    //             'attempt_number' => $attemptNumber,
    //             'current_question_index' => 0,
    //             'time_left' => $this->exam->duration * 60,
    //         ]);

    //         // جلب الأسئلة مع Shuffle إذا مفعّل
    //         $questions = $this->exam->questions;
    //         if ($this->exam->shuffle_questions) {
    //             $questions = $questions->shuffle();
    //         }
    //         $this->questions = $questions->values();
    //     } else {
    //         $this->questions = $this->exam->questions; // ممكن نخزن الترتيب في المحاولة
    //     }

    //     $this->currentIndex = $this->attempt->current_question_index;
    //     $this->timeLeft = $this->attempt->time_left;
    //     $this->questionPerPage = $this->exam->question_per_page;
    // }

    // public function saveAnswer($questionId, $answer)
    // {
    //     StudentExamAnswers::updateOrCreate(
    //         ['attempt_id' => $this->attempt->id, 'question_id' => $questionId],
    //         ['answer' => $answer]
    //     );
    // }

    // public function nextQuestion()
    // {
    //     if ($this->currentIndex + $this->questionPerPage < count($this->questions)) {
    //         $this->currentIndex += $this->questionPerPage;
    //         $this->attempt->update(['current_question_index' => $this->currentIndex]);
    //     }
    // }

    // public function prevQuestion()
    // {
    //     if ($this->currentIndex - $this->questionPerPage >= 0) {
    //         $this->currentIndex -= $this->questionPerPage;
    //         $this->attempt->update(['current_question_index' => $this->currentIndex]);
    //     }
    // }

    // public function updateTime()
    // {
    //     $this->timeLeft--;
    //     $this->attempt->update(['time_left' => $this->timeLeft]);

    //     if ($this->timeLeft <= 0) {
    //         $this->finishExam();
    //     }
    // }

    // public function finishExam()
    // {
    //     $this->attempt->update(['status' => 'completed']);
    //     return redirect()->route('exam.result', $this->attempt->id);
    // }

    // public function render()
    // {
    //     $currentQuestions = $this->questions->slice($this->currentIndex, $this->questionPerPage);
    //     return view('livewire.exam-page', [
    //         'currentQuestions' => $currentQuestions,
    //     ]);
    // }

    /////////////////////////////////////////////////////////////////////

    // public $attemptId;
    // public $exam;
    // public $attempt;
    // public $questions;
    // public $currentPage = 1;
    // public $answers = [];
    // public $totalPages;
    // public $timeLeft; // seconds

    // protected $listeners = ['tick' => 'decrementTime'];

    // public function mount($attemptId)
    // {
    //     $this->attemptId = $attemptId;

    //     // Load attempt with exam
    //     $this->attempt = ExamAttempts::with('exam')->findOrFail($this->attemptId);
    //     $this->exam = $this->attempt->exam;

    //     // Get questions via the relationship
    //     if ($this->exam->shuffle_questions) {
    //         $this->questions = $this->exam->questions()->inRandomOrder()->get();
    //     } else {
    //         $this->questions = $this->exam->questions()->get();
    //     }

    //     // Calculate total pages
    //     $this->totalPages = ceil($this->questions->count() / $this->exam->question_per_page);

    //     // Load saved answers
    //     $savedAnswers = StudentExamAnswers::where('attempt_id', $this->attemptId)->get();
    //     foreach ($savedAnswers as $ans) {
    //         $this->answers[$ans->question_id] = $ans->answer;
    //     }

    //     // Set time left from attempt
    //     $this->timeLeft = $this->attempt->time_left;
    // }

    // public function updatedAnswers($value, $questionId)
    // {
    //     // Save answer instantly
    //     StudentExamAnswers::updateOrCreate(
    //         [
    //             'attempt_id' => $this->attemptId,
    //             'question_id' => $questionId
    //         ],
    //         [
    //             'answer' => $value
    //         ]
    //     );
    // }

    // public function nextPage()
    // {
    //     if ($this->currentPage < $this->totalPages) {
    //         $this->currentPage++;
    //         $this->saveAttemptState();
    //     }
    // }

    // public function prevPage()
    // {
    //     if ($this->currentPage > 1) {
    //         $this->currentPage--;
    //         $this->saveAttemptState();
    //     }
    // }

    // public function decrementTime()
    // {
    //     if ($this->timeLeft > 0) {
    //         $this->timeLeft--;
    //         $this->attempt->update(['time_left' => $this->timeLeft]);
    //     } else {
    //         $this->submitExam();
    //     }
    // }

    // public function submitExam()
    // {
    //     $this->attempt->update([
    //         'status' => 'completed',
    //         'time_left' => $this->timeLeft
    //     ]);

    //     return redirect()->route('student.exam.result', $this->attemptId);
    // }

    // protected function saveAttemptState()
    // {
    //     $this->attempt->update([
    //         'current_question_index' => $this->currentPage - 1,
    //         'time_left' => $this->timeLeft
    //     ]);
    // }

    // public function render()
    // {
    //     $questionsForPage = $this->questions
    //         ->slice(($this->currentPage - 1) * $this->exam->question_per_page, $this->exam->question_per_page);

    //     return view('livewire.student-take-exam', [
    //         'questionsForPage' => $questionsForPage
    //     ]);
    // }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
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
        $this->attempt = ExamAttempts::with('exam')->findOrFail($this->attemptId);

        // Security: only owner can access
        if ((int)$this->attempt->student_id !== (int)Auth::user()->student->id) {
            abort(403, 'غير مسموح لك بالوصول إلى هذا الامتحان.');
        }

        // Block if already completed or exam ended
        $this->exam = $this->attempt->exam;
        if ($this->attempt->status !== 'in_progress') {
            session()->flash('error', 'تم إكمال هذا الامتحان أو لم يعد متاحاً.');
            return redirect()->route('student.dashboard');
        }
        if (now()->gt($this->exam->end_at)) {
            // Hard-stop: exam expired -> finalize
            $this->forceFinalizeAsIs();
            session()->flash('error', 'انتهت مدة الامتحان.');
            return redirect()->route('student.dashboard');
        }

        // Load ordered questions
        $order = $this->attempt->question_order ?? [];
        if (empty($order)) {
            // Fallback if not set: use current exam order
            $order = $this->exam->questions()->pluck('questions.id')->toArray();
        }

        // Get questions in exact order and bring pivot score
        $questions = $this->exam->questions()
            ->withPivot('score')
            ->whereIn('questions.id', $order)
            ->orderByRaw("FIELD(questions.id, " . implode(',', $order) . ")")
            ->get();

        $this->questions      = $questions->values();
        $this->questionCount  = $this->questions->count();
        $this->questionsPerPage = max(1, (int)($this->exam->question_per_page ?? 1));
        $this->totalPages     = (int) ceil($this->questionCount / $this->questionsPerPage);
        $this->pageIndex      = (int)($this->attempt->current_question_index ?? 0);

        // Map question scores (pivot score override if present)
        foreach ($this->questions as $q) {
            $this->questionScores[$q->id] = $q->pivot->score ?? $q->score ?? 1;
        }

        // Load saved answers from DB into array
        $this->answers = StudentExamAnswers::where('attempt_id', $this->attempt->id)
            ->pluck('answer', 'question_id')
            ->toArray();

        // Timer
        $this->timeLeft = (int)($this->attempt->time_left ?? ($this->exam->duration * 60));
        if ($this->timeLeft <= 0) {
            $this->submitExam(); // aut-submit if no time left
            return;
        }

        $this->lastSyncedAt = time();
    }

    public function render()
    {
        return view('livewire.student-take-exam', [
            'currentQuestions' => $this->getCurrentPageQuestions(),
            'pageIndex'        => $this->pageIndex,
            'totalPages'       => $this->totalPages,
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
        $index = (int) $index;
        if ($index >= 0 && $index < $this->totalPages) {
            $this->pageIndex = $index;
            $this->persistProgress();
        }
    }

    /** Save a single answer (from client event) */
    public function saveAnswer($questionId, $value)
    {
        $questionId = (int)$questionId;
        $this->answers[$questionId] = is_string($value) ? trim($value) : $value;

        // Write to student_exam_answers immediately (idempotent)
        StudentExamAnswers::updateOrCreate(
            ['attempt_id' => $this->attempt->id, 'question_id' => $questionId],
            [
                'answer'     => $this->answers[$questionId],
                'is_correct' => $this->computeCorrectness($questionId, $this->answers[$questionId]),
            ]
        );

        $this->maybeSync();
    }

    /** Called every second by client when online */
    public function serverTick()
    {
        if ($this->timeLeft > 0) {
            $this->timeLeft--;
            $this->maybeSync();
        } else {
            $this->submitExam();
        }
    }

    /** Merge client local state (after reconnect or tab restore) */
    public function restoreClientState($payload)
    {
        // $payload = ['timeLeft' => int, 'answers' => {qid: val}, 'pageIndex' => int]
        $timeLeft  = isset($payload['timeLeft']) ? (int)$payload['timeLeft'] : $this->timeLeft;
        $pageIndex = isset($payload['pageIndex']) ? (int)$payload['pageIndex'] : $this->pageIndex;
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
        $this->pageIndex = max(0, min($this->totalPages - 1, $pageIndex));

        $this->persistProgress();
    }

    /** Persist attempt lightweight progress */
    protected function persistProgress()
    {
        $this->attempt->update([
            'time_left'              => $this->timeLeft,
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
        // dd();
        // Lock if exam time is over
        if (now()->gt($this->exam->end_at)) {
            $this->timeLeft = 0;
        }

        $scoreObtained   = $this->computeFinalScore();
        $totalMarks      = $this->computeExamTotalMarks();
        $maximumGrade    = (float)($this->exam->maximum_grade ?? 100);
        $gradeObtained   = $totalMarks > 0 ? ($scoreObtained / $totalMarks) * $maximumGrade : 0;

        $this->attempt->update([
            'status'          => 'completed',
            'ended_at'        => now(),
            'time_left'       => max(0, $this->timeLeft),
            'score_obtained'  => $scoreObtained,
            'grade_obtained'  => $gradeObtained,
        ]);

        // Optionally write to degrees table here if you want a snapshot record
        // Degree::updateOrCreate([...]);

        session()->flash('success', 'تم تسليم الامتحان بنجاح.');
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
