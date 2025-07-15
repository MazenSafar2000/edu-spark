@extends('layouts.loginhead')
@section('content')
    <section class="about">

        <div class="row">
            <div class="content">
                <h3>{{ trans('main_trans.About_us') }}</h3>
                <p>{{ trans('main_trans.About_pargraph') }}</p>
            </div>

            <div class="image">
                <img src="{{ URL::asset('assets/images/about.png') }}" alt="">
            </div>
        </div>

        <div class="titleWho">
            <h3>{{ trans('main_trans.System_users') }}</h3>
        </div>
        <div class="box-container">
            <div class="box">
                <div>
                    <h3>+10k</h3>
                    <p>{{ trans('main_trans.Parents') }}</p>
                </div>
                <a href="loginstd.html"><img src="{{ URL::asset('assets/images/par-on.png') }}" alt=""></a>
            </div>

            <div class="box">
                <div>
                    <h3>+10k</h3>
                    <p>{{ trans('main_trans.Students') }}</p>
                </div>
                <a href="loginstd.html"><img src="{{ URL::asset('assets/images/std-on.png') }}" alt=""></a>
            </div>

            <div class="box">
                <div>
                    <h3>+10k</h3>
                    <p>{{ trans('main_trans.Teachers') }}</p>
                </div>
                <a href="loginstd.html"><img src="{{ URL::asset('assets/images/teacher.png') }}" alt=""></a>
            </div>

            <div class="box">
                <div>
                    <h3>+10k</h3>
                    <p>{{ trans('main_trans.School_Principals') }}</p>
                </div>
                <a href="loginstd.html"><img src="{{ URL::asset('assets/images/manager.png') }}" alt=""></a>
            </div>

        </div>
    </section>


    </html>
@endsection
