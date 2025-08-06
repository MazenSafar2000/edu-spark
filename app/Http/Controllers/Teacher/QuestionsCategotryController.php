<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\QuestionsBank;
use App\Models\QuestionsCategotry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsCategotryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['questionCategories'] = QuestionsCategotry::all();

        return view('pages.Teacher.QuestionsBank.QuestionCategory.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.Teacher.QuestionsBank.QuestionCategory.create');
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
            'title' => 'required|string',
            'QBank' => 'exists:questions_banks,id'
        ]);

        try {

            $QCategory = new QuestionsCategotry();

            $QCategory->title = $request->post('title');
            $QCategory->questions_bank_id = Auth::user()->teacher->id;

            $QCategory->save();



            toastr()->success(trans('messages.success'));
            return redirect()->route('questionsCategotry.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionsCategotry  $questionsCategotry
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionsCategotry $questionsCategotry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionsCategotry  $questionsCategotry
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionsCategotry $questionsCategotry)
    {
        $category = $questionsCategotry;

        return view('pages.Teacher.QuestionsBank.QuestionCategory.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionsCategotry  $questionsCategotry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionsCategotry $questionsCategotry)
    {
        $request->validate([
            'title' => 'required|string',
            'QBank' => 'exists:questions_banks,id'
        ]);

        try {

            $QCategory = $questionsCategotry;

            $QCategory->title = $request->post('title');
            $QCategory->questions_bank_id = Auth::user()->teacher->id;

            $QCategory->save();



            toastr()->success(trans('messages.success'));
            return redirect()->route('questionsCategotry.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionsCategotry  $questionsCategotry
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionsCategotry $questionsCategotry)
    {
        try {
            $questionsCategotry->delete();

            toastr()->error(trans('messages.Delete'));
            return redirect()->route('questionsCategotry.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
