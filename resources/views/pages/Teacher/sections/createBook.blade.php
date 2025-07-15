@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <!-- المحتوى الرئيسي -->
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">{{ trans('Teacher_trans.add_new_book') }}</h3>

        <div class="container mt-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card custom-form-card-teacher">
                <div class="card-body">
                    <form class="subject-form" action="{{ route('library.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="section_id" value="{{ $teacher_section->section_id }}">
                        <input type="hidden" name="classroom_id" value="{{ $teacher_section->section->My_classs->id }}">
                        <input type="hidden" name="grade_id"
                            value="{{ $teacher_section->section->My_classs->Grades->id }}">
                        <input type="hidden" name="subject_id" value="{{ $teacher_section->subject_id }}">

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="title" id="title_id"
                                        class="form-control custom-input float-input" value="{{ old('title') }}" />
                                    <label for="title_id"
                                        class="float-label">{{ trans('Teacher_trans.book_name') }}*</label>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('main_trans.Grade') }}*</label>
                                <select class="form-select custom-select" name="grade_id" id="grade-select">
                                    <option selected disabled>{{ trans('Sections_trans.Select_Grade') }}</option>
                                    @foreach ($Grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->Name }}</option>
                                    @endforeach
                                </select>
                                @error('grade_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('main_trans.classroom') }}*</label>
                                <select class="form-select custom-select" name="classroom_id" id="classroom-select">
                                    <option disabled>{{ trans('Teacher_trans.select_class') }}</option>
                                </select>
                                @error('classroom_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('main_trans.section') }}*</label>
                                <select class="form-select custom-select" name="section_id" id="section-select">
                                    <option disabled selected>{{ trans('Teacher_trans.select_section') }}</option>
                                </select>
                                @error('section_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="">
                                <div class="form-group">
                                    <label for="subject_id">{{ trans('Students_trans.subjects') }} : <span
                                            class="text-danger">*</span></label>
                                    <select class="custom-select mr-sm-2" name="subject_id" id="subject-select">
                                        <option disabled selected>{{ trans('Teacher_trans.select_subject') }}</option>
                                    </select>
                                    @error('subject_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="" class="text-danger">{{ trans('Parent_trans.Attachments') }} *</label>
                                <input type="file" accept="application/pdf" name="file_name"
                                    class="form-control custom-input" id="file_name">
                                @error('file_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn save-btn">{{ trans('Grades_trans.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
