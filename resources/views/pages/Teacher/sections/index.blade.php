@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <div class="container custom-table-teacher">

            <h3 class="teacher-title2">{{ trans('main_trans.List_classes') }}</h3>
            <div class="title-underline"></div>

            <div class="search-box-student text-end mb-3">
                <input type="search" id="classesSearch" class="form-control search-input-custom"
                    placeholder="{{ trans('main_trans.search') }}">
            </div>

            <div class="table-responsive custom-table-wrapper">


                <table class="table-hover text-center custom-grade-table" id="datatable">
                    <thead class="thead-custom">
                        <tr>
                            <th>#</th>
                            <th>{{ trans('main_trans.Grade') }}</th>
                            <th>{{ trans('main_trans.classroom') }}</th>
                            <th>{{ trans('main_trans.section') }}</th>
                            <th>{{ trans('main_trans.subject_name') }}</th>
                            <th>{{ trans('main_trans.number_students') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sections as $section)
                            <tr onclick="window.location.href='{{ route('teacher.section.materials', $section->id) }}'"
                                style="cursor: pointer;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $section->section->My_classs->Grades->Name }}</td>
                                <td>{{ $section->section->My_classs->Name_Class }}</td>
                                <td>{{ $section->section->Name_Section }}</td>
                                <td>{{ $section->subject->name }}</td>
                                <td>{{ $section->section->students->count() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $sections->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>

    {{-- search input code --}}
    <script>
        document.getElementById('classesSearch').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const table = document.getElementById('datatable');
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = Array.from(row.cells).map(td => td.textContent.toLowerCase());
                const match = cells.some(cell => cell.includes(searchValue));
                row.style.display = match ? '' : 'none';
            });
        });
    </script>
@endsection
