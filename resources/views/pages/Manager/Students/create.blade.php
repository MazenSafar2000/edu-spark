@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header-form">{{ trans('main_trans.add_student') }}</h3>
        <div class="title-underline"></div>

        <div class="container mt-4">
            <div class="card custom-form-card">
                <div class="card-body">
                    @include('components.error-field')
                    <form class="subject-form" method="post" action="{{ route('Students.store') }}" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf

                        @include('forms._form-student', ['formMode' => 'create'])

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        // When grade is selected
        $('#Grade_id').on('change', function() {
            let gradeId = $(this).val();
            $('#Classroom_id').empty().append('<option selected disabled>Loading...</option>');
            $('#section_id').empty().append(
                '<option selected disabled>{{ trans('main_trans.select_section') }}</option>');

            $.get('/ajax/classrooms/' + gradeId, function(data) {
                $('#Classroom_id').empty().append(
                    '<option selected disabled>{{ trans('main_trans.select_class') }}</option>');
                data.forEach(function(classroom) {
                    $('#Classroom_id').append(
                        `<option value="${classroom.id}">${classroom.name}</option>`);
                });
            });
        });

        // When classroom is selected
        $('#Classroom_id').on('change', function() {
            let classroomId = $(this).val();
            $('#section_id').empty().append('<option selected disabled>Loading...</option>');

            $.get('/ajax/sections/' + classroomId, function(data) {
                $('#section_id').empty().append(
                    '<option selected disabled>{{ trans('main_trans.select_section') }}</option>');
                data.forEach(function(section) {
                    $('#section_id').append(
                        `<option value="${section.id}">${section.name}</option>`);
                });
            });
        });
    </script>
@endsection
