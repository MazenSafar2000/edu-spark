<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Section;
use App\Models\SectionExam;
use App\Models\Student;
use App\Notifications\Parent\NewExamAdded as ParentNewExamAdded;
use App\Notifications\Student\NewExamAdded;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class SectionExamContrller extends Controller
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
        // dd($request->all());
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_ids'   => 'required|array',
            'exam_ids.*' => 'exists:exams,id',
        ]);

        try {
            $section = Section::findOrFail($request->section_id);

            // تجهيز بيانات الربط مع subject_id
            $data = [];
            foreach ($request->exam_ids as $examId) {
                $data[$examId] = ['subject_id' => $request->subject_id];
            }

            // ربط الامتحانات مع الشعبة والمادة في الجدول الوسيط
            $section->exams()->syncWithoutDetaching($data);

            // $students = Student::where('grade_id', $request->Grade_id)
            //     ->where('classroom_id', $request->Classroom_id)
            //     ->where('section_id', $request->section_id)
            //     ->get();


            // $examTitle = $exam->getTranslation('name', app()->getLocale());

            // foreach ($students as $student) {
            //     $student->notify(new NewExamAdded($exam->id, $examTitle, Auth::user()->name));
            //     $student->myparent->notify(new ParentNewExamAdded($exam, $student));
            // }

            return back()->with('success', 'تم ربط الامتحانات بالشعبة بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $exam = SectionExam::findOrFail($id);
            $exam->delete();

            Flasher::addError(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function toggleShowGrade(Request $request, SectionExam $exam)
    {
        // If checkbox is not sent, fallback to 0
        $exam->update([
            'show_answers' => $request->has('show_answers') ? 1 : 0,
        ]);

        Flasher::addSuccess(__('messages.Update'));
        return back();
    }
}
