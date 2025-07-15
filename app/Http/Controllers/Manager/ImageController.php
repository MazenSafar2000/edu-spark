<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
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
        $request->validate([
            'photos'   => 'required',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'student_id' => 'required|exists:students,id',
            'student_name' => 'required|string',
        ]);

        try {
            foreach ($request->file('photos') as $file) {
                $name = $file->getClientOriginalName();
                $file->storeAs('attachments/students/' . $request->student_name, $name, 'upload_attachments');

                Image::create([
                    'filename'        => $name,
                    'imageable_id'    => $request->student_id,
                    'imageable_type'  => 'App\Models\Student',
                ]);
            }

            toastr()->success(trans('messages.success'));
            return back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image, $id)
    {
        try {
            // $image = Image::findOrFail($id)->delete();
            // toastr()->error(trans('messages.success'));

            $image = Image::findOrFail($id);
            $studentName = $image->imageable->user->name; // get student name
            $filePath = public_path('attachments/students/' . $studentName . '/' . $image->filename);

            if (file_exists($filePath)) {
                unlink($filePath); // delete from disk
            }

            $image->delete();

            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }


    public function Download_attachment($studentsname, $filename)
    {
        return response()->download(public_path('attachments/students/' . $studentsname . '/' . $filename));
    }
}
