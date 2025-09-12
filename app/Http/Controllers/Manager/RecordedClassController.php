<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Recorded_class;
use App\Models\Teacher;
use App\Models\Teacher_section;
use App\Models\User;
use App\Notifications\Student\NewRecordedClassAdded;
use App\Notifications\Teacher\NewRecordedClassAdded as TeacherNewRecordedClassAdded;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class RecordedClassController extends Controller
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
        return view("pages.Manager.StudyContent.recordedClasses.create", $data);
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
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        try {

            $teacher = Teacher::findOrFail($request->teacher_id);

            $recordedClass = Recorded_class::create([
                'teacher_id' => $teacher->id,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
                'subject_id' => $request->subject_id,
                'title' => $request->title,
                'description' => $request->description,
                'video_url' => $request->video_url,
                // 'created_by_teacher_id' => $teacher->id,
            ]);

            $usersQ = User::query()
                ->whereHas('student', function ($q) use ($recordedClass) {
                    $q->where('section_id', $recordedClass->section_id);
                });

            $usersQ->chunkById(200, function ($users) use ($recordedClass) {
                Notification::send($users, new NewRecordedClassAdded($recordedClass));
            });

            // Notify the teacher
            $teacherUser = User::whereHas('teacher', function ($q) use ($recordedClass) {
                $q->where('id', $recordedClass->teacher_id);
            })->first();

            Notification::send($teacherUser, new TeacherNewRecordedClassAdded($recordedClass));

            Flasher::addSuccess(trans('messages.success'));

            return redirect()->route('StudyContent.index');
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
        return view("pages.Manager.StudyContent.recordedClasses.edit", compact("class"), $data);
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
            'teacher_id' => 'required|exists:teachers,id',
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
                'teacher_id' => $request->teacher_id,
            ]);

            Flasher::addSuccess(trans('messages.Update'));
            return redirect()->route('StudyContent.index');
        } catch (\Exception $e) {
            Flasher::addError($e->getMessage());
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

        Flasher::addError(trans('messages.Delete'));
        return redirect()->back();
    }
}
