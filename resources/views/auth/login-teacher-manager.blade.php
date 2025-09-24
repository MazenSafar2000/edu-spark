@extends('layouts.loginHead')
@section('login-content')
    <section class="login-teacher">

        <div class="form-container-teacher">

            {{-- Teacher login form --}}
            <form id="teacherForm" class="custom-form" style="display: block;"method="POST"
                action="{{ route('login.teacher') }}">
                @csrf
                <input type="hidden" value="teacher" name="type">

                <h3><span>{{ trans('main_trans.Teacher') }} </span>{{ trans('main_trans.Login') }}</h3>
                @include('components.error-field')
                <input  type="number" name="National_ID" placeholder="{{ trans('main_trans.Enter_ID') }}"
                    class="input-box-teacher " value="{{ old('National_ID') }}" required autocomplete="National_ID">
                <input  type="password" name="password" placeholder="{{ trans('main_trans.Enter_Password') }}"
                    class="input-box-teacher2 " required autocomplete="current-password">
                <button class="login-btn-teacher">{{ trans('main_trans.Login') }}</button>
            </form>

            {{-- Manager login form --}}
            <form id="adminForm" class="custom-form" style="display: none;"method="POST"
                action="{{ route('login.manager') }}">
                @csrf
                <input type="hidden" value="admin" name="type">

                <h3><span>{{ trans('main_trans.manager') }} </span>{{ trans('main_trans.Login') }}</h3>
                @include('components.error-field')
                <input  type="number" name="National_ID" placeholder="{{ trans('main_trans.Enter_ID') }}"
                    class="input-box-teacher " value="{{ old('National_ID') }}" required autocomplete="National_ID">
                <input  type="password" name="password"
                    placeholder="{{ trans('main_trans.Enter_Password') }}" class="input-box-teacher2 " required
                    autocomplete="current-password">
                <button class="login-btn-teacher">{{ trans('main_trans.Login') }}</button>
            </form>

            <div class="icons">
                <a href="#" class="login-icon" id="icon-teacher" onclick="showForm('teacher',this)"><img
                        src="{{ asset('assets/images/teacher.png') }}" alt="Teacher" title="{{ trans('main_trans.teacher_login') }}"></a>
                <a href="#" class="login-icon" id="icon-admin" onclick="showForm('admin', this)"><img
                        src="{{ asset('assets/images/manager-off.png') }}" alt="Admin" title="{{ trans('main_trans.manager_login') }}"></a>
            </div>


        </div>
    </section>
@endsection
