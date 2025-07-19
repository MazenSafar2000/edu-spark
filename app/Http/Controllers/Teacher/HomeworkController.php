<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Homework;
use App\Models\Homework_submission;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher_section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homeworks = Homework::all()->where('teacher_id', auth()->user()->teacher->id);

        return view("pages.Teacher.homework.index", compact("homeworks"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['grades'] = Grade::all();
        return view("pages.Teacher.homework.create", $data);
    }

    // this functoin for section study content page
    public function createNew($id)
    {
        $teacher_section = Teacher_section::findOrFail($id);

        return view("pages.Teacher.sections.createHomework", compact('teacher_section'));
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
            'description' => 'nullable|string',
            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'total_degree' => 'required|numeric|min:0|max:100',
            'due_date' => 'required|date|after_or_equal:today',
            'allowed_file_types' => 'required|array',
            'allowed_file_types.*' => 'in:pdf,doc,docx,jpg,png,rar,zip',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip,rar|max:2048',
        ]);

        try {

            $homework = Homework::create([
                'teacher_id' => Auth::user()->teacher->id,
                'subject_id' => $request->subject_id,
                'title' => $request->title,
                'description' => $request->description,
                'total_degree' => $request->total_degree,
                'allowed_file_types' => $request->allowed_file_types,
                'allow_multiple_submissions' => $request->has('allow_multiple_submissions'),
                'due_date' => $request->due_date,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
                'created_by_teacher_id' => Auth::user()->teacher->id,
            ]);


            if ($request->hasFile('attachment')) {
                $folderName = Auth::user()->teacher->National_ID;
                $fileName = time() . '_' . $request->file('attachment')->getClientOriginalName();

                $path = $request->file('attachment')->storeAs(
                    "attachments/homeworks/teachers/{$folderName}",
                    $fileName,
                    'public'
                );

                $homework->update(['attachment_path' => $fileName]);
            }

            // $students = Student::where('grade_id', $request->grade_id)
            //     ->where('classroom_id', $request->classroom_id)
            //     ->where('section_id', $request->section_id)
            //     ->get();

            // foreach ($students as $student) {
            //     $student->notify(new NewHomeworkAdded($homework->id, $homework->title, auth()->user()->Name));
            //     $student->myparent->notify(new ParentNewHomeworkAdded($homework, $student));
            // }


            toastr()->success(trans('messages.success'));
            return redirect()->route('homeworks.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function show(Homework $homework)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $homework = Homework::findOrFail($id);
        $data['grades'] = Grade::all();
        // $data['subject'] = Subject::all();

        return view('pages.Teacher.homework.edit', compact('homework'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'total_degree' => 'required|numeric|min:0|max:100',
            'due_date' => 'required|date|after_or_equal:today',
            'allowed_file_types' => 'required|array',
            'allowed_file_types.*' => 'in:pdf,doc,docx,jpg,png,rar,zip',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip,rar|max:2048',
        ]);

        try {

            $homework = Homework::findOrFail($id);

            $homework->update([
                'subject_id' => $request->subject_id,
                'title' => $request->title,
                'description' => $request->description,
                'total_degree' => $request->total_degree,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
                'allowed_file_types' => $request->allowed_file_types,
                'allow_multiple_submissions' => $request->has('allow_multiple_submissions') ? true : false,
                'due_date' => $request->due_date,
            ]);

            if ($request->has('remove_attachment') && $homework->attachment_path) {
                Storage::disk('public')->delete('attachments/homeworks/teachers/' . Auth::user()->teacher->National_ID . '/' . $homework->attachment_path);
                $homework->update(['attachment_path' => null]);
            }

            if ($request->hasFile('attachment')) {
                // Delete old file first
                if ($homework->attachment_path) {
                    Storage::disk('public')->delete('attachments/homeworks/teachers/' . Auth::user()->teacher->National_ID . '/' . $homework->attachment_path);
                }

                $folderName = Auth::user()->teacher->National_ID;
                $fileName = time() . '_' . $request->file('attachment')->getClientOriginalName();

                $path = $request->file('attachment')->storeAs(
                    "attachments/homeworks/teachers/{$folderName}",
                    $fileName,
                    'public'
                );

                $homework->update(['attachment_path' => $fileName]);
            }

            toastr()->success(trans('messages.Update'));
            return redirect()->route('homeworks.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            toastr()->error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $homework = Homework::findOrFail($id);

        if ($homework->attachment_path) {
            Storage::disk('public')->delete('attachments/homeworks/teachers/' . Auth::user()->teacher->National_ID . '/' . $homework->attachment_path);
        }

        $homework->delete();

        toastr()->error(trans('messages.Delete'));
        return redirect()->back();
    }


    public function showSubmissions(Homework $homework)
    {
        // Get students in the same grade/class/section of the homework
        $students = Student::with(['submissions' => function ($q) use ($homework) {
            $q->where('homework_id', $homework->id);
        }])
            ->where('grade_id', $homework->grade_id)
            ->where('classroom_id', $homework->classroom_id)
            ->where('section_id', $homework->section_id)
            ->get();



        return view('pages.Teacher.homework.submissions', compact('homework', 'students'));
    }

    public function gradeStudent(Request $request, Homework $homework, Student $student)
    {
        $submission = Homework_submission::firstOrCreate([
            'homework_id' => $homework->id,
            'student_id' => $student->id,
        ], [
            'submitted_at' => now(), // default value in case it's a 0 grade
            'file_path' => null,
            'status' => 'graded'
        ]);

        $submission->update([
            'degree' => $request->degree,
            'feedback' => $request->feedback,
            'status' => 'graded',
        ]);

        toastr()->success(trans('messages.Update'));
        return back();
    }
}
