@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">{{ trans('Teacher_trans.newQuestionCategory') }}</h3>

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
                    <form class="subject-form" action="{{ route('questionsCategotry.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="form-group-float position-relative ">
                                <input type="text" name="title" class="form-control custom-input float-input"
                                    id="title" placeholder=" " />
                                @error(' ')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <label for="title"
                                    class="float-label">{{ trans('Teacher_trans.homework_title') }}*</label>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit"
                                class="btn save-btn">{{ trans('Teacher_trans.Create_Homework') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

