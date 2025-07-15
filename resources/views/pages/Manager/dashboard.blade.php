@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <section class="dashboard-manager py-4">
            <div class="container-fluid">
                <div class="row gy-4">

                    <!-- البطاقة: عدد الطلاب -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card stats-card border-0 rounded-3 p-3">
                            <div class="card-content d-flex justify-content-between align-items-center">
                                <div class="user-number">
                                    <h6 class="text-muted">{{ trans('main_trans.Number_of_students') }}</h6>
                                    <h4 class="fw-bold">{{ \App\Models\Student::count() }}</h4>
                                </div>
                                <i class="fas fa-graduation-cap fa-2x"></i>
                            </div>
                            <hr>
                            <a href="{{ route('Students.index') }}" class="text-center d-block text-decoration-none"><i
                                    class="fas fa-user-friends"></i> {{ trans('main_trans.View_data') }}</a>
                        </div>
                    </div>

                    <!-- البطاقة: عدد المعلمين -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card stats-card border-0 rounded-3 p-3">
                            <div class="card-content d-flex justify-content-between align-items-center">
                                <div class="user-number">
                                    <h6 class="text-muted">{{ trans('main_trans.Number_of_teachers') }}</h6>
                                    <h4 class="fw-bold">{{ \App\Models\Teacher::count() }}</h4>
                                </div>
                                <i class="fas fa-chalkboard-teacher fa-2x"></i>
                            </div>
                            <hr>
                            <a href="{{ route('Teachers.index')}}" class="text-center d-block text-decoration-none"><i
                                    class="fas fa-user-friends"></i> {{ trans('main_trans.View_data') }}</a>
                        </div>
                    </div>

                    <!-- البطاقة: عدد أولياء الأمور -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card stats-card border-0 rounded-3 p-3">
                            <div class="card-content d-flex justify-content-between align-items-center">
                                <div class="user-number">
                                    <h6 class="text-muted">{{ trans('main_trans.Number_of_parent') }}</h6>
                                    <h4 class="fw-bold">{{ \App\Models\ParentProfile::count() }}</h4>
                                </div>
                                <i class="fas fa-user-friends fa-2x"></i>
                            </div>
                            <hr>
                            <a href="manager-parent.html" class="text-center d-block text-decoration-none"><i
                                    class="fas fa-user-friends"></i> {{ trans('main_trans.View_data') }}</a>
                        </div>
                    </div>

                    <!-- البطاقة: عدد الصفوف -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card stats-card border-0 rounded-3 p-3">
                            <div class="card-content d-flex justify-content-between align-items-center">
                                <div class="user-number">
                                    <h6 class="text-muted">{{ trans('main_trans.Number_of_classrooms') }}</h6>
                                    <h4 class="fw-bold">{{ \App\Models\Section::count() }}</h4>
                                </div>
                                <i class="fas fa-laptop fa-2x"></i>
                            </div>
                            <hr>
                            <a href="{{ route('Grades.index')}}" class="text-center d-block text-decoration-none"><i
                                    class="fas fa-user-friends"></i> {{ trans('main_trans.View_data') }}</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <div class="table-users mt-5">

            <!-- التبويبات -->
            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#students"
                        type="button" role="tab">{{ trans('main_trans.Students') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="teachers-tab" data-bs-toggle="tab" data-bs-target="#teachers"
                        type="button" role="tab">{{ trans('main_trans.Teachers') }}</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="parents-tab" data-bs-toggle="tab" data-bs-target="#parents" type="button"
                        role="tab">{{ trans('main_trans.Parents') }}</button>
                </li>

            </ul>

            <!-- المحتوى -->
            <div class="table-content tab-content" id="myTabContent">
                <!-- الطلاب -->
                <div class="tab-pane fade show active" id="students" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table text-center custom-user-table">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Students_trans.student_name') }}</th>
                                    <th>{{ trans('Students_trans.email') }}</th>
                                    <th>{{ trans('Students_trans.gender') }}</th>
                                    <th>{{ trans('Students_trans.Grade') }}</th>
                                    <th>{{ trans('Students_trans.classrooms') }}</th>
                                    <th>{{ trans('Students_trans.section') }}</th>
                                    <th>{{ trans('Students_trans.created_at') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\Student::latest()->take(5)->get() as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->user->name }}</td>
                                        <td>{{ $student->user->email }}</td>
                                        <td>{{ $student->gender->Name }}</td>
                                        <td>{{ $student->grade->Name }}</td>
                                        <td>{{ $student->classroom->Name_Class }}</td>
                                        <td>{{ $student->section->Name_Section }}</td>
                                        <td class="text-success">{{ $student->created_at }}</td>
                                    @empty
                                        <td class="alert-danger" colspan="8">{{ trans('main_trans.no_data') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- المعلمين -->
                <div class="tab-pane fade" id="teachers" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table text-center custom-user-table">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('main_trans.Number_of_teachers') }}</th>
                                    <th>{{ trans('Students_trans.gender') }}</th>
                                    <th>{{ trans('main_trans.Date_of_appointment') }}</th>
                                    <th>{{ trans('main_trans.specialization') }}</th>
                                    <th>{{ trans('Students_trans.created_at') }}
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\Teacher::latest()->take(5)->get() as $teacher)
                            <tbody>
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $teacher->user->name }}</td>
                                    <td>{{ $teacher->genders->Name }}</td>
                                    <td>{{ $teacher->Joining_Date }}</td>
                                    <td>{{ $teacher->specializations->Name }}</td>
                                    <td class="text-success">{{ $teacher->created_at }}</td>
                                @empty
                                    <td class="alert-danger" colspan="5">{{ trans('main_trans.no_data') }}</td>
                                </tr>
                            </tbody>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- أولياء الأمور -->
                <div class="tab-pane fade" id="parents" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table text-center custom-user-table">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Parent_trans.Name_Father') }}</th>
                                    <th>{{ trans('Students_trans.email') }}</th>
                                    {{-- <th>{{ trans('Parent_trans.ID') }}</th> --}}
                                    <th>{{ trans('Parent_trans.Phone_Father') }}</th>
                                    <th>{{ trans('Students_trans.created_at') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\ParentProfile::latest()->take(5)->get() as $parent)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $parent->user->name }}</td>
                                        <td>{{ $parent->user->email }}</td>
                                        {{-- <td> {{ $parent->id}} </td> --}}
                                        <td>{{ $parent->Phone_Father }}</td>
                                        <td class="text-success">{{ $parent->created_at }}</td>
                                    @empty
                                        <td class="alert-danger" colspan="5">{{ trans('main_trans.no_data') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
