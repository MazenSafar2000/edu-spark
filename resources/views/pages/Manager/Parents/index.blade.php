@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <!-- المحتوى الرئيسي -->
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header"> {{ trans('main_trans.Parents') }}</h3>
        <div class="title-underline-manager"></div>

        <div class="table-users mt-5">
            <!-- المحتوى -->
            <div class="table-content tab-content" id="myTabContent">
                <!-- الطلاب -->
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="header-table">
                        <a href="{{ route('Parents.create') }}">{{ trans('main_trans.Add_Parent') }}</a>
                        <input type="text" class="form-control search-input" id="ParentSearch"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>
                    <div class="table-responsive manager-table-wrapper">
                        <table class="text-center manager-grade-table" id="datatable">
                            <thead class="thead-manager">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Parent_trans.name') }}</th>
                                    <th>{{ trans('main_trans.National_ID') }}</th>
                                    <th>{{ trans('Parent_trans.Email') }}</th>
                                    <th>{{ trans('Parent_trans.Phone_Father') }}</th>
                                    <th>{{ trans('Parent_trans.Job_Father') }}</th>
                                    <th>{{ trans('Parent_trans.Processes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parents as $parent)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $parent->user->name }}</td>
                                        <td>{{ $parent->user->National_ID }}</td>
                                        <td>{{ $parent->user->email }}</td>
                                        <td>{{ $parent->Phone_Father }}</td>
                                        <td>{{ $parent->Job_Father }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="dropdown-toggle operations-btn" data-bs-toggle="dropdown">
                                                    {{ trans('main_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu operations-btn-item">
                                                    {{-- <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="manager-data-parent.html">
                                                            <i class="fas fa-eye action-icon eye-icon-action"></i>
                                                            {{ trans('main_trans.View_data') }}
                                                        </a>
                                                    </li> --}}

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="{{ route('Parents.edit', $parent->id) }}">
                                                            <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $parent->id }}">
                                                            <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
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
                                                <form id="deleteParentForm{{ $parent->id }}"
                                                    action="{{ route('Parents.destroy', $parent->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body text-center">
                                                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                        <p>{{ trans('main_trans.Delete_Parent_Warning') }}</p>
                                                    </div>
                                                </form>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="submit" form="deleteParentForm{{ $parent->id }}"
                                                        class="btn btn-del">{{ trans('main_trans.submit') }}</button>
                                                    <button type="button" class="btn btn-cancel"
                                                        data-bs-dismiss="modal">{{ trans('My_Classes_trans.Close') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $parents->links('vendor.pagination.custom') }}
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- search input code --}}
    <script>
        document.getElementById('ParentSearch').addEventListener('input', function() {
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
