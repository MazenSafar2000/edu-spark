<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Promotion;
use App\Models\Student;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\FlareClient\Flare;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotions = promotion::all();
        return view('pages.Manager.Students.Promotion.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Grades = Grade::all();
        return view('pages.Manager.Students.Promotion.create', compact('Grades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'Grade_id' => 'required|exists:grades,id',
            'Classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'academic_year' => 'required|string',

            'Grade_id_new' => 'required|exists:grades,id',
            'Classroom_id_new' => 'required|exists:classrooms,id',
            'section_id_new' => 'required|exists:sections,id',
            'academic_year_new' => 'required|string',
        ]);

        DB::beginTransaction();
        try {

            $students = Student::where('Grade_id', $request->Grade_id)->where('Classroom_id', $request->Classroom_id)->where('section_id', $request->section_id)->where('academic_year', $request->academic_year)->get();

            if ($students->count() < 1) {
                Flasher::addError(trans('main_trans.no_students'));
                return redirect()->back()->with('error_promotions', trans('main_trans.no_students'));
            }

            // update in table student
            foreach ($students as $student) {

                $ids = explode(',', $student->id);
                student::whereIn('id', $ids)
                    ->update([
                        'Grade_id' => $request->Grade_id_new,
                        'Classroom_id' => $request->Classroom_id_new,
                        'section_id' => $request->section_id_new,
                        'academic_year' => $request->academic_year_new,
                    ]);

                // insert in to promotions
                Promotion::updateOrCreate([
                    'student_id' => $student->id,
                    'from_grade' => $request->Grade_id,
                    'from_Classroom' => $request->Classroom_id,
                    'from_section' => $request->section_id,
                    'to_grade' => $request->Grade_id_new,
                    'to_Classroom' => $request->Classroom_id_new,
                    'to_section' => $request->section_id_new,
                    'academic_year' => $request->academic_year,
                    'academic_year_new' => $request->academic_year_new,
                ]);
            }
            DB::commit();
            Flasher::addSuccess(trans('main_trans.success'));
            return redirect()->route('Promotion.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotion $promotion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $Promotion = Promotion::findorfail($id);
            student::where('id', $Promotion->student_id)
                ->update([
                    'Grade_id' => $Promotion->from_grade,
                    'Classroom_id' => $Promotion->from_classroom,
                    'section_id' => $Promotion->from_section,
                    'academic_year' => $Promotion->academic_year,
                ]);

            Promotion::destroy($id);
            DB::commit();

            Flasher::addSuccess(trans('main_trans.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function rollbackSelected(Request $request)
    {
        $ids = explode(',', $request->promotion_ids);

        DB::beginTransaction();
        try {
            foreach ($ids as $id) {
                $promotion = Promotion::findOrFail($id);

                Student::where('id', $promotion->student_id)
                    ->update([
                        'Grade_id'      => $promotion->from_grade,
                        'Classroom_id'  => $promotion->from_classroom,
                        'section_id'    => $promotion->from_section,
                        'academic_year' => $promotion->academic_year,
                    ]);

                $promotion->delete();
            }

            DB::commit();
            Flasher::addSuccess(trans('main_trans.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
