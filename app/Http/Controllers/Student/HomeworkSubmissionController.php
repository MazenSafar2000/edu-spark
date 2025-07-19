<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Homework;
use App\Models\Homework_submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeworkSubmissionController extends Controller
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
    public function create(Homework $homework)
    {
        $student = Auth::user()->student;

        $existing = Homework_submission::where('homework_id', $homework->id)
            ->where('student_id', $student->id)
            ->first();

        return view('pages.Student.homeworks.create', compact('homework', 'existing'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Homework $homework)
    {
        $request->validate([
            'submission_file' => 'required|file|mimes:pdf,doc,docx,zip,rar,png,jpg,jpeg|max:10240',
            'notes' => 'nullable|string',
        ]);

        $student = Auth::user()->student;
        $folderName = $student->National_ID;
        $fileName = time() . '_' . $request->file('submission_file')->getClientOriginalName();

        $existingSubmission = Homework_submission::where('student_id', $student->id)
            ->where('homework_id', $homework->id)
            ->first();

        // $filePath = $this->uploadStudentHomeworkFile($request, $studentName);
        $path = $request->file('submission_file')->storeAs(
            "attachments/homework_submissions/students/{$folderName}",
            $fileName,
            'public'
        );

        if ($existingSubmission) {
            if (!$homework->allow_multiple_submissions) {
                return back()->with('message', __('Students_trans.submission_already_done'));
            }

            // Delete old file
            Storage::disk('public')->delete("attachments/homework_submissions/students/{$folderName}/". $existingSubmission->file_path);

            // Update existing
            $existingSubmission->update([
                'file_path' => $fileName,
                'submitted_at' => now(),
                'status' => now()->gt($homework->due_date) ? 'late' : 'pending',
            ]);
        } else {
            Homework_submission::create([
                'homework_id' => $homework->id,
                'student_id' => $student->id,
                'file_path' => $fileName,
                'notes' => $request->notes,
                'submitted_at' => now(),
                'status' => now()->gt($homework->due_date) ? 'late' : 'pending',
            ]);
        }

        return redirect()->back()->with('success', __('Students_trans.submitted_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Homework_submission  $homework_submission
     * @return \Illuminate\Http\Response
     */
    public function show(Homework_submission $homework_submission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Homework_submission  $homework_submission
     * @return \Illuminate\Http\Response
     */
    public function edit(Homework_submission $homework_submission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Homework_submission  $homework_submission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Homework_submission $homework_submission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Homework_submission  $homework_submission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Homework_submission $homework_submission)
    {
        //
    }
}
