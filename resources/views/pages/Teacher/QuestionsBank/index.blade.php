@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="teacher-title2">{{ trans('Teacher_trans.questionBank') }}</h3>
        <div class="title-underline"></div>

        <div class="container custom-table-teacher">

            <div class="header-table-teacher">
                <a href="{{ route('questions.create') }}">{{ trans('Teacher_trans.add_new_question') }}</a>


                <div class="search-box-student text-end mb-3 d-flex flex-row">
                    <select class="form-select std-select" name="QCategory_id" id="category-select">
                        <option selected disabled>{{ trans('Teacher_trans.select_category') }}</option>
                        @foreach ($categories as $QC)
                            <option value="{{ $QC->id }}">{{ $QC->title }}</option>
                        @endforeach
                        <option value="__new__"><a href="">{{ trans('Teacher_trans.new_category') }}</a></option>
                    </select>

                    <input type="search" id="questionSearch" class="form-control search-input-custom"
                        placeholder="{{ trans('main_trans.search') }}">

                </div>
            </div>

            <div class="table-responsive custom-table-wrapper">
                <table class="text-center custom-grade-table" id="datatable">
                    <thead class="thead-custom">
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Teacher_trans.question') }} </th>
                            <th>{{ trans('Teacher_trans.category') }} </th>
                            <th>{{ trans('Teacher_trans.type') }} </th>
                            <th>{{ trans('Teacher_trans.score') }}</th>
                            <th>{{ trans('Teacher_trans.operations') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $question->question }}</td>
                                <td>{{ $question->QCategory->title }}</td>
                                <td>{{ $question->type }}</td>
                                <td>{{ $question->score }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle dropdown-toggle-operations"
                                            data-bs-toggle="dropdown">
                                            {{ trans('main_trans.operations') }}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-operations">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2"
                                                    href="{{ route('questions.edit', $question->id) }}">
                                                    <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                    {{ trans('main_trans.edit') }}
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal-question{{ $question->id }}">
                                                    <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                    {{ trans('main_trans.delete') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- delete question modal -->
                            <div class="modal fade" id="deleteModal-question{{ $question->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                    <div class="modal-content">
                                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="{{ trans('main_trans.close') }}"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                            </div>
                                            <div class="modal-footer custom-modal-footer">
                                                <button type="submit" class="btn btn-primary custom-save-btn">
                                                    {{ trans('main_trans.delete') }}</button>
                                                <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                    data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                {{ $questions->links('vendor.pagination.custom') }}

                <!-- add QC modal -->
                <div class="modal fade custom-modal" id="createQCModal" tabindex="-1" aria-labelledby="createQCModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                        <div class="modal-content custom-modal-content">

                            <!-- رأس المودال -->
                            <div class="modal-header custom-modal-header">
                                <h5 class="modal-title custom-modal-title">
                                    {{ trans('Teacher_trans.createQC') }}
                                </h5>
                            </div>

                            <!-- جسم المودال -->
                            <div class="modal-body custom-modal-body">
                                <form id="addQCForm" class="custom-form" action="{{ route('questionsCategotry.store') }}"
                                    method="POST" class="custom-form">
                                    @csrf
                                    <div class="mb-3 custom-form-group">
                                        <div class="form-group-float position-relative ">
                                            <input type="text" name="title"
                                                class="form-control custom-input float-input @error('title') custom-input-error @enderror"
                                                id="title" placeholder=" " value="{{ old('title') }}" />
                                            <label for="title"
                                                class="float-label">{{ trans('Teacher_trans.QB_title') }}*</label>
                                        </div>
                                        @error('title')
                                            <div class="error-message" id="error-bookNameArabic">
                                                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </form>
                            </div>

                            <!-- تذييل المودال -->
                            <div class="modal-footer custom-modal-footer">
                                <button type="submit" class="btn btn-primary custom-save-btn"
                                    form="addQCForm">{{ trans('Teacher_trans.save') }}</button>
                                <button type="button" class="btn btn-secondary custom-cancel-btn"
                                    data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('questionSearch');
            const categorySelect = document.getElementById('category-select');
            const table = document.getElementById('datatable');
            const rows = table.querySelectorAll('tbody tr');

            function filterTable() {
                const searchValue = searchInput.value.toLowerCase();
                const selectedCategory = categorySelect.value;

                rows.forEach(row => {
                    const cells = Array.from(row.cells).map(td => td.textContent.toLowerCase());
                    const categoryCell = row.cells[2].textContent; // العمود الثالث = التصنيف
                    const matchesSearch = cells.some(cell => cell.includes(searchValue));
                    const matchesCategory = !selectedCategory || categoryCell == categorySelect.options[
                        categorySelect.selectedIndex].text;

                    row.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
                });
            }

            // events
            searchInput.addEventListener('input', filterTable);
            categorySelect.addEventListener('change', function() {
                if (this.value === '__new__') {
                    this.value = '';
                    const modal = new bootstrap.Modal(document.getElementById('createQCModal'));
                    modal.show();
                } else {
                    filterTable();
                }
            });
        });
    </script>
@endsection
