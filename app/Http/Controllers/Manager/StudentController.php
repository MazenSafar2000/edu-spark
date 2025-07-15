<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Image;
use App\Models\ParentProfile;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        $grades = Grade::all();
        $classrooms = Classroom::all();
        $sections = Section::all();

        return view('pages.Manager.Students.index', compact('students', 'grades', 'classrooms', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['my_classes'] = Grade::all();
        $data['parents'] = ParentProfile::all();
        $data['Genders'] = Gender::all();
        $data['Grades'] = Grade::all();
        return view('pages.Manager.Students.create', $data, ['Student' => new Student()]);
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
            'email' => 'required|email|unique:users,email',
            'National_ID' => 'required|string|min:9|max:9|regex:/[0-9]{9}/',
            'password' => 'required|string|min:6',
            'gender_id' => 'required|exists:genders,id',
            'Date_Birth' => 'required|date',
            'Grade_id' => 'required|exists:grades,id',
            'Classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'parent_id' => 'required|exists:parents,id',
            'academic_year' => 'required|string',
        ]);

        try {
            // Create user
            $user = User::create([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Create student
            $studnet = Student::create([
                'user_id' => $user->id,
                'National_ID' => $request->National_ID,
                'gender_id' => $request->gender_id,
                'Date_Birth' => $request->Date_Birth,
                'Grade_id' => $request->Grade_id,
                'Classroom_id' => $request->Classroom_id,
                'section_id' => $request->section_id,
                'parent_id' => $request->parent_id,
                'academic_year' => $request->academic_year,
            ]);

            // insert img
            if ($request->hasfile('photos')) {
                foreach ($request->file('photos') as $file) {
                    $name = $file->getClientOriginalName();
                    $file->storeAs('attachments/students/' . $request->name_en, $file->getClientOriginalName(), 'upload_attachments');

                    // insert in image_table
                    $images = new Image();
                    $images->filename = $name;
                    $images->imageable_id = $studnet->id;
                    $images->imageable_type = 'App\Models\Student';
                    $images->save();
                }
            }
            DB::commit(); // insert data
            toastr()->success(trans('messages.success'));
            return redirect()->route('Students.create');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
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
        $Student = Student::findorfail($id);
        return view('pages.Manager.Students.show', compact('Student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Student =  Student::findOrFail($id);
        $data['my_classes'] = Grade::all();
        $data['parents'] = ParentProfile::all();
        $data['Genders'] = Gender::all();
        $data['Grades'] = Grade::all();
        return view('pages.Manager.Students.edit', $data, compact('Student'));
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
            'email' => 'required|email|unique:users,email',
            'National_ID' => 'required|string|min:9|max:9|regex:/[0-9]{9}/',
            'password' => 'required|string|min:6',
            'gender_id' => 'required|exists:genders,id',
            'Date_Birth' => 'required|date',
            'Grade_id' => 'required|exists:grades,id',
            'Classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'parent_id' => 'required|exists:parents,id',
            'academic_year' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $student = Student::findOrFail($id);

            $user = $student->user;
            $user->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            $student->National_ID = $request->National_ID;
            $student->gender_id = $request->gender_id;
            $student->Date_Birth = $request->Date_Birth;
            $student->Grade_id = $request->Grade_id;
            $student->Classroom_id = $request->Classroom_id;
            $student->section_id = $request->section_id;
            $student->parent_id = $request->parent_id;
            $student->academic_year = $request->academic_year;
            $student->save();

            DB::commit();

            toastr()->success(trans('messages.Update'));
            return redirect()->route('Students.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;
        $student->delete();

        if ($user) {
            $user->delete(); // Deletes the associated user record
        }
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Students.index');
    }


    public function Get_classrooms($id)
    {

        $list_classes = Classroom::where("Grade_id", $id)->pluck("Name_Class", "id");
        return $list_classes;
    }

    //Get Sections
    public function Get_Sections($id)
    {

        $list_sections = Section::where("Class_id", $id)->pluck("Name_Section", "id");
        return $list_sections;
    }

    public function Upload_attachment($request)
    {
        foreach ($request->file('photos') as $file) {
            $name = $file->getClientOriginalName();
            $file->storeAs('attachments/students/' . $request->student_name, $file->getClientOriginalName(), 'upload_attachments');

            // insert in image_table
            $images = new image();
            $images->filename = $name;
            $images->imageable_id = $request->student_id;
            $images->imageable_type = 'App\Models\Student';
            $images->save();
        }
        toastr()->success(trans('messages.success'));
        return redirect()->route('Students.show', $request->student_id);
    }



    public function Delete_attachment($request)
    {
        // Delete img in server disk
        Storage::disk('upload_attachments')->delete('attachments/students/' . $request->student_name . '/' . $request->filename);

        // Delete in data
        image::where('id', $request->id)->where('filename', $request->filename)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Students.show', $request->student_id);
    }
}
