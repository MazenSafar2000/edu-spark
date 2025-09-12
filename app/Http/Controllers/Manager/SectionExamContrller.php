<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Section;
use App\Models\SectionExam;
use App\Models\Student;
use App\Models\User;
use App\Notifications\Parent\NewExamAdded as ParentNewExamAdded;
use App\Notifications\Student\NewExamAdded;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class SectionExamContrller extends Controller
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
        $validated = $request->validate([
            'section_id' => ['required', 'exists:sections,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'exam_ids'   => ['required', 'array'],
            'exam_ids.*' => ['exists:exams,id'],
        ]);

        $sectionId = (int) $validated['section_id'];
        $subjectId = (int) $validated['subject_id'];
        $examIds   = array_map('intval', $validated['exam_ids']);

        DB::beginTransaction();
        try {
            $section = Section::findOrFail($sectionId);

            // Find which exams are already linked *for this subject* (triple unique on pivot).
            $already = $section->exams()
                ->wherePivot('subject_id', $subjectId)
                ->pluck('exams.id')
                ->all();

            $newExamIds = array_values(array_diff($examIds, $already));

            // Attach only new ones with the subject on the pivot
            if (!empty($newExamIds)) {
                $attachData = [];
                foreach ($newExamIds as $id) {
                    $attachData[$id] = ['subject_id' => $subjectId];
                }
                $section->exams()->attach($attachData);
            }

            DB::commit();

            // Notify students in the section (optionally also filter by subject enrollment if you track that)
            if (!empty($newExamIds)) {
                $exams = Exam::whereIn('id', $newExamIds)->get();

                $usersQ = User::query()
                    ->whereHas('student', fn($q) => $q->where('section_id', $sectionId));

                // If you track per-student subject enrollment, also filter by subject:
                // $usersQ->whereHas('student.enrollments', fn($q) => $q->where('subject_id', $subjectId));

                $usersQ->chunkById(200, function ($users) use ($exams, $sectionId, $subjectId) {
                    foreach ($exams as $exam) {
                        Notification::send($users, new NewExamAdded($exam, $sectionId, $subjectId));
                    }
                });

                Student::with(['myparent.user'])
                    ->where('section_id', $sectionId)
                    ->chunkById(200, function ($children) use ($exams) {
                        foreach ($children as $child) {
                            $parentUser = optional($child->myparent)->user;
                            if (!$parentUser) continue;

                            foreach ($exams as $exam) {
                                $parentUser->notify(new ParentNewExamAdded($exam, $child));
                            }
                        }
                    });
            }

            Flasher::addSuccess(trans('messages.success'));
            return redirect()->route('teacher.section.materials', $request->section_id);
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
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
        //
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
            $exam = SectionExam::findOrFail($id);
            $exam->delete();

            Flasher::addError(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function toggleShowGrade(Request $request, SectionExam $exam)
    {
        // If checkbox is not sent, fallback to 0
        $exam->update([
            'show_answers' => $request->has('show_answers') ? 1 : 0,
        ]);

        Flasher::addSuccess(__('messages.Update'));
        return back();
    }
}
