<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class ClassroomController extends Controller
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
        $this->validate($request, [
            'Name_Class.ar' => 'required',
            'Name_Class.en' => 'required',
            'Grade_id' => 'required|exists:grades,id',
        ]);

        try {

            Classroom::create($request->all());

            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function edit(Classroom $classroom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classroom $classroom)
    {
        $this->validate($request, [
            'Name_Class.ar' => 'required',
            'Name_Class.en' => 'required',
            'Grade_id' => 'required|exists:grades,id',
        ]);

        try {

            $classroom->Name_Class = $request->input('Name_Class');
            $classroom->Grade_id = $request->input('Grade_id');
            $classroom->save();

            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $classroom = Classroom::findOrFail($id);

            if ($classroom->sections()->count() > 0) {
                return redirect()->back()->withErrors(['error' => 'لا يمكن حذف الصف لأنه يحتوي على أقسام مرتبطة.']);
            }

            $classroom->delete();
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    // public function delete_all(Request $request)
    // {
    //     $delete_all_id = explode(",", $request->delete_all_id);

    //     Classroom::whereIn('id', $delete_all_id)->Delete();
    //     toastr()->error(trans('messages.Delete'));
    //     return redirect()->route('Classrooms.index');
    // }


    public function Filter_Classes(Request $request)
    {
        $Grades = Grade::all();
        $Search = Classroom::select('*')->where('Grade_id', '=', $request->Grade_id)->get();
        // return view('pages.My_Classes.My_Classes', compact('Grades'))->withDetails($Search);
    }
}
