@extends('layouts.loginHead')
@section('login-content')
    <section class="login">
        <div class="login-container">

            <div class="right-section">
                <div class="login-box">
                    {{-- Student login form --}}
                    <form id="stdForm" class="custom-form" style="display: block;"method="POST"
                        action="{{ route('login.student') }}">
                        @csrf
                        <input type="hidden" value="student" name="type">

                        <h2><span>{{ trans('main_trans.Student') }} </span>{{ trans('main_trans.Login') }}</h2>

                        @include('components.error-field')

                        <input id="National_ID" type="number" name="National_ID" placeholder="{{ trans('main_trans.Enter_ID') }}"
                            class="input-box-custom  " value="{{ old('National_ID') }}" required autocomplete="National_ID">
                        <input id="password" type="password" name="password"
                            placeholder="{{ trans('main_trans.Enter_Password') }}"
                            class="input-box-custom2 @error('password') is-invalid @enderror" required
                            autocomplete="current-password">
                        <button class="login-btn-custom">{{ trans('main_trans.Login') }}</button>
                    </form>

                    {{-- Parent login form --}}
                    <form id="parentForm" class="custom-form" style="display: none;"method="POST"
                        action="{{ route('login.parent') }}" style="display: none;">
                        @csrf
                        <input type="hidden" id="user-type" name="type" value="parent">

                        <h2><span>{{ trans('main_trans.Parent') }} </span>{{ trans('main_trans.Login') }}</h2>

                        @include('components.error-field')

                        <input id="National_ID" type="number" name="National_ID"
                            placeholder="{{ trans('main_trans.Enter_ID') }}"
                            class="input-box-custom @error('National_ID') is-invalid @enderror" value="{{ old('National_ID') }}"
                            required autocomplete="National_ID">
                        <input id="password" type="password" name="password"
                            placeholder="{{ trans('main_trans.Enter_Password') }}"
                            class="input-box-custom2 @error('password') is-invalid @enderror" required
                            autocomplete="current-password">
                        <button class="login-btn-custom">{{ trans('main_trans.Login') }}</button>
                    </form>

                    <div class="icons">
                        <a href="#" class="login-icon" id="icon-std" onclick="showForm('student',this)"><img
                                src="{{ asset('assets/images/std-on.png') }}" alt="Student" title="{{ trans('main_trans.Student_Login') }}"></a>
                        <a href="#" class="login-icon" id="icon-parent" onclick="showForm('parent', this)"><img
                                src="{{ asset('assets/images/par-off.png') }}" alt="Parent"
                                title="{{ trans('main_trans.Parent_Login') }}"></a>

                    </div>
                </div>
            </div>

            <div class="left-section">
                <div class="image-container">
                    <img src="{{ asset('assets/images/child.webp') }}" alt="Student Image" class="student-img">
                </div>
            </div>
        </div>

    </section>
@endsection
