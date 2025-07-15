@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <!-- المحتوى الرئيسي -->
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header">{{ trans('main_trans.Parents') }}</h3>

        <div class="table-users mt-5">
            <!-- المحتوى -->
            <div class="table-content tab-content" id="myTabContent">
                <!-- الطلاب -->
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="header-table">
                        <a href="{{ route('Parents.create') }}">{{ trans('main_trans.Add_Parent') }}</a>
                        <input type="search" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>
                    <div class="table-responsive">
                        <table class="table text-center custom-user-table">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Parent_trans.name') }}</th>
                                    <th>{{ trans('Parent_trans.Email') }}</th>
                                    <th>{{ trans('Parent_trans.Phone_Father') }}</th>
                                    <th>{{ trans('Parent_trans.Job_Father') }}</th>
                                    <th>{{ trans('Parent_trans.Processes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parents as $parent)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $parent->user->name }}</td>
                                        <td>{{ $parent->user->email }}</td>
                                        <td>{{ $parent->Phone_Father }}</td>
                                        <td>{{ $parent->Job_Father }}</td>
                                        <td class="position-relative">
                                            <div class="dropdown">
                                                <button class="btn operations-btn dropdown-toggle" type="button"
                                                    id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{ trans('main_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu operations-dropdown text-end"
                                                    aria-labelledby="operationsDropdown">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="manager-data-parent.html">
                                                            <i class="fa-solid fa-eye text-success"></i>
                                                            {{ trans('main_trans.View_data') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="{{ route('Parents.edit', $parent->id) }}">
                                                            <i class="fas fa-edit text-primary"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $parent->id }}">
                                                            <i class="fas fa-trash-alt text-danger"></i>
                                                            {{ trans('main_trans.delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <!--  delete parent modal  -->
                                    <div class="modal fade" id="deleteModal{{ $parent->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="{{ trans('My_Classes_trans.Close') }}"></button>
                                                </div>
                                                <form action="{{ route('Parents.destroy', $parent->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <div class="modal-body text-center">
                                                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                        <p>{{ trans('main_trans.Delete_Parent_Warning') }}</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="submit"
                                                            class="btn btn-del">{{ trans('Grades_trans.submit') }}</button>
                                                        <button type="button" class="btn btn-cancel"
                                                            data-bs-dismiss="modal">{{ trans('My_Classes_trans.Close') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
