@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="teacher-title2">{{ trans('Teacher_trans.questionBank') }}</h3>
        <div class="title-underline"></div>

        <div class="container custom-table-teacher">

            <div class="header-table-teacher">
                <a href="{{ route('Questions.create') }}">{{ trans('Teacher_trans.add_new_question') }}</a>


                <div class="search-box-student text-end mb-3 d-flex flex-row">
                    <select class="form-select std-select" name="teacher_select" id="teacher_selec">
                        <option selected disabled>{{ trans('main_trans.select_teacher_name') }}</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-select std-select" name="QCategory_id" id="category-select">
                        <option selected disabled>{{ trans('Teacher_trans.select_category') }}</option>
                        @foreach ($categories as $QC)
                            <option value="{{ $QC->id }}">{{ $QC->title }}</option>
                        @endforeach
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
                        @forelse ($questions as $question)
                            <tr data-teacher="{{ $question->teacher_id }}" data-category="{{ $question->QCategory->id }}">
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
                                        <form action="{{ route('Questions.destroy', $question->id) }}" method="POST">
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
                        @empty
                            <td class="alert-danger" colspan="8">{{ trans('main_trans.no_data') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $questions->links('vendor.pagination.custom') }}

            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('questionSearch');
            const categorySelect = document.getElementById('category-select');
            const teacherSelect = document.getElementById('teacher_selec');
            const table = document.getElementById('datatable');
            const rows = table.querySelectorAll('tbody tr');

            // keep a copy of all categories
            const allCategories = @json($categories);

            // disable category select by default
            categorySelect.disabled = true;

            function filterTable() {
                const searchValue = searchInput.value.toLowerCase();
                const selectedCategory = categorySelect.value;
                const selectedTeacher = teacherSelect.value;

                rows.forEach(row => {
                    const cells = Array.from(row.cells).map(td => td.textContent.toLowerCase());
                    const rowCategoryId = row.getAttribute('data-category');
                    const rowTeacherId = row.getAttribute('data-teacher');

                    const matchesSearch = cells.some(cell => cell.includes(searchValue));
                    const matchesTeacher = !selectedTeacher || rowTeacherId === selectedTeacher;
                    const matchesCategory = !selectedCategory || rowCategoryId === selectedCategory;

                    row.style.display = (matchesSearch && matchesTeacher && matchesCategory) ? '' : 'none';
                });
            }

            function updateCategoryOptions() {
                const selectedTeacher = teacherSelect.value;
                categorySelect.innerHTML = '';

                // disable if no teacher
                if (!selectedTeacher) {
                    categorySelect.disabled = true;
                    return;
                }

                // enable if teacher is selected
                categorySelect.disabled = false;

                // add default option
                const defaultOption = document.createElement('option');
                defaultOption.textContent = "{{ trans('Teacher_trans.select_category') }}";
                defaultOption.disabled = true;
                defaultOption.selected = true;
                categorySelect.appendChild(defaultOption);

                // collect categories from visible rows (belonging to selected teacher)
                const teacherCategories = new Set();
                rows.forEach(row => {
                    if (row.getAttribute('data-teacher') === selectedTeacher) {
                        teacherCategories.add(row.getAttribute('data-category'));
                    }
                });

                // add filtered categories to select
                allCategories.forEach(cat => {
                    if (teacherCategories.has(cat.id.toString())) {
                        const option = document.createElement('option');
                        option.value = cat.id;
                        option.textContent = cat.title;
                        categorySelect.appendChild(option);
                    }
                });
            }

            // events
            searchInput.addEventListener('input', filterTable);

            categorySelect.addEventListener('change', function() {
                filterTable();
            });

            teacherSelect.addEventListener('change', function() {
                updateCategoryOptions();
                filterTable();
            });
        });
    </script>
@endsection
