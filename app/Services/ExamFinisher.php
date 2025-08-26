<?php

namespace App\Services;

use App\Models\Degree;
use App\Models\ExamAttempts;
use App\Models\StudentExamAnswers;
use App\Models\Degrees;
use Illuminate\Support\Facades\DB;

class ExamFinisher
{
    /**
     *
     * @param  int|\App\Models\ExamAttempts  $attemptOrId
     * @return \App\Models\ExamAttempts|null
     */
    public function finish($attemptOrId, bool $force = false)
    {
        $attemptId = $attemptOrId instanceof ExamAttempts
            ? $attemptOrId->id
            : $attemptOrId;

        return DB::transaction(function () use ($attemptId, $force) {
            $attempt = ExamAttempts::with('exam')
                ->lockForUpdate()
                ->find($attemptId);

            if (!$attempt || $attempt->status !== 'in_progress') {
                return $attempt;
            }

            $exam = $attempt->exam;

            if (
                $force ||
                now()->greaterThanOrEqualTo($attempt->deadline_at) ||
                ($exam && now()->greaterThan($exam->end_at))
            ) {

                // 1) calculate the score
                [$scoreObtained, $totalMarks] = $this->computeScores($attempt);

                $maximumGrade  = (float)($exam->maximum_grade ?? 100);
                $gradeObtained = $totalMarks > 0
                    ? ($scoreObtained / $totalMarks) * $maximumGrade
                    : 0;

                // 2) update the attempt
                $attempt->update([
                    'status'         => 'completed',
                    'ended_at'       => now(),
                    'time_left'      => 0,
                    'score_obtained' => $scoreObtained,
                    'grade_obtained' => $gradeObtained,
                ]);

                // 3) save score in degrees table
                Degree::updateOrCreate(
                    [
                        'exam_id'    => $exam->id,
                        'student_id' => $attempt->student_id,
                    ],
                    [
                        'score'    => $gradeObtained,
                        'date'     => now()->toDateString(),
                        'feedback' => null,
                    ]
                );

                $attempt->refresh();
            }

            return $attempt;
        });
    }

    /**
     * حساب درجات الطالب من الإجابات
     *
     * @param  \App\Models\ExamAttempts  $attempt
     * @return array [scoreObtained, totalMarks]
     */
    protected function computeScores(ExamAttempts $attempt): array
    {
        $scoreObtained = 0;
        $totalMarks    = $attempt->exam->total_marks ?? 0;

        // استرجاع الإجابات
        $answers = StudentExamAnswers::where('attempt_id', $attempt->id)->get();

        foreach ($answers as $ans) {
            $question = $ans->question;

            if (!$question) {
                continue;
            }

            $isCorrect = $this->isCorrect($question->correct_answer, $ans->answer);

            $ans->update(['is_correct' => $isCorrect]);

            if ($isCorrect) {
                $scoreObtained += $question->score;
            }
        }

        return [$scoreObtained, $totalMarks];
    }

    /**
     *
     * @param  string $correct
     * @param  string $given
     * @return bool
     */
    protected function isCorrect(string $correct, string $given): bool
    {
        return trim(strtolower($correct)) === trim(strtolower($given));
    }
}
