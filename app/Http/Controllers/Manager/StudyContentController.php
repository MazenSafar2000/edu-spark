<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\Homework;
use App\Models\Library;
use App\Models\Online_class;
use App\Models\Recorded_class;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StudyContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     // For books tab
    //     $booksQuery = Library::query();
    //     if ($request->active_tab == 'books') {
    //         if ($request->filled('grade_id')) $booksQuery->where('Grade_id', $request->grade_id);
    //         if ($request->filled('classroom_id')) $booksQuery->where('Classroom_id', $request->classroom_id);
    //         if ($request->filled('section_id')) $booksQuery->where('section_id', $request->section_id);
    //         if ($request->filled('teacher_id')) $booksQuery->where('teacher_id', $request->teacher_id);
    //         if ($request->filled('subject_id')) $booksQuery->where('subject_id', $request->subject_id);
    //     }
    //     $books = $booksQuery->paginate(20)->appends($request->query());

    //     // Repeat same pattern for homeworks
    //     $homeworksQuery = Homework::query();
    //     if ($request->active_tab == 'homeworks') {
    //         if ($request->filled('grade_id')) $homeworksQuery->where('Grade_id', $request->grade_id);
    //         if ($request->filled('classroom_id')) $homeworksQuery->where('Classroom_id', $request->classroom_id);
    //         if ($request->filled('section_id')) $homeworksQuery->where('section_id', $request->section_id);
    //         if ($request->filled('teacher_id')) $homeworksQuery->where('teacher_id', $request->teacher_id);
    //         if ($request->filled('subject_id')) $homeworksQuery->where('subject_id', $request->subject_id);
    //     }
    //     $homeworks = $homeworksQuery->paginate(20)->appends($request->query());

    //     // Repeat for exams
    //     $examsQuery = Exam::query();
    //     if ($request->active_tab == 'exams') {
    //         if ($request->filled('grade_id')) $examsQuery->where('Grade_id', $request->grade_id);
    //         if ($request->filled('classroom_id')) $examsQuery->where('Classroom_id', $request->classroom_id);
    //         if ($request->filled('section_id')) $examsQuery->where('section_id', $request->section_id);
    //         if ($request->filled('teacher_id')) $examsQuery->where('teacher_id', $request->teacher_id);
    //         if ($request->filled('subject_id')) $examsQuery->where('subject_id', $request->subject_id);
    //     }
    //     $exams = $examsQuery->paginate(20)->appends($request->query());

    //     // Recorded classes
    //     $recordedClassesQuery = Recorded_class::query();
    //     if ($request->active_tab == 'lessons') {
    //         if ($request->filled('grade_id')) $recordedClassesQuery->where('grade_id', $request->grade_id);
    //         if ($request->filled('classroom_id')) $recordedClassesQuery->where('classroom_id', $request->classroom_id);
    //         if ($request->filled('section_id')) $recordedClassesQuery->where('section_id', $request->section_id);
    //         if ($request->filled('teacher_id')) $recordedClassesQuery->where('teacher_id', $request->teacher_id);
    //         if ($request->filled('subject_id')) $recordedClassesQuery->where('subject_id', $request->subject_id);
    //     }
    //     $recordedClasses = $recordedClassesQuery->paginate(20)->appends($request->query());

    //     // Zoom classes
    //     $zoomClassesQuery = Online_class::query();
    //     if ($request->active_tab == 'zoom') {
    //         if ($request->filled('grade_id')) $zoomClassesQuery->where('grade_id', $request->grade_id);
    //         if ($request->filled('classroom_id')) $zoomClassesQuery->where('Classroom_id', $request->classroom_id);
    //         if ($request->filled('section_id')) $zoomClassesQuery->where('section_id', $request->section_id);
    //         if ($request->filled('teacher_id')) $zoomClassesQuery->where('teacher_id', $request->teacher_id);
    //         if ($request->filled('subject_id')) $zoomClassesQuery->where('subject_id', $request->subject_id);
    //     }
    //     $zoomClasses = $zoomClassesQuery->paginate(20)->appends($request->query());

    //     $grades = Grade::all();
    //     $classrooms = Classroom::all();
    //     $sections = Section::all();
    //     $teachers = Teacher::with('user')->get();
    //     $subjects = Subject::all();

    //     return view('pages.Manager.StudyContent.index', compact(
    //         'books',
    //         'homeworks',
    //         'exams',
    //         'recordedClasses',
    //         'zoomClasses',
    //         'grades',
    //         'classrooms',
    //         'sections',
    //         'teachers',
    //         'subjects'
    //     ));
    // }

    public function index()
    {
        $data['books'] = Library::paginate(20);
        $data['homeworks'] = Homework::paginate(20);
        $data['exams'] = Exam::paginate(20);
        $data['recordedClasses'] = Recorded_class::paginate(20);
        $data['zoomClasses'] = Online_class::paginate(20);
        return view('pages.Manager.StudyContent.index', $data);
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
        //
    }
}
