@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">{{ trans('Teacher_trans.add_new_quizz') }}</h3>
        <div class="title-underline"></div>

        <div class="container mt-4">
            <div class="card custom-form-card-teacher">
                <div class="card-body">
                    <form class="subject-form" action="{{ route('exams.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="Name_ar"
                                        class="form-control custom-input float-input @error('Name_ar') custom-input-error @enderror"
                                        placeholder=" " value="{{ old('Name_ar') }}" />
                                    <label for="Name_ar"
                                        class="float-label">{{ trans('Teacher_trans.quizz_name_ar') }}</label>
                                </div>
                                @error('Name_ar')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="Name_en"
                                        class="form-control custom-input float-input @error('Name_en') custom-input-error @enderror"
                                        i placeholder=" " value="{{ old('Name_en') }}" />
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.quizz_name_en') }}</label>
                                </div>
                                @error('Name_en')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="form-group-float position-relative ">
                                <textarea name="description"
                                    class="form-control custom-textarea float-input @error('description') custom-textarea-error @enderror" placeholder="">{{ old('description') }}</textarea>
                                <label for="description"
                                    class="float-label">{{ trans('Teacher_trans.instructions') }}</label>
                            </div>
                            @error('description')
                                <div class="error-message" id="error-bookNameArabic">
                                    <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_at" class="text-danger">{{ trans('main_trans.start_at') }}*</label>
                                <input type="datetime-local" name="start_at"
                                    class="form-control custom-input @error('start_at') custom-input-error @enderror"
                                    id="start_at" placeholder="{{ trans('main_trans.start_at') }}"
                                    value="{{ old('start_at') }}">
                                @error('start_at')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="" class="text-danger">{{ trans('main_trans.end_at') }}*</label>
                                <input type="datetime-local" name="end_at"
                                    class="form-control custom-input @error('end_at') custom-input-error @enderror"
                                    id="end_at" placeholder="{{ trans('main_trans.end_at') }}"
                                    value="{{ old('end_at') }}">
                                @error('start_at')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="number" name="duration"
                                        class="form-control custom-input float-input @error('duration') custom-input-error @enderror"
                                        id="" placeholder="" value="{{ old('duration') }}" />
                                    <label for="duration"
                                        class="float-label">{{ trans('Teacher_trans.duration_minute') }}*</label>
                                </div>
                                @error('duration')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="number" name="attempts"
                                        class="form-control custom-input float-input @error('attempts') custom-input-error @enderror"
                                        id="" placeholder="" value="{{ old('attempts') }}" />
                                    <label for="attempts"
                                        class="float-label">{{ trans('Teacher_trans.attempts') }}*</label>
                                </div>
                                @error('attempts')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="number" name="question_per_page"
                                        class="form-control custom-input float-input @error('question_per_page') custom-input-error @enderror"
                                        id="" placeholder="" value="{{ old('question_per_page') }}" />
                                    <label for="question_per_page"
                                        class="float-label">{{ trans('Teacher_trans.question_per_page') }}*</label>
                                </div>
                                @error('question_per_page')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="number" name="maximum_grade"
                                        class="form-control custom-input float-input @error('maximum_grade') custom-input-error @enderror"
                                        id="" placeholder="" value="{{ old('maximum_grade') }}" />
                                    <label for="maximum_grade"
                                        class="float-label">{{ trans('Teacher_trans.maximum_grade') }}*</label>
                                </div>
                                @error('maximum_grade')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <label for="subject_id"
                                        class="text-danger">{{ trans('Teacher_trans.subject') }}*</label>
                                    <select name="subject_id" id="subject-select"
                                        class="form-select custom-select @error('subject_id') custom-select-error @enderror">
                                        <option selected disabled>{{ trans('Teacher_trans.select_subject') }}</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}"
                                                {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->subject->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('subject_id')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn save-btn">{{ trans('Teacher_trans.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

