@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <div class="container my-5">
            <div class="row g-4 cards-data-student">

                <!-- ✅ بطاقة بيانات الطالب -->
                <div class="col-lg-6">
                    <div class="card student-card shadow-sm h-100">
                        <div class="card-header student-card-header text-white fw-bold text-end d-flex align-items-center">
                            <i class="fas fa-user-graduate"></i>
                            <span>{{ trans('Students_trans.Student_details') }}</span>
                        </div>
                        <div class="card-body student-card-body">
                            <p class="student-info ">
                                <strong>{{ trans('Students_trans.name') }}:</strong>{{ $Student->user->name }} </p>
                            <p class="student-info "><strong>{{ trans('main_trans.National_ID') }}:</strong>
                                {{ $Student->National_ID }}</p>
                            <p class="student-info">
                                <strong>{{ trans('Teacher_trans.Gender') }}:</strong>{{ $Student->gender->Name }}</p>
                            <p class="student-info "><strong>{{ trans('main_trans.Grade') }} :</strong> {{ $Student->grade->Name }}</p>
                            <p class="student-info "><strong>{{ trans('main_trans.classroom') }} :</strong> {{ $Student->classroom->Name_Class }}</p>
                            <p class="student-info"><strong>{{ trans('main_trans.section') }} :</strong> {{ $Student->section->Name_Section }}</p>
                            <p class="student-info "><strong>{{ trans('main_trans.Date_of_Birth') }}:</strong> {{ $Student->Date_Birth }}</p>
                            <p class="student-info "><strong>{{ trans('main_trans.academic_year') }}:</strong>{{ $Student->academic_year }}</p>
                        </div>
                    </div>
                </div>

                <!-- ✅ بطاقة بيانات ولي الأمر -->
                <div class="col-lg-6">
                    <div class="card parent-card shadow-sm h-100">
                        <div class="card-header parent-card-header fw-bold text-end d-flex  align-items-center">
                            <i class="fas fa-user-shield"></i>
                            <span>{{ trans('main_trans.paretn_details') }}</span>
                        </div>
                        <div class="card-body parent-card-body">
                            <p class="parent-info "><strong>{{ trans('Parent_trans.Name_Father') }}:</strong>{{ $Student->myparent->user->name }}</p>
                            <p class="parent-info"><strong>{{ trans('Parent_trans.Phone_Father') }}:</strong> {{ $Student->myparent->Phone_Father }}</p>
                            <p class="parent-info "><strong>{{ trans('Parent_trans.Job_Father') }}:</strong>{{ $Student->myparent->Job_Father }}</p>
                            <p class="parent-info "><strong>{{ trans('Parent_trans.Address_Father') }}:</strong>{{ $Student->myparent->Address_Father }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
