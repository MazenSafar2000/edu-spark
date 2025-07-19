<?php

namespace App\Http\Livewire;

use App\Models\Degree;
use App\Models\Exam;
use App\Models\Question;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class ShowQuestions extends Component
{
    public $exam_id;
    public $student_id;
    public $questions;
    public $answers = [];
    public $currentQuestionIndex = 0;
    public $remaining_time;
    public $exam;
    public $is_exam_ended = false;
    public $review_page = false;

    protected $listeners = ['submitExam'];

    public function mount($exam_id, $student_id)
    {
        $this->exam_id = $exam_id;
        $this->student_id = $student_id;
        $this->exam = Exam::findOrFail($exam_id);
        $this->questions = Question::where('exam_id', $exam_id)->get();

        // Initialize remaining time
        $this->remaining_time = $this->exam->duration * 60; // duration in seconds

        // Start countdown timer
        $this->startTimer();
    }

    public function startTimer()
    {
        $this->dispatchBrowserEvent('start-timer', ['time' => $this->remaining_time]);
    }

    public function updatedAnswers($value, $question_id)
    {
        // Track the student's answer to each question
        $this->answers[$question_id] = $value;
    }

    public function submitExam()
    {
        // Save student's answers
        foreach ($this->answers as $question_id => $answer) {
            Degree::updateOrCreate(
                ['exam_id' => $this->exam_id, 'student_id' => $this->student_id, 'question_id' => $question_id],
                ['answer' => $answer, 'score' => $this->calculateScore($question_id, $answer)]
            );
        }

        // Mark the exam as ended
        $this->is_exam_ended = true;

        // Redirect to review page
        $this->review_page = true;
    }

    public function calculateScore($question_id, $answer)
    {
        // Get the right answer for the question
        $question = Question::find($question_id);

        // Check if the answer is correct
        return ($question->right_answer == $answer) ? $question->score : 0;
    }

    public function prevQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
        }
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
        }
    }

    public function goToQuestion($question_id)
    {
        // Find the question index by id
        $this->currentQuestionIndex = $this->questions->search(function ($question) use ($question_id) {
            return $question->id == $question_id;
        });
    }

    public function render()
    {
        return view('livewire.show-questions', [
            'questions' => $this->questions,
            'remaining_time' => $this->remaining_time,
            'review_page' => $this->review_page,
            'is_exam_ended' => $this->is_exam_ended,
        ]);
    }
}
