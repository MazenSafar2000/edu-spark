<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Exports\HomeworkSubmissionsExport;
use App\Models\Grade;
use App\Models\Homework;
use App\Models\Homework_submission;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Teacher_section;
use App\Models\User;
use App\Notifications\Parent\NewHomeworkAdded as ParentNewHomeworkAdded;
use App\Notifications\Student\NewHomeworkAdded;
use App\Notifications\Teacher\NewHomeworkAdded as TeacherNewHomeworkAdded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Support\Facades\Notification;;

class HomeworkController extends Controller
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
        return view("pages.Manager.StudyContent.homework.create", $data);
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
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        try {

            $teacher = Teacher::findOrFail($request->teacher_id);

            $homework = Homework::create([
                'teacher_id' => $teacher->id,
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
                'teacher_id' => $request->teacher_id,
                // 'created_by_teacher_id' => Auth::user()->teacher->id,
            ]);


            if ($request->hasFile('attachment')) {
                $folderName = $teacher->user->National_ID;
                dd($folderName);
                $fileName = time() . '_' . $request->file('attachment')->getClientOriginalName();

                $path = $request->file('attachment')->storeAs(
                    "attachments/homeworks/teachers/{$folderName}",
                    $fileName,
                    'public'
                );

                $homework->update(['attachment_path' => $fileName]);
            }

            // student notify
            $usersQ = User::query()
                ->whereHas('student', function ($q) use ($homework) {
                    $q->where('section_id', $homework->section_id);
                });

            $usersQ->chunkById(200, function ($users) use ($homework) {
                Notification::send($users, new NewHomeworkAdded($homework));
            });

            // parent notify
            Student::with(['myparent.user'])
                ->where('grade_id', $homework->grade_id)
                ->where('classroom_id', $homework->classroom_id)
                ->where('section_id', $homework->section_id)
                ->chunkById(200, function ($children) use ($homework) {
                    foreach ($children as $child) {
                        $parentUser = optional($child->myparent)->user;
                        if ($parentUser) {
                            $parentUser->notify(new ParentNewHomeworkAdded($homework, $child));
                        }
                    }
                });

            // Notify the teacher
            $teacherUser = User::whereHas('teacher', function ($q) use ($homework) {
                $q->where('id', $homework->teacher_id);
            })->first();

            Notification::send($teacherUser, new TeacherNewHomeworkAdded($homework));


            Flasher::addSuccess(trans('main_trans.success'));
            return redirect()->route('StudyContent.index');
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

        return view('pages.Manager.StudyContent.homework.edit', compact('homework'), $data);
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
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        try {

            $homework = Homework::findOrFail($id);
            $teacher = Teacher::findOrFail($homework->teacher_id);

            $homework->update([
                'title' => $request->title,
                'description' => $request->description,
                'total_degree' => $request->total_degree,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
                'subject_id' => $request->subject_id,
                'teacher_id' => $request->teacher_id,
                'allowed_file_types' => $request->allowed_file_types,
                'allow_multiple_submissions' => $request->has('allow_multiple_submissions') ? true : false,
                'due_date' => $request->due_date,
            ]);

            if ($request->has('remove_attachment') && $homework->attachment_path) {
                Storage::disk('public')->delete('attachments/homeworks/teachers/' . $teacher->user->National_ID . '/' . $homework->attachment_path);
                $homework->update(['attachment_path' => null]);
            }

            if ($request->hasFile('attachment')) {
                // Delete old file first
                if ($homework->attachment_path) {
                    Storage::disk('public')->delete('attachments/homeworks/teachers/' . $teacher->user->National_ID . '/' . $homework->attachment_path);
                }

                $folderName = $teacher->user->National_ID;
                $fileName = time() . '_' . $request->file('attachment')->getClientOriginalName();

                $path = $request->file('attachment')->storeAs(
                    "attachments/homeworks/teachers/{$folderName}",
                    $fileName,
                    'public'
                );

                $homework->update(['attachment_path' => $fileName]);
            }

            Flasher::addSuccess(trans('main_trans.Update'));
            return redirect()->route('StudyContent.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            Flasher::addError($e->getMessage());
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
        $teacher = $homework->teacher;

        if ($homework->attachment_path) {
            Storage::disk('public')->delete('attachments/homeworks/teachers/' . $teacher->user->National_ID . '/' . $homework->attachment_path);
        }

        $homework->delete();

        Flasher::addError(trans('main_trans.Delete'));
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
            ->paginate(10);



        return view('pages.Manager.StudyContent.homework.submissions', compact('homework', 'students'));
    }

    public function gradeStudent(Request $request, Homework $homework, Student $student)
    {
        $request->validate([
            'degree'   => 'required|integer|min:0|max:' . $homework->total_degree,
            'feedback' => 'nullable|string',
        ]);

        try {
            $submission = Homework_submission::firstOrCreate(
                [
                    'homework_id' => $homework->id,
                    'student_id'  => $student->id,
                ],
                [
                    'submitted_at'     => null,
                    'file_path'        => null,
                    'delivery_status'  => 'notSubmitted',
                    'evaluation_status' => 'notEvaluated',
                ]
            );

            $submission->update([
                'degree'            => $request->degree,
                'feedback'          => $request->feedback,
                'evaluation_status' => 'evaluated',
            ]);

            Flasher::addSuccess(trans('main_trans.Update'));
            return back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function export($homeworkId)
    {
        $homework = Homework::findOrFail($homeworkId);

        return Excel::download(new HomeworkSubmissionsExport($homeworkId), "Homework_{$homework->title}_Submissions.xlsx");
    }

    public function assignZeroForAbsentStudents(Homework $homework)
    {
        // Get all student IDs in this homework's section
        $studentIds = $homework->section->students()->pluck('id');

        // Get IDs of students who already have a submission
        $submittedIds = $homework->submissions()->pluck('student_id');

        // Find students without any submission record
        $studentsWithoutSubmission = $studentIds->diff($submittedIds);

        foreach ($studentsWithoutSubmission as $studentId) {
            $homework->submissions()->create([
                'student_id'        => $studentId,
                'degree'            => 0,
                'feedback'          => 'لم يتم التسليم',
                'delivery_status'   => 'notSubmitted',
                'evaluation_status' => 'evaluated',
                'submitted_at'      => null,
                'file_path'         => null,
            ]);
        }

        Flasher::addSuccess(trans('main_trans.Update'));
        return back();
    }

    public function toggleShowGrade(Request $request, Homework $homework)
    {
        // If checkbox is not sent, fallback to 0
        $homework->update([
            'show_grade' => $request->has('show_grade') ? 1 : 0,
        ]);

        Flasher::addSuccess(__('main_trans.Update'));
        return back();
    }
}
