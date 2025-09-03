@extends('layouts.main.parent_dashboard')
@section('parent_content')
    <div class="parentContent">
        <div class="container mt-5">
            <div class="row g-4">
                <!-- بيانات الطالب -->
                <div class="col-md-6">
                    <div class="card custom-card-parent">
                        <div class="custom-card-header">{{ trans('Parent_trans.student_data') }}</div>
                        <div class="card-body">
                            <div class="row border-bottom p-3">
                                <div class="col-6 custom-label">{{ trans('Parent_trans.full_student_name') }}</div>
                                <div class="col-6">
                                    <div class="custom-field">{{ $student->user->name }}</div>
                                </div>
                            </div>
                            <div class="row border-bottom p-3">
                                <div class="col-6 custom-label">{{ trans('main_trans.National_ID') }}</div>
                                <div class="col-6">
                                    <div class="custom-field">{{ $student->National_ID }}</div>
                                </div>
                            </div>
                            <div class="row border-bottom p-3">
                                <div class="col-6 custom-label">{{ trans('main_trans.Grade') }}</div>
                                <div class="col-6">
                                    <div class="custom-field">{{ $student->grade->Name }}</div>
                                </div>
                            </div>
                            <div class="row border-bottom p-3">
                                <div class="col-6 custom-label">{{ trans('main_trans.classroom') }}</div>
                                <div class="col-6">
                                    <div class="custom-field">{{ $student->classroom->Name_Class }}</div>
                                </div>
                            </div>
                            <div class="row border-bottom p-3">
                                <div class="col-6 custom-label">{{ trans('main_trans.section') }}</div>
                                <div class="col-6">
                                    <div class="custom-field">{{ $student->section->Name_Section }}</div>
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-6 custom-label">{{ trans('Parent_trans.Phone_Father') }}</div>
                                <div class="col-6">
                                    <div class="custom-field">{{ $student->myparent->Phone_Father }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- المواد الدراسية -->
                <div class="col-md-6">
                    <div class="card custom-card-parent">
                        <div class="custom-card-header">{{ trans('main_trans.subjects') }}</div>
                        <div class="card-body">
                            @foreach ($subjects as $subject)
                                <div class="row align-items-center border-bottom p-3">
                                    <div class="col-6 custom-label">{{ $subject->subject->name }}</div>
                                    <div class="col-6"><a href="{{ route('subject.materials', [ 'subjectId' => $subject->id, 'studentId' => $studentId]) }}"
                                            class="btn custom-btn">{{ trans('main_trans.view') }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br><br>
@endsection
