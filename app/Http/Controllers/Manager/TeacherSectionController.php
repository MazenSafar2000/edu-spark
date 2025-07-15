<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Teacher_section;
use Illuminate\Http\Request;

class TeacherSectionController extends Controller
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
        try {
            $teacher_section = new Teacher_section();
            $teacher_section->teacher_id = $request->teacher_id;
            $teacher_section->subject_id = $request->subject_id;
            $teacher_section->section_id = $request->section_id;
            $teacher_section->save();

            return redirect()->back()->with('success');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher_section  $teacher_section
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher_section $teacher_section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher_section  $teacher_section
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher_section $teacher_section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher_section  $teacher_section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher_section $teacher_section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher_section  $teacher_section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher_section $teacher_section)
    {
        //
    }
}
