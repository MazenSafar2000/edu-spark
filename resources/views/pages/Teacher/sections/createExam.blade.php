@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">{{ trans('Teacher_trans.add_new_quizz') }}</h3>

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
                    <form class="subject-form" action="{{ route('exams.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="section_id" value="{{ $teacher_section->section_id }}">
                        <input type="hidden" name="classroom_id" value="{{ $teacher_section->section->My_classs->id }}">
                        <input type="hidden" name="grade_id"
                            value="{{ $teacher_section->section->My_classs->Grades->id }}">
                        <input type="hidden" name="subject_id" value="{{ $teacher_section->subject_id }}">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="Name_ar" class="form-control custom-input float-input"
                                        id="" placeholder=" " />
                                    @error('Name_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.quizz_name_ar') }}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="Name_en" class="form-control custom-input float-input"
                                        id="" placeholder=" " />
                                    @error('Name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.quizz_name_en') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <input type="number" name="duration" class="form-control custom-input float-input" />
                                    <label for="duration"
                                        class="float-label">{{ trans('Teacher_trans.duration_minute') }}</label>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_at" class="text-danger">{{ trans('main_trans.start_at') }}*</label>
                                <input type="datetime-local" name="start_at" class="form-control custom-input"
                                    id="start_at" placeholder="{{ trans('main_trans.start_at') }}">
                                @error('start_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="" class="text-danger">{{ trans('main_trans.end_at') }}*</label>
                                <input type="datetime-local" name="end_at" class="form-control custom-input" id="end_at"
                                    placeholder="{{ trans('main_trans.end_at') }}">
                                @error('end_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn save-btn">{{ trans('Teacher_trans.save_data') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
