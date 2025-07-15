<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Models\Specialization;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Teachers = Teacher::all();
        $Specializations = Specialization::all();
        return view('pages.Manager.Teachers.index', compact('Teachers', 'Specializations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specializations = Specialization::all();
        $genders = Gender::all();
        return view('pages.Manager.Teachers.create', compact('specializations', 'genders'), ['Teacher' => new Teacher()]);
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
            'Name_ar' => 'required|string|max:255',
            'Name_en' => 'required|string|max:255',
            'National_ID' => 'required|string|min:9|max:9|regex:/[0-9]{9}/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'Gender_id' => 'required|exists:genders,id',
            'Specialization_id' => 'required|exists:specializations,id',
            'Joining_Date' => 'required|date',
            'Address' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            // 1. Create user
            $user = User::create([
                'name' => [
                    'ar' => $request->Name_ar,
                    'en' => $request->Name_en
                ],
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'teacher', // if you're using role column
            ]);

            // 2. Create teacher profile
            Teacher::create([
                'user_id' => $user->id,
                'National_ID' => $request->National_ID,
                'Gender_id' => $request->Gender_id,
                'Specialization_id' => $request->Specialization_id,
                'Joining_Date' => $request->Joining_Date,
                'Address' => $request->Address,
            ]);

            DB::commit();

            toastr()->success(trans('messages.success'));
            return redirect()->route('Teachers.index');
        } catch (\Exception $e) {
            DB::rollBack();
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
        $Teacher = Teacher::findOrfail($id);
        $genders = Gender::all();
        $specializations = Specialization::all();

        return view('pages.Manager.Teachers.edit', compact('Teacher', 'genders', 'specializations'));
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
        try {

            // dd($request->all());

            DB::beginTransaction();

            $teacher = Teacher::findOrFail($id);

            // Update user data
            $user = $teacher->user;
            $user->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // Update teacher data
            $teacher->National_ID = $request->National_ID;
            $teacher->Gender_id = $request->Gender_id;
            $teacher->Specialization_id = $request->Specialization_id;
            $teacher->Joining_Date = $request->Joining_Date;
            $teacher->Address = $request->Address;
            $teacher->save();

            DB::commit();

            toastr()->success(__('messages.Update'));
            return redirect()->route('Teachers.index');
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
        $teacher = Teacher::findOrFail($id);
        $user = $teacher->user;
        $teacher->delete();

        if ($user) {
            $user->delete(); // Deletes the associated user record
        }

        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Teachers.index');
    }

    public function TeacherClasses($id)
    {
        $teacher = Teacher::findOrFail($id);
        $classes = $teacher->Sections;

        return view('pages.Manager.Teachers.teacherClasses', compact('teacher', 'classes'));
    }
}
