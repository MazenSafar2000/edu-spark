@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="teacher-title2">{{ trans('Teacher_trans.questions_categories') }}</h3>
        <div class="title-underline"></div>

        <div class="container custom-table-teacher">

            <div class="header-table-teacher">
                <a href="#" data-bs-toggle="modal"
                    data-bs-target="#addQuestionCategoryModal">{{ trans('Teacher_trans.new_category') }}</a>

                <div class="search-box-student text-end mb-3 d-flex flex-row">
                    <input type="search" id="QCSearch" class="form-control search-input-custom"
                        placeholder="{{ trans('main_trans.search') }}">
                </div>

                @include('components.error-field')
                <!-- add QC modal -->
                <div class="modal fade custom-modal" id="addQuestionCategoryModal" tabindex="-1"
                    aria-labelledby="addQuestionCategoryModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                        <div class="modal-content custom-modal-content">

                            <!-- رأس المودال -->
                            <div class="modal-header custom-modal-header">
                                <h5 class="modal-title custom-modal-title" id="addQuestionCategoryModal">
                                    {{ trans('Teacher_trans.createQC') }}
                                </h5>
                            </div>

                            <!-- جسم المودال -->
                            <div class="modal-body custom-modal-body">
                                <form id="addQCForm" class="custom-form" action="{{ route('QuestionsCategotry.store') }}"
                                    method="POST" class="custom-form">
                                    @csrf
                                    <div class="mb-3 custom-form-group">
                                        <label for=""
                                            class="text-danger">{{ trans('main_trans.Teachers') }}*</label>
                                        <select
                                            class="form-select custom-select @error('questions_bank_id') custom-select-error @enderror"
                                            name="questions_bank_id" id="questions_bank_id">
                                            <option selected disabled>{{ trans('main_trans.select_teacher_name') }}</option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->questionBanks->id }}">{{ $teacher->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('questions_bank_id')
                                            <div class="error-message" id="error-bookNameArabic">
                                                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
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

            <div class="table-responsive custom-table-wrapper">
                <table class="text-center custom-grade-table" id="datatable">
                    <thead class="thead-custom">
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Teacher_trans.category') }} </th>
                            <th>{{ trans('Teacher_trans.teacher_name') }}</th>
                            <th>{{ trans('Teacher_trans.operations') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questionCategories as $Category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $Category->title }}</td>
                                <td>{{ $Category->questionsBank->teacher->user->name }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle dropdown-toggle-operations"
                                            data-bs-toggle="dropdown">
                                            {{ trans('main_trans.operations') }}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-operations">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editQuestionCategoryModal{{ $Category->id }}">
                                                    <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                    {{ trans('main_trans.edit') }}
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal-category{{ $Category->id }}">
                                                    <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                    {{ trans('main_trans.delete') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $questionCategories->links('vendor.pagination.custom') }}

                @foreach ($questionCategories as $Category)
                    <!-- edit QC Modal -->
                    <div class="modal fade custom-modal" id="editQuestionCategoryModal{{ $Category->id }}" tabindex="-1"
                        aria-labelledby="editQuestionCategoryModal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                            <div class="modal-content custom-modal-content">

                                <!-- رأس المودال -->
                                <div class="modal-header custom-modal-header">
                                    <h5 class="modal-title custom-modal-title" id="editQuestionCategoryModal">تعديل القسم
                                    </h5>
                                </div>

                                <!-- جسم المودال -->
                                <div class="modal-body custom-modal-body">
                                    <form id="editQCForm{{ $Category->id }}" class="custom-form"
                                        action="{{ route('QuestionsCategotry.update', $Category->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3 custom-form-group">
                                            <label for=""
                                                class="text-danger">{{ trans('main_trans.Teachers') }}*</label>
                                            <select
                                                class="form-select custom-select @error('questions_bank_id') custom-select-error @enderror"
                                                name="questions_bank_id" id="questions_bank_id">
                                                <option selected value="{{ $Category->questions_bank_id }}">
                                                    {{ $Category->questionsBank->teacher->user->name }}
                                                </option>
                                                @foreach ($teachers as $teacher)
                                                    <option value="{{ $teacher->questionBanks->id }}">
                                                        {{ $teacher->user->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('questions_bank_id')
                                                <div class="error-message" id="error-bookNameArabic">
                                                    <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 custom-form-group">
                                            <div class="form-group-float position-relative ">
                                                <input type="text" name="title"
                                                    class="form-control custom-input float-input @error('title') custom-input-error @enderror"
                                                    id="title" placeholder=" "
                                                    value="{{ old('title', $Category->title) }}" />
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
                                        form="editQCForm{{ $Category->id }}">{{ trans('Teacher_trans.save') }}</button>
                                    <button type="button" class="btn btn-secondary custom-cancel-btn"
                                        data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- delete QC Modal -->
                    <div class="modal fade" id="deleteModal-category{{ $Category->id }}" tabindex="-1"
                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="{{ trans('main_trans.close') }}"></button>
                                </div>
                                <form id="deleteQCForm{{ $Category->id }}"
                                    action="{{ route('QuestionsCategotry.destroy', $Category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body text-center">
                                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                        <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                    </div>

                                    <div class="modal-footer justify-content-center">
                                        <button type="submit" form="deleteQCForm{{ $Category->id }}"
                                            class="btn btn-del">{{ trans('Grades_trans.submit') }}</button>
                                        <button type="button" class="btn btn-cancel"
                                            data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{-- search input code --}}
    <script>
        document.getElementById('QCSearch').addEventListener('input', function() {
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
