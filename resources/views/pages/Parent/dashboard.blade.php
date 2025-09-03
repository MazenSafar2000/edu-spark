@extends('layouts.main.parent_dashboard')
@section('parent_content')
    <div class="parentContent">
        <div class="container parentContent-welcome">
            <div class="row g-3">

                <!-- بطاقة الترحيب -->
                <div class="col-lg-6 col-12">
                    <div class="card welcome-card-parent">
                        <div class="d-flex align-items-center welcome-parent">
                            <img src="{{ asset('assets/images/parent.svg')}}" alt="welcome" class="welcome-img-parent ">
                            <div class="welcome-text-parent">
                                <h4 class="fw-bold mb-1">{{ trans('Parent_trans.control_panel') }}</h4>
                                <p class="mb-0 text-muted">{{ trans('Parent_trans.we_wish') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- بطاقة الأبناء -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card children-card  text-center h-100">
                        <h5 class="fw-bold children-title">{{ trans('Parent_trans.children_list') }}</h5>
                        <i class="fas fa-child children-icon"></i>
                        <p class="text-muted mb-1 children-count">{{ trans('Parent_trans.numner_children') }} <strong>{{$sonsCount}}</strong></p>

                    </div>
                </div>

                <!-- بطاقة الملف الشخصي -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card profile-card text-center h-100">
                        <h5 class="fw-bold profile-title">{{ trans('Parent_trans.profile') }}</h5>
                        <i class="fas fa-user profile-icon"></i>
                        <p class="text-muted mb-1 profile-info">{{ trans('Parent_trans.personal_information') }}</p>
                        <a href="{{ route('parent.profile')}}" class="btn profile-btn">{{ trans('Parent_trans.view_profile') }}</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="container py-5 children-card-parent">
            <div class="row g-4">
                @foreach ($sons as $son )
                <!-- بطاقة طالب -->
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="student-card">
                        <img src="{{ asset('assets/images/pic-1.jpg')}}" alt="طالب">
                        <div class="student-name">{{ $son->user->name}}</div>
                        <div class="text-muted">{{ $son->National_ID}}</div>
                        <div class="d-flex justify-content-between mt-3 info-text">
                            <span>{{ trans('main_trans.Grade') }}</span><span class="fw-normal">{{ $son->grade->Name}}</span>
                        </div>
                        <div class="d-flex justify-content-between info-text">
                            <span>{{ trans('main_trans.classroom') }}</span><span class="fw-normal">{{ $son->classroom->Name_Class}}</span>
                        </div>
                        <div class="d-flex justify-content-between info-text">
                            <span>{{ trans('main_trans.section') }}</span><span class="fw-normal">{{ $son->section->Name_Section}}</span>
                        </div>
                        <a href="{{ route('student.subjects', $son->id)}}" class="btn btn-view w-100">{{ trans('main_trans.view') }}</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>


    </div>
@endsection
