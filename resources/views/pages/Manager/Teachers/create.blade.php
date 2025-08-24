@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header-form">{{ trans('main_trans.add_teacher') }}</h3>

        <div class="container mt-4">
            <div class="card custom-form-card">
                <div class="card-body">
                    @include('components.error-field')
                    <form class="subject-form" action="{{ route('Teachers.store') }}" method="POST">
                        @csrf

                        @include('forms._form-teacher')

                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
