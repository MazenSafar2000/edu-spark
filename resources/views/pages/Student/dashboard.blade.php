@extends('layouts.main.student_dashboard')
@section('student-content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">


        <section class="dashboard-student">
            <h2 class="student-header">{{ trans('Students_trans.welcome') }}: <span>{{ Auth::user()->name }}</span></h2>

            <div class="container-fluid">
                <div class="row gy-4 subject-section">

                    @foreach ($subjects as $item)
                        <div class="col-lg-4 col-md-6">
                            <div class="box">
                                <div class="tutor">
                                    <img src="{{ asset('assets/images/pic-3.jpg') }}" alt="">

                                    <div class="info">
                                        <h4>{{ $item->teacher->user->name }}</h4>
                                        <span>{{ $item->created_at->format('Y-m-d') }}</span>
                                    </div>
                                </div>
                                <div class="thumb">
                                    <img src="{{ $item->subject->image ? asset('storage/' . $item->subject->image) : asset('assets/images/no_name.gif') }}"
                                        alt="">
                                </div>
                                <h3 class="title">{{ $item->subject->name }}</h3>
                                <a href="{{ route('student.subject.materials', $item->id) }}"
                                    class="playlist-btn">{{ trans('Students_trans.View_courses') }}</a>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>

        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
