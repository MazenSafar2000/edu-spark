<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Support\Facades\Response;

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
            'student_national_id' => 'required',
        ]);

        try {
            foreach ($request->file('photos') as $file) {
                $name = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('attachments/students/' . $request->student_national_id, $name, 'public');

                Image::create([
                    'filename'        => $name,
                    'imageable_id'    => $request->student_id,
                    'imageable_type'  => 'App\Models\Student',
                ]);
            }

            Flasher::addSuccess(trans('messages.success'));
            return back();
        } catch (\Exception $e) {
            Flasher::addError($e->getMessage());
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
        $image = Image::findOrFail($id);
        $studentNational_ID = $image->imageable->National_ID;

        $filePath = 'attachments/students/' . $studentNational_ID . '/' . $image->filename;

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $image->delete();

        Flasher::addError(trans('messages.Delete'));
        return redirect()->back();
    }



    public function Download_attachment($studentNationalId, $filename)
    {
        $filePath = 'attachments/students/' . $studentNationalId . '/' . $filename;

        if (Storage::disk('public')->exists($filePath)) {
            $absolutePath = Storage::disk('public')->path($filePath);
            return Response::download($absolutePath);
        }
        
        return response()->download(public_path('attachments/students/' . $studentNationalId . '/' . $filename));
    }
}
