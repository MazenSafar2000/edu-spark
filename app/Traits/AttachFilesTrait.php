<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


trait AttachFilesTrait
{
    
    // public function uploadFile($request, $teacherName, $inputName)
    // {
    //     $file = $request->file($inputName);

    //     $file->storeAs(
    //         "attachments/library/teachers/{$teacherName}",
    //         $inputName,
    //         'upload_attachments' // disk name من config/filesystems.php
    //     );

    //     return $inputName; // نرجع اسم الملف عشان نحفظه بقاعدة البيانات
    // }

    public function deleteFile($teacherName, $fileName)
    {
        $teacherFolder = Str::slug($teacherName, '_');
        $filePath = "library/teachers/{$teacherFolder}/{$fileName}";

        if (Storage::disk('upload_attachments')->exists($filePath)) {
            Storage::disk('upload_attachments')->delete($filePath);
        }
    }

    // Homework File Upload and Delete For Teacher
    public function uploadHomeworkFile($request, $teacherName)
    {
        $file = $request->file('attachment');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = 'attachments/homework/teachers/' . $teacherName . '/' . $fileName;

        $file->storeAs('attachments/homework/teachers/' . $teacherName, $fileName, 'upload_attachments');

        return $path;
    }

    public function deleteHomeworkFile($path)
    {
        if (Storage::disk('upload_attachments')->exists($path)) {
            Storage::disk('upload_attachments')->delete($path);
        }
    }

    // Homework File Upload For Student
    public function uploadStudentHomeworkFile($request, $studentName)
    {
        $file = $request->file('submission_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = 'attachments/homework_submissions/students/' . $studentName . '/' . $fileName;

        $file->storeAs('attachments/homework_submissions/students/' . $studentName, $fileName, 'upload_attachments');

        return $path;
    }

    // Check if the student has already submitted the homework, and want to resubmit
    public function uploadHomeworkSubmissionFile($request, $studentName)
    {
        $file = $request->file('submission_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = 'attachments/homework_submissions/students/' . $studentName . '/' . $fileName;

        $file->storeAs('attachments/homework_submissions/students/' . $studentName, $fileName, 'upload_attachments');

        return $path;
    }

    public function deleteHomeworkSubmissionFile($path)
    {
        if (Storage::disk('upload_attachments')->exists($path)) {
            Storage::disk('upload_attachments')->delete($path);
        }
    }
}
