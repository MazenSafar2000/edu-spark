@extends('layouts.main.student_dashboard')
@section('student-content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <div class="container exam-preview-container">
            <div class="exam-preview-title text-center">
                <h4>
                    {{-- <span class="preview-title-text fw-bold">تسليم </span>
                    <span class="preview-title-highlight fw-bold">الواجب</span> --}}
                </h4>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('student.submissions.store', $homework->id) }}"
                enctype="multipart/form-data" class="mt-3">
                @csrf

                <div class="mb-3">
                    <label for="notes" class="form-label text-danger">{{ trans('main_trans.any_notes') }}*</label>
                    <textarea class="form-control textarea-notes" name="notes" rows="4" placeholder="{{ trans('main_trans.write_notes') }}"></textarea>
                </div>

                <!-- File Input -->
                <div class="mb-3">
                    <label for="submission_file"
                        class="form-label text-danger">({{ trans('Students_trans.Allowed_files_type') }}:
                        {{ implode(', ', $homework->allowed_file_types) }})</label>
                    <input class="form-control file-upload-custom @error('submission_file') is-invalid @enderror"
                        type="file" name="submission_file" id="fileUpload">
                    @error('submission_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if ($existing && !$homework->allow_multiple_submissions)
                    <div class="alert alert-warning">You already submitted this homework. Multiple
                        submissions are not allowed.</div>
                @endif

                <!-- Submit Button -->
                <button type="submit" class="btn btn-submit-custom">إرسال</button>
            </form>
        </div>

        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
