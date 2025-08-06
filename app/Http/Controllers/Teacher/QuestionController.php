<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['grades'] = Grade::all();
        return view('pages.Teacher.QuestionsBank.QuestionCategory.questions.create', $data);
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
            'title' => 'required|string|max:255',
            'answers' => 'required|array|min:2|max:4',
            'answers.*' => 'required|string|max:255',
            'right_answer' => ['required', 'integer', 'between:1,' . count($request->answers)],
            'score' => 'required|numeric',
        ]);


        try {
            $question = new Question();
            $question->title = $request->title;
            $question->answers = json_encode($request->answers);  // stored as JSON
            $question->right_answer = $request->answers[$request->right_answer - 1];  // get the correct answer value
            $question->score = $request->score;
            $question->exam_id = $request->exam_id;
            $question->save();

            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exam_id = $id;
        // $data['grades'] = Grade::all();

        return view('pages.Teacher.exams.questions.create', compact('exam_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findorFail($id);
        return view('pages.Teacher.exams.questions.edit', compact('question'));
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
        $request->validate([
            'title' => 'required|string|max:255',
            'answers' => 'required|array|min:2|max:4',
            'answers.*' => 'required|string|max:255',
            'right_answer' => ['required', 'integer', 'between:1,' . count($request->answers)],
            'score' => 'required|numeric',
        ]);


        try {
            $question = Question::findOrFail($id);
            $question->title = $request->title;
            $question->answers = json_encode($request->answers);
            $question->right_answer = $request->answers[$request->right_answer - 1];
            $question->score = $request->score;
            $question->exam_id = $request->exam_id; // just in case you want to allow changing quiz
            $question->save();

            toastr()->success(trans('messages.Update'));
            return redirect()->route('exams.show', $question->quizze_id);
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
    public function destroy(Question $question)
    {
        try {
            $question->delete();

            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
