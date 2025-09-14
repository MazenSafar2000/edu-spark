<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Graduate;
use App\Models\Student;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraduatedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $graduates = Graduate::paginate(20);
        $grades = Grade::all();
        return view('pages.manager.students.Graduate.index', compact('graduates', 'grades'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:255',
        ]);

        $graduate = Graduate::findOrFail($id);
        $graduate->update([
            'reason' => $request->reason,
        ]);

        Flasher::addSuccess(trans('messages.update'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $graduate = Graduate::findOrFail($id);
            $graduate->delete();

            Flasher::addSuccess(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function graduateOne(Request $request, $studentId)
    {
        DB::beginTransaction();

        try {
            $student = Student::findOrFail($studentId);

            // Insert into graduates
            $graduate = Graduate::create([
                'student_id'    => $student->id,
                'user_id'       => $student->user_id,
                'name'          => [
                    'en' => $student->user->getTranslation('name', 'en'),
                    'ar' => $student->user->getTranslation('name', 'ar')
                ],
                'email'         => $student->user->email,
                'National_ID'   => $student->user->National_ID,
                'parent_name'   => [
                    'en' => $student->myparent->user->getTranslation('name', 'en'),
                    'ar' => $student->myparent->user->getTranslation('name', 'ar')
                ],
                'grade'         => [
                    'en' => $student->grade->getTranslation('Name', 'en'),
                    'ar' => $student->grade->getTranslation('Name', 'ar')
                ],
                'classroom'     => [
                    'en' => $student->classroom->getTranslation('Name_Class', 'en'),
                    'ar' => $student->classroom->getTranslation('Name_Class', 'ar')
                ],
                'section'       => [
                    'en' => $student->section->getTranslation('Name_Section', 'en'),
                    'ar' => $student->section->getTranslation('Name_Section', 'ar')
                ],
                'academic_year' => $student->academic_year,
                'Date_Birth'    => $student->Date_Birth,
                'graduated_at'  => now()->toDateString(),
                'reason'        => 'Completed School',
            ]);

            // Soft delete student
            $student->delete();

            DB::commit();
            Flasher::addSuccess(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
