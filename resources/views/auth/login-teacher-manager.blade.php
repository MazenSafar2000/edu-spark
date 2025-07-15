@extends('layouts.loginHead')
@section('content')
    <section class="login-teacher">
        <div class="form-container-teacher">
            @if (\Session::has('message'))
                <div class="alert alert-danger">
                    <li>{!! \Session::get('message') !!}</li>
                </div>
            @endif
            <!-- Teacher Login Form-->
            <form id="teacherForm" class="custom-form" style="display: block;" method="POST"
                action="{{ route('login.teacher') }}">
                @csrf
                <input type="hidden" value="teacher" name="type">

                <h3> {{ trans('main_trans.teacher_login') }} </h3>
                <input id="email" type="email" name="email" placeholder="{{ trans('main_trans.Enter_ID') }}"
                    class="input-box-teacher @error('email') is-invalid @enderror" value="{{ old('email') }}" required
                    autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <input id="password" type="password" name="password" placeholder="{{ trans('main_trans.Enter_Password') }}"
                    class="input-box-teacher2 @error('password') is-invalid @enderror" required
                    autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <button class="login-btn-teacher">{{ trans('main_trans.Login') }}</button>
            </form>

            <!-- Manager Form -->
            <form id="adminForm" class="custom-form" style="display: none;" method="POST"
                action="{{ route('login.manager') }}">
                @csrf
                <input type="hidden" value="admin" name="type">

                <h3> {{ trans('main_trans.manager_login') }} </h3>
                <input id="email" type="email" name="email" placeholder="{{ trans('main_trans.Enter_ID') }}"
                    class="input-box-teacher @error('email') is-invalid @enderror" value="{{ old('email') }}" required
                    autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <input id="password" type="password" name="password"
                    placeholder="{{ trans('main_trans.Enter_Password') }}"
                    class="input-box-teacher2 @error('password') is-invalid @enderror" required
                    autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <button class="login-btn-teacher">{{ trans('main_trans.Login') }}</button>
            </form>

            <div class="icons">
                <a href="#" class="login-icon" id="icon-admin" onclick="showForm('admin', this)"><img
                        src="{{ asset('assets/images/manager-off.png') }}" alt="Admin"
                        title="{{ trans('main_trans.manager_login') }}"></a>
                <a href="#" class="login-icon" id="icon-teacher" onclick="showForm('teacher',this)"><img
                        src="{{ asset('assets/images/teacher.png') }}" alt="Teacher"
                        title="{{ trans('main_trans.teacher_login') }}"></a>

            </div>
        </div>
    </section>
@endsection
