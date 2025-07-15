<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Grades = Grade::all();
        $Classes = Classroom::all();
        $Sections = Section::all();
        $teachers = Teacher::all();
        return view(
            'pages.Manager.Grades.index',
            compact('Grades', 'Classes', 'Sections', 'teachers',),
            [
                'Grade' => new Grade(),
                'Classroom' => new Classroom(),
                'Section' => new Section()
            ]
        );
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
            'Name.ar' => 'required|string|max:255',
            'Name.en' => 'required|string|max:255',
            'Notes'   => 'nullable|string|max:1000',
        ]);

        try {

            Grade::create($request->only('Name', 'Notes'));

            toastr()->success(trans('messages.success'));
            return redirect()->route('Grades.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit(Grade $grade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Name.ar' => 'required|string|max:255',
            'Name.en' => 'required|string|max:255',
            'Notes'   => 'nullable|string|max:1000',
        ]);

        try {

            $grade = Grade::findOrFail($id);
            $grade->update([
            'Name'  => $request->input('Name'),
            'Notes' => $request->input('Notes'),
        ]);

            toastr()->success(trans('messages.Update'));
            return redirect()->route('Grades.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hasClassrooms = Classroom::where('Grade_id', $id)->exists();

        if ($hasClassrooms) {
            toastr()->warning(trans('Grades_trans.delete_Grade_Error'));
            return redirect()->route('Grades.index');
        }

        Grade::findOrFail($id)->delete();

        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Grades.index');
    }
}
