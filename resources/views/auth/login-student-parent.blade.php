@extends('layouts.loginHead')
@section('content')
    <section class="login">
        <div class="login-container">
            <div class="left-section">
                <div class="image-container">
                    <img src="{{ asset('assets/images/child.png') }}" alt="Student Image" class="student-img">
                </div>
            </div>
            <div class="right-section">
                <div class="login-box">
                    @if (\Session::has('message'))
                        <div class="alert alert-danger">
                            <li>{!! \Session::get('message') !!}</li>
                        </div>
                    @endif

                    <!-- Student Login Form-->
                    <form id="stdForm" class="custom-form" style="display: block;" method="POST"
                        action="{{ route('login.student') }}">
                        @csrf
                        <input type="hidden" value="student" name="type">

                        <h2> {{ trans('main_trans.Student_Login') }} </h2>
                        <input id="email" type="email" name="email" placeholder="{{ trans('main_trans.Enter_ID') }}"
                            class="input-box-custom  @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <input id="password" type="password" name="password"
                            placeholder="{{ trans('main_trans.Enter_Password') }}"
                            class="input-box-custom2 @error('password') is-invalid @enderror" required
                            autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <button class="login-btn-custom">{{ trans('main_trans.Login') }}</button>
                    </form>

                    <form id="parentForm" class="custom-form" style="display: none;" method="POST"
                        action="{{ route('login.parent') }}" style="display: none;">
                        @csrf
                        <input type="hidden" id="user-type" name="type" value="parent">

                        <h2> {{ trans('main_trans.Parent_Login') }} </h2>
                        <input id="email" type="email" name="email"
                            placeholder="{{ trans('main_trans.Enter_ID') }}"
                            class="input-box-custom @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <input id="password" type="password" name="password"
                            placeholder="{{ trans('main_trans.Enter_Password') }}"
                            class="input-box-custom2 @error('password') is-invalid @enderror" required
                            autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <button class="login-btn-custom">{{ trans('main_trans.Login') }}</button>
                    </form>

                    <div class="icons">
                        <a href="#" class="login-icon" id="icon-parent" onclick="showForm('parent', this)"><img
                                src="{{ asset('assets/images/par-off.png') }}" alt="Parent"
                                title="تسجيل دخول ولي الامر"></a>
                        <a href="#" class="login-icon" id="icon-std" onclick="showForm('student',this)"><img
                                src="{{ asset('assets/images/std-on.png') }}" alt="Student" title="تسجيل دخول الطالب"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
