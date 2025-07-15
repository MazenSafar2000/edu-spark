@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <section class="dashboard-teacher">
            <div class="container-fluid">
                <div class="row gy-4">
                    <div class="col-lg-6 col-md-12">
                        <div class="card stats-card border-0 rounded-3 p-3">
                            <div class="card-welcome-content d-flex justify-content-between align-items-center">

                                <div class="user-welcome">
                                    <h4> {{ trans('main_trans.Welcome') }} </h4>
                                    <h6>{{ Auth::user()->name }}</h6>
                                    <img src="{{ asset('assets/images/pic-1.jpg') }}" alt="" class="rounded-circle">
                                </div>
                                <img src="{{ asset('assets/images/welcome.png') }}" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card stats-card border-0 rounded-3 ">
                            <div class="card-techaer-content d-flex justify-content-center align-items-center">
                                <i class="fa-solid fa-user-graduate fa-2x"></i>

                                <div class="user-number-teacher">
                                    <h4 class="fw-bold">{{ $studentCount }}</h4>
                                    <h6 class="text-muted">{{ trans('main_trans.number_students') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card stats-card border-0 rounded-3">
                            <div class="card-techaer-content d-flex justify-content-center align-items-center">
                                <i class="fas fa-book fa-2x"></i>

                                <div class="user-number-teacher">
                                    <h4 class="fw-bold">{{ $sectionCount }}</h4>
                                    <h6 class="text-muted">{{ trans('main_trans.number_classes') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <div class="table-users-teacher mt-5">

            <div class="header-table-teacher">

                <h3 class="teacher-title2" style="margin-bottom: 2rem;">{{ trans('main_trans.List_classes') }}</h3>

            </div>

            <!-- المحتوى -->
            <div class="table-content-teacher tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="grades" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover text-center custom-user-table-teacher">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('main_trans.Grade') }}</th>
                                    <th>{{ trans('main_trans.classroom') }}</th>
                                    <th>{{ trans('main_trans.section') }}</th>
                                    <th>{{ trans('main_trans.subject_name') }}</th>
                                    <th>{{ trans('main_trans.number_students') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sections as $section)
                                    <tr class="clickable-row"
                                        data-href="{{ route('teacher.section.materials', $section->section->id) }}"
                                        style="cursor: pointer;">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $section->section->My_classs->Grades->Name }}</td>
                                        <td>{{ $section->section->My_classs->Name_Class }}</td>
                                        <td>{{ $section->section->My_classs->Name_Class }}</td>
                                        <td>{{ $section->subject->name }}</td>
                                        <td>{{ $section->section->students->count() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".clickable-row").forEach(function(row) {
                row.addEventListener("click", function() {
                    window.location = this.dataset.href;
                });
            });
        });
    </script>
@endsection
