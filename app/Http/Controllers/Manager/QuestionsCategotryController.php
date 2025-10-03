<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Models\QuestionsBank;
use App\Models\QuestionsCategotry;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flasher\Laravel\Facade\Flasher;

class QuestionsCategotryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['questionCategories'] = QuestionsCategotry::paginate(20);
        $data['teachers'] = Teacher::all();

        return view('pages.Manager.StudyContent.QuestionsBank.QuestionCategory.index', $data);
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
        $request->validate([
            'questions_bank_id' => 'required|exists:questions_banks,id',
            'title' => 'required|string',
            'QBank' => 'exists:questions_banks,id'
        ]);

        try {

            $QCategory = new QuestionsCategotry();

            $QCategory->title = $request->post('title');
            $QCategory->questions_bank_id = $request->post('questions_bank_id');

            $QCategory->save();



            Flasher::addSuccess(trans('main_trans.success'));
            return redirect()->back();
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionsCategotry  $questionsCategotry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'questions_bank_id' => 'required|exists:questions_banks,id',
            'title' => 'required|string',
            'QBank' => 'exists:questions_banks,id'
        ]);

        try {

            $QCategory = QuestionsCategotry::findOrFail($id);

            $QCategory->title = $request->post('title');
            $QCategory->questions_bank_id = $request->post('questions_bank_id');

            $QCategory->save();



            Flasher::addSuccess(trans('main_trans.success'));
            return redirect()->back();
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
    public function destroy($id)
    {
        try {
            $QCategory = QuestionsCategotry::findOrFail($id);
            $QCategory->delete();

            Flasher::addError(trans('main_trans.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
