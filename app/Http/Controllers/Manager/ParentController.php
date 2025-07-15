<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Models\ParentProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parents = ParentProfile::all();

        return view('pages.Manager.Parents.index', compact('parents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.Manager.Parents.create', ['Parent' => new ParentProfile()]);
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
            'name_ar'        => 'required|string|max:255',
            'name_en'        => 'required|string|max:255',
            'National_ID' => 'required|string|min:9|max:9|regex:/[0-9]{9}/',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|string|min:6',
            'Job_Father.ar'  => 'required|string|max:255',
            'Job_Father.en'  => 'required|string|max:255',
            'Phone_Father'   => 'required|string|max:20',
            'Address_Father' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            // 1. Create the user
            $user = User::create([
                'name'     => ['ar' => $request->name_ar, 'en' => $request->name_en],
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'parent',
            ]);

            // 2. Create the parent profile
            ParentProfile::create([
                'user_id'        => $user->id,
                'National_ID'    => $request->National_ID,
                'Job_Father'     => $request->input('Job_Father'),
                'Phone_Father'   => $request->Phone_Father,
                'Address_Father' => $request->Address_Father,
            ]);

            DB::commit();

            toastr()->success(trans('messages.success'));
            return redirect()->route('Parents.index');
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
        $Parent = ParentProfile::findOrfail($id);

        return view('pages.Manager.Parents.edit', compact('Parent'));
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
        // 1. Get the parent profile and its user
        $parent = ParentProfile::findOrFail($id);
        $user = $parent->user;

        $request->validate([
            'name_ar'        => 'required|string|max:255',
            'name_en'        => 'required|string|max:255',
            'National_ID' => 'required|string|min:9|max:9|regex:/[0-9]{9}/',
            'email' => 'required|email|unique:users,email,' . $parent->user_id,
            'password'       => 'nullable|string|min:6',
            'Job_Father.ar'  => 'required|string|max:255',
            'Job_Father.en'  => 'required|string|max:255',
            'Phone_Father'   => 'required|string|max:20',
            'Address_Father' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {

            // 2. Update the user
            $user->name = [
                'ar' => $request->name_ar,
                'en' => $request->name_en
            ];
            $user->email = $request->email;

            // Update password only if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // 2. Create the parent profile
            $parent->update([
                'National_ID'    => $request->National_ID,
                'Phone_Father'   => $request->Phone_Father,
                'Job_Father'     => $request->input('Job_Father'),
                'Address_Father' => $request->Address_Father,
            ]);

            DB::commit();

            toastr()->info(trans('messages.update'));
            return redirect()->route('Parents.index');
        } catch (\Exception $e) {
            DB::rollBack();
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
        $parent = ParentProfile::findOrFail($id);
        $user = $parent->user;
        $parent->delete();

        if ($user) {
            $user->delete(); // Deletes the associated user record
        }
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Parents.index');
    }
}
