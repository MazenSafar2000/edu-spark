<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\Exam;
use App\Models\Question;
use App\Models\StudentAnswer;
use App\Models\studentExamSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{

    // public function show($exam_id)
    // {
    //     $student_id = Auth::user()->student->id;
    //     $exam = Exam::findOrFail($exam_id);

    //     return view('pages.Student.exams.exam_page', compact('exam_id', 'student_id', 'exam'));
    // }

    // public function startExam($exam_id)
    // {
    //     $student = auth()->user()->student;
    //     $exam = Exam::findOrFail($exam_id);

    //     // Check if the exam is active
    //     $now = now();
    //     if ($now->lt($exam->start_at) || $now->gt($exam->end_at)) {
    //         abort(403, 'الامتحان غير متاح حالياً');
    //     }

    //     // Check if already submitted
    //     if (Degree::where('exam_id', $exam_id)->where('student_id', $student->id)->exists()) {
    //         return redirect()->back()->with('error', 'لقد قمت بتقديم هذا الامتحان مسبقًا.');
    //     }

    //     // Get or create session
    //     $session = studentExamSession::firstOrCreate(
    //         ['student_id' => $student->id, 'exam_id' => $exam->id],
    //         ['started_at' => now()]
    //     );

    //     // Redirect to exam page
    //     return redirect()->route('student.exam.show', [$exam_id]);
    // }

    // start the exam
    public function showExam($exam_id)
    {
        $exam = Exam::findOrFail($exam_id);  // جلب تفاصيل الاختبار
        $questions = Question::where('exam_id', $exam_id)->paginate(5);  // جلب 5 أسئلة في كل صفحة
        $has_more = $questions->hasMorePages();

        // التحقق من وجود الجلسة (هل بدأ الطالب الاختبار؟)
        $session = StudentExamSession::where('exam_id', $exam_id)
            ->where('student_id', Auth::user()->student->id)
            ->first();

        if (!$session) {
            // إذا لم يكن الطالب قد بدأ الاختبار بعد، نقوم بإنشاء جلسة جديدة
            $session = StudentExamSession::create([
                'student_id' => Auth::user()->student->id,
                'exam_id' => $exam_id,
                'started_at' => now(),
            ]);
        }

        return view('pages.Student.exams.exam_page', compact('exam', 'questions', 'session', 'has_more'));
    }

    // لتخزين الإجابات تلقائيًا عند تغيير الإجابة
    public function autoSaveAnswers(Request $request)
    {
        $validated = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'required|string',
        ]);

        // جلب الجلسة الخاصة بالطالب
        $session = StudentExamSession::where('exam_id', $request->exam_id)
            ->where('student_id', Auth::user()->student->id)
            ->first();

        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        // تحديث أو إضافة الإجابة للطلاب في الجلسة
        $answers = json_decode($session->answers, true) ?? [];
        $answers[$request->question_id] = $request->answer;

        $session->update([
            'answers' => json_encode($answers),
        ]);

        return response()->json(['message' => 'Answer saved successfully']);
    }

    //
    // public function saveAnswers(Request $request, $exam_id)
    // {
    //     $student = auth()->user()->student;
    //     $session = StudentExamSession::where('student_id', $student->id)
    //         ->where('exam_id', $exam_id)->firstOrFail();

    //     $answers = $request->input('answers', []); // ['question_id' => 'selected_option']
    //     $storedAnswers = $session->answers ? json_decode($session->answers, true) : [];

    //     foreach ($answers as $question_id => $ans) {
    //         $storedAnswers[$question_id] = $ans;
    //     }

    //     $total_questions = Question::where('exam_id', $exam_id)->count();
    //     $questions_per_page = 5;
    //     $current_index = $session->current_question_index;
    //     $session->answers = json_encode($storedAnswers);
    //     if ((($current_index + 1) * $questions_per_page) < $total_questions) {
    //         $session->current_question_index++;
    //     }
    //     $session->save();

    //     return redirect()->route('student.exam.show', [$exam_id]);
    // }

    // مراجعة الاختبار قبل التسليم
    public function reviewExam($exam_id)
    {
        $exam = Exam::findOrFail($exam_id);
        $session = StudentExamSession::where('exam_id', $exam_id)
            ->where('student_id', Auth::user()->student->id)
            ->first();

        if (!$session) {
            return redirect()->back()->with('error', 'Session not found.');
        }

        // تحويل الإجابات المخزنة من JSON إلى مصفوفة
        $answers = json_decode($session->answers, true);

        // return view('student.review', compact('exam', 'answers'));
        return view('pages.Student.exams.reviewExam', compact('exam', 'answers'));
    }


    // save answeres and finish attembet
    public function submitExam(Request $request, $exam_id)
    {
        $student_id = Auth::user()->student->id;
        $exam = Exam::findOrFail($exam_id);

        // جلب الجلسة الخاصة بالطالب
        $session = StudentExamSession::where('exam_id', $exam_id)
            ->where('student_id', $student_id)
            ->first();

        if (!$session) {
            return redirect()->back()->with('error', 'Session not found.');
        }

        $answers = json_decode($session->answers, true); // الحصول على إجابات الطالب من الجلسة
        $totalScore = 0;

        // حساب الدرجة بناءً على الإجابات
        foreach ($answers as $question_id => $studentAnswer) {
            $question = Question::findOrFail($question_id);

            // مقارنة الإجابة الصحيحة
            if (trim($studentAnswer) === trim($question->right_answer)) {
                $totalScore += $question->score;
            }

            // حفظ الإجابة في جدول student_answers
            StudentAnswer::create([
                'student_exam_session_id' => $session->id,
                'question_id' => $question_id,
                'answer' => $studentAnswer,
            ]);
        }

        // حفظ الدرجة في جدول degrees
        Degree::updateOrCreate(
            ['student_id' => $student_id, 'exam_id' => $exam_id],
            ['score' => $totalScore, 'date' => now()]
        );

        // وضع الجلسة على أنها مكتملة
        $session->update(['is_submitted' => true, 'finished_at' => now()]);

        // إعادة التوجيه لصفحة المراجعة
        // return redirect()->route('student.exam.review', ['exam_id' => $exam_id]);
        return redirect()->route('subject.viewExam', [$exam_id]);
    }


    // Forced submit after timeout
    public function timeout($exam_id)
    {
        $student_id = Auth::user()->student->id;
        $session = StudentExamSession::where('exam_id', $exam_id)
            ->where('student_id', $student_id)
            ->first();

        if ($session) {
            // إذا انتهى الوقت، نحدث الجلسة ونعتبرها مكتملة
            $session->update(['is_submitted' => true, 'finished_at' => now()]);
        }

        return redirect()->route('student.exam.review', ['exam_id' => $exam_id]);
    }


    /////////////

}
