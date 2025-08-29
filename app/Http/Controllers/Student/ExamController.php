<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\Exam;
use App\Models\ExamAttempts;
use App\Models\Question;
use App\Models\SectionExam;
use App\Models\StudentAnswer;
use App\Models\studentExamSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{

    // public function startExam($exam_id)
    // {
    //     try {
    //         // Validate exam_id parameter
    //         if (!is_numeric($exam_id) || $exam_id <= 0) {
    //             return back()->withErrors('معرف الامتحان غير صالح.');
    //         }

    //         $user = Auth::user();
    //         $student = $user->student;

    //         // Check if student exists
    //         if (!$student) {
    //             return back()->withErrors('لم يتم العثور على معلومات الطالب.');
    //         }

    //         $exam = Exam::findOrFail($exam_id);

    //         // 1) Time window checks
    //         if (now()->lt($exam->start_at)) {
    //             return back()->withErrors('الامتحان لم يبدأ بعد.');
    //         }
    //         if (now()->gt($exam->end_at)) {
    //             return back()->withErrors('انتهى وقت الامتحان.');
    //         }


    //         // 2) Section access check (only if you use section_exams)
    //         // This check can be disabled by setting ENABLE_SECTION_ACCESS_CHECK to false
    //         if (config('app.enable_section_access_check', true)) {
    //             // Validate that student has a section
    //             if (!$student->section_id) {
    //                 return back()->withErrors('الطالب غير مرتبط بقسم.');
    //             }

    //             $hasAccess = SectionExam::where('exam_id', $exam->id)
    //                 ->where('section_id', $student->section_id)
    //                 ->exists();
    //             if (!$hasAccess) {
    //                 return back()->withErrors('هذا الامتحان غير متاح لقسمك.');
    //             }
    //         }
    //         // 3) Attempts limit
    //         // Validate that exam has attempts limit set
    //         if (!is_numeric($exam->attempts) || $exam->attempts <= 0) {
    //             return back()->withErrors('الامتحان غير متوفر حالياً (عدد المحاولات غير محدد).');
    //         }

    //         $attemptsCount = ExamAttempts::where('student_id', $student->id)
    //             ->where('exam_id', $exam->id)
    //             ->count();

    //         if ($attemptsCount >= $exam->attempts) {
    //             return back()->withErrors('لقد استنفدت جميع محاولاتك.');
    //         }

    //         // 4) Reuse unfinished attempt if exists
    //         $attempt = ExamAttempts::where('student_id', $student->id)
    //             ->where('exam_id', $exam->id)
    //             ->where('status', 'in_progress')
    //             ->first();

    //         if (!$attempt) {
    //             // Validate that exam has questions
    //             if ($exam->questions()->count() == 0) {
    //                 return back()->withErrors('هذا الامتحان لا يحتوي على أسئلة.');
    //             }

    //             // Validate exam duration
    //             if (!is_numeric($exam->duration) || $exam->duration <= 0) {
    //                 return back()->withErrors('مدة الامتحان غير محددة.');
    //             }

    //             // Get question IDs (be explicit to avoid ambiguous 'id')
    //             $questionIds = $exam->questions()->pluck('questions.id')->toArray();

    //             // Shuffle if teacher enabled
    //             if ($exam->shuffle_questions) {
    //                 $questionIds = collect($questionIds)->shuffle()->values()->toArray();
    //             }

    //             try {
    //                 $attempt = ExamAttempts::create([
    //                     'exam_id'                => $exam->id,
    //                     'student_id'             => $student->id,
    //                     'attempt_number'         => $attemptsCount + 1,
    //                     'current_question_index' => 0, // page index
    //                     'time_left'              => $exam->duration * 60, // seconds
    //                     'status'                 => 'in_progress',
    //                     'started_at'             => now(),
    //                     'question_order'         => $questionIds,
    //                 ]);
    //             } catch (\Exception $e) {
    //                 return back()->withErrors('حدث خطأ أثناء إنشاء محاولة الامتحان: ' . $e->getMessage());
    //             }
    //         }

    //         return redirect()->route('student.exam.take', ['attemptId' => $attempt->id, 'examId' => $exam->id]);
    //     } catch (\Throwable $e) {
    //         return back()->withErrors(['error' => 'حدث خطأ أثناء بدء الامتحان: ' . $e->getMessage()]);
    //     }
    // }

    public function startExam($exam_id)
    {
        try {
            if (!is_numeric($exam_id) || $exam_id <= 0) {
                return back()->withErrors('معرف الامتحان غير صالح.');
            }

            $user    = Auth::user();
            $student = $user->student;
            if (!$student) {
                return back()->withErrors('لم يتم العثور على معلومات الطالب.');
            }

            $exam = Exam::findOrFail($exam_id);

            // Time window
            if (now()->lt($exam->start_at)) {
                return back()->withErrors('الامتحان لم يبدأ بعد.');
            }
            if (now()->gt($exam->end_at)) {
                return back()->withErrors('انتهى وقت الامتحان.');
            }

            // Optional section access
            if (config('app.enable_section_access_check', true)) {
                if (!$student->section_id) {
                    return back()->withErrors('الطالب غير مرتبط بقسم.');
                }
                $hasAccess = SectionExam::where('exam_id', $exam->id)
                    ->where('section_id', $student->section_id)
                    ->exists();
                if (!$hasAccess) {
                    return back()->withErrors('هذا الامتحان غير متاح لقسمك.');
                }
            }

            // Validate attempts config
            if (!is_numeric($exam->attempts) || $exam->attempts <= 0) {
                return back()->withErrors('الامتحان غير متوفر حالياً (عدد المحاولات غير محدد).');
            }

            // 1) Reuse unfinished attempt if it exists
            $attempt = ExamAttempts::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('status', 'in_progress')
                ->first();

            if (!$attempt) {
                // Only count completed attempts toward the limit
                $completedAttempts = ExamAttempts::where('student_id', $student->id)
                    ->where('exam_id', $exam->id)
                    ->where('status', 'completed')
                    ->count();

                if ($completedAttempts >= (int)$exam->attempts) {
                    return back()->withErrors('لقد استنفدت جميع محاولاتك.');
                }

                // Validate exam has questions & duration
                if ($exam->questions()->count() == 0) {
                    return back()->withErrors('هذا الامتحان لا يحتوي على أسئلة.');
                }
                if (!is_numeric($exam->duration) || $exam->duration <= 0) {
                    return back()->withErrors('مدة الامتحان غير محددة.');
                }

                // Prepare ordered question IDs (sanitized)
                $questionIds = $exam->questions()->pluck('questions.id')->map(fn($id) => (int)$id)->toArray();
                if ($exam->shuffle_questions) {
                    $questionIds = collect($questionIds)->shuffle()->values()->toArray();
                }

                // Compute a hard deadline: min(start + duration, exam end window)
                $startAt    = now();
                $deadlineAt = min(
                    $startAt->copy()->addMinutes((int)$exam->duration),
                    $exam->end_at
                );

                // Create attempt
                $attempt = ExamAttempts::create([
                    'exam_id'                => $exam->id,
                    'student_id'             => $student->id,
                    'attempt_number'         => $completedAttempts + 1,
                    'current_question_index' => 0,
                    'time_left'              => (int) $startAt->diffInSeconds($deadlineAt), // optional, UI-only
                    'status'                 => 'in_progress',
                    'started_at'             => $startAt,
                    'deadline_at'            => $deadlineAt,
                    'question_order'         => $questionIds,
                ]);
            }

            return redirect()->route('student.exam.take', [
                'attemptId' => $attempt->id,
                'examId'    => $exam->id, // harmless extra param
            ]);
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'حدث خطأ أثناء بدء الامتحان: ' . $e->getMessage()]);
        }
    }
}
