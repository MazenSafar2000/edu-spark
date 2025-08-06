<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionsBank;
use App\Models\QuestionsCategotry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['questions'] = Question::all();

        $teacherId = Auth::user()->teacher->id;
        $categories = QuestionsCategotry::with('bank')
            ->whereHas('bank', function ($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            })->get();

        // dd($data['QCategories']);

        return view('pages.Teacher.QuestionsBank.index', $data, compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionsBank  $questionsBank
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionsBank $questionsBank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionsBank  $questionsBank
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionsBank $questionsBank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionsBank  $questionsBank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionsBank $questionsBank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionsBank  $questionsBank
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionsBank $questionsBank)
    {
        //
    }
}
