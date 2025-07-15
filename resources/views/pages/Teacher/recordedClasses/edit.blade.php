@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">{{ trans('Teacher_trans.Update_recordedClass') }}</h3>

        <div class="container mt-4">
            <div class="card custom-form-card-teacher">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="subject-form" action="{{ route('recordedClasses.update', $class->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="title" class="form-control custom-input float-input"
                                        value="{{ old('title', $class->title) }}" />
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.Class_title') }}</label>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="description" class="form-control custom-input float-input"
                                        value="{{ old('description', $class->description) }}" />
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.class_description_optional') }}</label>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('Students_trans.Grade') }}*</label>
                                <select class="form-select custom-select" name="grade_id" id="grade-select">
                                    <option selected disabled>{{ trans('Parent_trans.Choose') }}</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}"
                                            {{ $grade->id == $class->grade_id ? 'selected' : '' }}>
                                            {{ $grade->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('Students_trans.classrooms') }}*</label>
                                <select class="form-select custom-select" name="classroom_id" id="classroom-select">
                                    <option value="{{ $class->classroom_id }}">
                                        {{ $class->classroom->Name_Class }}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('Students_trans.section') }}*</label>
                                <select class="form-select custom-select" name="section_id" id="section-select">
                                    <option value="{{ $class->section_id }}">
                                        {{ $class->section->Name_Section }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="" class="text-danger">{{ trans('Students_trans.subjects') }}*</label>
                                <select class="form-select custom-select" name="subject_id" id="subject-select">
                                    <option value="{{ $class->subject_id }}">
                                        {{ $class->subject->name }}
                                    </option>
                                </select>
                            </div>


                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <input type="url" name="video_url" class="form-control custom-input float-input"
                                        placeholder=" "
                                        value="{{ old('video_url', $class->video_url) }}"/>
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.Class_link') }}</label>
                                </div>
                                <p>{{ trans('Teacher_trans.Class_link') }} <small>
                                        {{ trans('Teacher_trans.video_types') }}</small></p>
                            </div>

                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn save-btn">{{ trans('Grades_trans.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
