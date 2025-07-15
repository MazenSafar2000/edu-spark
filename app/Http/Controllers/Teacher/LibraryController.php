<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Library;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Teacher_section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\AttachFilesTrait;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{

    use AttachFilesTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Library::all();

        return view("pages.Teacher.library.index", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['Grades'] = Grade::all();

        return view("pages.Teacher.library.create", $data);
    }

    public function createNew($id)
    {
        $teacher_section = Teacher_section::findOrFail($id);

        return view("pages.Teacher.sections.createBook", compact('teacher_section'));
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
            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'file_name' => 'required|file|mimes:pdf,doc,docx,zip,ppt,pptx',

        ]);

        try {

            $Teacher = Auth::user();
            $file = $request->file('file_name');

            $fileName = time() . '_' . $file->getClientOriginalName();
            $folderName = $Teacher->teacher->National_ID;

            $library = Library::create([
                'title' => $request->title,
                'file_name' => $fileName,
                'teacher_id' => $Teacher->teacher->id,
                'Grade_id' => $request->grade_id,
                'Classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
                'subject_id' => $request->subject_id,
                'created_by_teacher_id' => $Teacher->teacher->id,
            ]);

            $file->storeAs(
                "attachments/library/teachers/{$folderName}",
                $fileName,
                'public' // disk name من config/filesystems.php
            );

            // $this->uploadFile($request, $folderName, $fileName);

            toastr()->success(trans('messages.success'));
            return redirect()->route('library.create');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function show(Library $library)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = library::findorFail($id);
        $data['Grades'] = Grade::all();

        return view('pages.Teacher.library.edit', compact('book'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file_name' => 'nullable|file|mimes:pdf,doc,docx,zip,ppt,pptx',
            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        try {
            $library = Library::findOrFail($id);
            $teacher = Auth::user()->teacher;

            if (!$teacher) {
                return redirect()->back()->with('error', 'Teacher not found.');
            }

            $folderName = $teacher->National_ID;

            $data = $request->only([
                'title',
                'grade_id',
                'classroom_id',
                'section_id',
                'subject_id',
            ]);

            $oldFile = $library->file_name;

            if ($request->hasFile('file_name')) {
                $file = $request->file('file_name');
                $fileName = time() . '_' . $file->getClientOriginalName();

                $file->storeAs("attachments/library/teachers/{$folderName}", $fileName, 'public');
                $data['file_name'] = $fileName;

                // Delete old file if different
                if ($oldFile && $oldFile !== $fileName) {
                    Storage::disk('public')->delete("attachments/library/teachers/{$folderName}/{$oldFile}");
                }
            }

            $library->update($data);

            toastr()->success(trans('messages.update'));
            return redirect()->route('library.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $library = Library::findOrFail($id);
            $library->delete();

            Storage::disk('public')->delete("attachments/library/teachers/{$library->teacher->National_ID}/{$library->file_name}");

            toastr()->success(trans('messages.delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
