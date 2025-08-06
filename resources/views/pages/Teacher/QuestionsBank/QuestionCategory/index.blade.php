@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <div class="table-users-teacher mt-5">
            <!-- المحتوى -->
            <div class="table-content-teacher tab-content" id="myTabContent">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="header-table-teacher">
                        <a href="" data-bs-toggle="modal"
                            data-bs-target="#createQCModal">{{ trans('Teacher_trans.new_Category') }}</a>
                        <input type="search" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">

                    </div>
                    <div class="table-responsive">
                        <table class="table text-center custom-user-table-teacher">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Teacher_trans.Category') }} </th>
                                    <th>{{ trans('Teacher_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questionCategories as $Category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $Category->title }}</td>
                                        <td class="position-relative">
                                            <div class="dropdown">
                                                <button class="btn operations-btn dropdown-toggle" type="button"
                                                    id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{ trans('main_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end operations-dropdown text-end"
                                                    aria-labelledby="operationsDropdown">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                            href="" data-bs-toggle="modal"
                                                            data-bs-target="#editQCModal{{ $Category->id }}">
                                                            <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteQCategory{{ $Category->id }}">
                                                            <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                            {{ trans('main_trans.delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <!--  delete homework modal  -->
                                    <div class="modal fade" id="deleteQCategory{{ $Category->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('questionsCategotry.destroy', $Category->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="{{ trans('Grades_trans.Close') }}"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                        <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="submit"
                                                            class="btn btn-del">{{ trans('Grades_trans.submit') }}</button>
                                                        <button type="button" class="btn btn-cancel"
                                                            data-bs-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- create QCategory modal --}}
                        <div class="modal fade custom-modal" id="createQCModal" tabindex="-1"
                            aria-labelledby="createQCModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                                <div class="modal-content custom-modal-content">

                                    <div class="modal-header custom-modal-header">
                                        <h5 class="modal-title custom-modal-title" id="createQCModalLabel">
                                            {{ trans('Sections_trans.createQC') }}</h5>
                                    </div>

                                    <div class="modal-body custom-modal-body">
                                        <form class="subject-form" action="{{ route('questionsCategotry.store') }}"
                                            method="POST" class="custom-form">
                                            @csrf

                                            <div class="row mb-3">
                                                <div class="form-group-float position-relative ">
                                                    <input type="text" name="title"
                                                        class="form-control custom-input float-input" id="title"
                                                        placeholder=" " />
                                                    @error('title')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                    <label for="title"
                                                        class="float-label">{{ trans('Teacher_trans.homework_title') }}*</label>
                                                </div>
                                            </div>

                                            <div class="text-end">
                                                <button type="submit"
                                                    class="btn save-btn">{{ trans('Teacher_trans.Create_Homework') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach ($questionCategories as $Category)
                            {{-- edit QCategory modal --}}
                            <div class="modal fade custom-modal" id="editQCModal{{ $Category->id }}" tabindex="-1"
                                aria-labelledby="editQCModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                                    <div class="modal-content custom-modal-content">

                                        <div class="modal-header custom-modal-header">
                                            <h5 class="modal-title custom-modal-title" id="editQCModalLabel">
                                                {{ trans('Sections_trans.createQC') }}</h5>
                                        </div>

                                        <div class="modal-body custom-modal-body">
                                            <form class=""
                                                action="{{ route('questionsCategotry.update', $Category->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="row mb-3">
                                                    <div class="form-group-float position-relative ">
                                                        <input type="text" name="title"
                                                            class="form-control custom-input float-input" id="title"
                                                            value="{{ old('title', $Category->title) }}" />
                                                        @error(' ')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                        <label for="title"
                                                            class="float-label">{{ trans('Teacher_trans.homework_title') }}*</label>
                                                    </div>
                                                </div>

                                                <div class="text-end">
                                                    <button type="submit"
                                                        class="btn save-btn">{{ trans('Teacher_trans.Create_Homework') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
