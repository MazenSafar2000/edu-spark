<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Recorded_class;
use App\Models\Teacher_section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordedClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Recorded_class::get()->where('teacher_id', Auth::user()->teacher->id);
        return view("pages.Teacher.recordedClasses.index", compact("classes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['grades'] = Grade::all();
        return view("pages.Teacher.recordedClasses.create", $data);
    }

    // this functoin for section study content page
    public function createNew($id)
    {
        $teacher_section = Teacher_section::findOrFail($id);

        return view("pages.Teacher.sections.createRecorded", compact('teacher_section'));
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
            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
        ]);

        try {
            $recordedClass = Recorded_class::create([
                'teacher_id' => Auth::user()->teacher->id,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
                'subject_id' => $request->subject_id,
                'title' => $request->title,
                'description' => $request->description,
                'video_url' => $request->video_url,
                'created_by_teacher_id' => Auth::user()->teacher->id,
            ]);

            // $students = Student::where('grade_id', $request->grade_id)
            //     ->where('classroom_id', $request->classroom_id)
            //     ->where('section_id', $request->section_id)
            //     ->get();

            // $recordedClassId = $recordedClass->id;

            // foreach ($students as $student) {
            //     $student->notify(new NewRecordedClassAdded($recordedClassId, $request->title, auth()->user()->Name));
            // }

            toastr()->success(trans('messages.success'));
            return redirect()->route('recordedClasses.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recorded_class  $recorded_class
     * @return \Illuminate\Http\Response
     */
    public function show(Recorded_class $recorded_class)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recorded_class  $recorded_class
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class = Recorded_class::findOrFail($id);

        $data['grades'] = Grade::all();
        return view("pages.Teacher.recordedClasses.edit", compact("class"), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recorded_class  $recorded_class
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
        ]);

        try {
            $recordedClass = Recorded_class::findOrFail($id);
            $recordedClass->update([
                'title' => $request->title,
                'description' => $request->description,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
                'subject_id' => $request->subject_id,
                'video_url' => $request->video_url,
            ]);

            toastr()->success(trans('messages.Update'));
            return redirect()->route('recordedClasses.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recorded_class  $recorded_class
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recordedClass = Recorded_class::findOrFail($id);
        $recordedClass->delete();

        toastr()->error('mesages.Delete');
        return redirect()->back();
    }
}
