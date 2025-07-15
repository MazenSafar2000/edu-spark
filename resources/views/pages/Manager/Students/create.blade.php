@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header-form">{{ trans('main_trans.add_student') }}</h3>

        <div class="container mt-4">
            <div class="card custom-form-card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="subject-form" method="post" action="{{ route('Students.store') }}" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf

                        @include('forms._form-student', ['formMode' => 'create'])

                    </form>
                </div>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('select[name="Grade_id"]').on('change', function() {
                var Grade_id = $(this).val();
                if (Grade_id) {
                    $.ajax({
                        url: "{{ URL::to('Get_classrooms') }}/" + Grade_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="Classroom_id"]').empty();
                            $('select[name="Classroom_id"]').append(
                                "<option selected disabled >{{ trans('Parent_trans.Choose') }}...</option>"
                            );
                            $.each(data, function(key, value) {
                                $('select[name="Classroom_id"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });

                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });


        $(document).ready(function() {
            $('select[name="Classroom_id"]').on('change', function() {
                var Classroom_id = $(this).val();
                if (Classroom_id) {
                    $.ajax({
                        url: "{{ URL::to('Get_Sections') }}/" + Classroom_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="section_id"]').empty();
                            $('select[name="section_id"]').append(
                                "<option selected disabled >{{ trans('Parent_trans.Choose') }}...</option>"
                            );
                            $.each(data, function(key, value) {
                                $('select[name="section_id"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });

                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>
@endsection
