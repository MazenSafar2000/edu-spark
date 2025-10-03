<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\Question;
use App\Models\QuestionsCategotry;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flasher\Laravel\Facade\Flasher;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['grades'] = Grade::all();
        $data['Qcategories'] = QuestionsCategotry::all();
        $data['teachers'] = Teacher::all();
        return view('pages.Manager.StudyContent.QuestionsBank.QuestionCategory.questions.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id'     => 'required|exists:teachers,id',
            'QCategory_id'   => 'required|exists:questions_categories,id',
            'question'       => 'required|string|max:500',
            'type'           => 'required|in:TrueFalse,MCQ',
            'correct_answer' => 'required',
            'score'          => 'required|integer|min:1',
            'options'        => 'required_if:type,MCQ|array|min:2|max:4',
            'options.*'      => 'required_if:type,MCQ|max:255',
        ]);

        try {

            $question = new Question();
            $question->QCategory_id   = $request->QCategory_id;
            $question->question       = $request->question;
            $question->type           = $request->type;
            $question->score          = $request->score;

            if ($request->type === 'TrueFalse') {
                $question->options = json_encode(["true", 'false']);
                $question->correct_answer = $request->correct_answer === 'true' ? 'true' : 'false';
            } else {
                $question->options = json_encode($request->options);
                $question->correct_answer = $request->correct_answer;
            }
            $question->teacher_id = $request->teacher_id;

            $question->save();

            Flasher::addSuccess(trans('main_trans.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findorFail($id);
        $teacherId = $question->teacher_id;
        $data['Qcategories'] = QuestionsCategotry::with('questionsBank')
            ->whereHas('questionsBank', function ($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            })->get();
        $teachers = Teacher::all();
        return view('pages.Manager.StudyContent.QuestionsBank.QuestionCategory.questions.edit', compact('question', 'teachers'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $request->validate([
            'teacher_id'     => 'required|exists:teachers,id',
            'QCategory_id'   => 'required|exists:questions_categories,id',
            'question'       => 'required|string|max:500',
            'type'           => 'required|in:TrueFalse,MCQ',
            'correct_answer' => 'required',
            'score'          => 'required|integer|min:1',
            'options'        => 'required_if:type,MCQ|array|min:2|max:4',
            'options.*'      => 'required_if:type,MCQ|max:255',
        ]);


        try {

            $question->teacher_id = $request->teacher_id;
            $question->QCategory_id = $request->QCategory_id;
            $question->question     = $request->question;
            $question->type         = $request->type;
            $question->score        = $request->score;

            if ($request->type === 'TrueFalse') {
                $question->options = json_encode(['true', 'false']);
                $question->correct_answer = $request->correct_answer;
            } else {
                $question->options = json_encode($request->options);
                $question->correct_answer = $request->correct_answer;
            }

            $question->save();

            Flasher::addSuccess(trans('main_trans.Update'));
            return redirect()->route('QuestionsBank.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $question = Question::findOrFail($id);
            $question->delete();

            Flasher::addError(trans('main_trans.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
