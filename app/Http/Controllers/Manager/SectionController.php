<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Teacher_section;
use Illuminate\Http\Request;

class SectionController extends Controller
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

        $request->validate([
            'Name_Section_Ar' => 'required|string|max:255',
            'Name_Section_En' => 'required|string|max:255',
            'Class_id' => 'required|exists:classrooms,id',
        ]);

        try {

            Section::create([
                'Name_Section' => [
                    'ar' => $request->Name_Section_Ar,
                    'en' => $request->Name_Section_En,
                ],
                'Class_id' => $request->Class_id,
                'Status' => '1',
            ]);

            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Name_Section_Ar' => 'required|string|max:255',
            'Name_Section_En' => 'required|string|max:255',
            'Class_id' => 'required|exists:classrooms,id',
        ]);

        try {
            $section = Section::findOrFail($id);

            $section->update([
                'Name_Section' => [
                    'ar' => $request->Name_Section_Ar,
                    'en' => $request->Name_Section_En,
                ],
                'Class_id' => $request->Class_id,
            ]);

            if (isset($request->Status)) {
                $section->Status = 1;
            } else {
                $section->Status = 2;
            }
            $section->save();

            toastr()->success(trans('messages.Update'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Section::findOrFail($id)->delete();

            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function TeachersSection($id)
    {
        $section = Section::findOrFail($id);

        $allTeachers = Teacher::all();
        $sectionTeachers = Teacher_section::where('section_id', $id)->get();

        $data['subjects'] = Subject::all();
        $data['grades'] = Grade::all();
        $data['classrooms'] = Classroom::all();
        $data['sections'] = Section::all();

        return view('pages.Manager.Sections.teachersSection', compact('allTeachers', 'sectionTeachers', 'section', ),  $data);
    }

    public function StudentsSection($id)
    {
        $section = Section::findOrFail($id);
        $students = Student::where('section_id', $id)->get();

        return view('pages.Manager.Sections.studentsSection', compact('students', 'section'));
    }
}
