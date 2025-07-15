 @extends('layouts.main.manager_dashboard')
 @section('manager_content')
     <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

         <h3 class="header-data-std">{{ trans('Students_trans.Student_details') }}</h3>

         <div class="student-data">

             <ul class="nav nav-tabs mb-3 nav-std-data" id="myTab" role="tablist">
                 <li class="nav-item" role="presentation">
                     <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#details"
                         type="button" role="tab">{{ trans('Students_trans.Student_details') }}</button>
                 </li>
                 <li class="nav-item" role="presentation">
                     <button class="nav-link" id="teachers-tab" data-bs-toggle="tab" data-bs-target="#attachment"
                         type="button" role="tab">{{ trans('Students_trans.Attachments') }}</button>
                 </li>
             </ul>

             <div class="table-users mt-5">
                 <!-- المحتوى -->
                 @if (session()->has('error'))
                     <div class="alert alert-danger alert-dismissible fade show" role="alert">
                         <strong>{{ session()->get('error') }}</strong>
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                 @endif
                 <div class="table-content tab-content" id="myTabContent">
                     <div class="tab-pane fade show active" id="details" role="tabpanel">
                         <div class="container">
                             <div class="student-table table-responsive">
                                 <table class="table table-bordered mb-0">
                                     <tbody>
                                         <tr>
                                             <td>{{ trans('Students_trans.name') }}</td>
                                             <td> {{ $Student->user->name }} </td>
                                         </tr>
                                         {{-- <tr>
                                             <td> رقم الهوية</td>
                                             <td>876543234567</td>
                                         </tr> --}}
                                         <tr>
                                             <td>{{ trans('Students_trans.email') }}</td>
                                             <td>{{ $Student->user->email }} </td>
                                         </tr>
                                         <tr>
                                             <td>{{ trans('Parent_trans.Name_Father') }}</td>
                                             <td> {{ $Student->myparent->user->name }} </td>
                                         </tr>
                                         <tr>
                                             <td>{{ trans('Parent_trans.Phone_Father') }}</td>
                                             <td>{{ $Student->myparent->Phone_Father }}</td>
                                         </tr>
                                         <tr>
                                             <td>{{ trans('Teacher_trans.Gender') }}</td>
                                             <td>{{ $Student->gender->Name }}</td>
                                         </tr>
                                         <tr>
                                             <td>{{ trans('main_trans.Grade') }}</td>
                                             <td> {{ $Student->grade->Name }} </td>
                                         </tr>
                                         <tr>
                                             <td>{{ trans('main_trans.classroom') }}</td>
                                             <td> {{ $Student->classroom->Name_Class }} </td>
                                         </tr>
                                         <tr>
                                             <td>{{ trans('main_trans.section') }}</td>
                                             <td> {{ $Student->section->Name_Section }} </td>
                                         </tr>
                                         <tr>
                                             <td>{{ trans('main_trans.Date_of_Birth') }}</td>
                                             <td> {{ $Student->Date_Birth }} </td>
                                         </tr>
                                         <tr>
                                             <td>{{ trans('main_trans.academic_year') }}</td>
                                             <td> {{ $Student->academic_year }} </td>
                                         </tr>
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>

                     <div class="tab-pane fade" id="attachment" role="tabpanel">
                         <div class="container">
                             <!-- خانة رفع الملف -->
                             <form action="{{ route('Images.store') }}" method="POST" enctype="multipart/form-data">
                                 @csrf

                                 <div class="mb-3">
                                     <label for="fileUpload" class="form-label fw-bold text-danger label-attachment">
                                         {{ trans('Students_trans.Attachments') }}:
                                     </label>

                                     <input type="file" accept="image/*" name="photos[]" multiple
                                         class="form-control file-attachment @error('photos.*') is-invalid @enderror">

                                     {{-- Display validation errors --}}
                                     @if ($errors->has('photos'))
                                         <div class="invalid-feedback d-block">
                                             {{ $errors->first('photos') }}
                                         </div>
                                     @endif
                                     @if ($errors->has('photos.*'))
                                         @foreach ($errors->get('photos.*') as $error)
                                             <div class="invalid-feedback d-block">{{ $error[0] }}</div>
                                         @endforeach
                                     @endif

                                     <input type="hidden" name="student_name"
                                         value="{{ $Student->user->getTranslation('name', 'en') }}">
                                     <input type="hidden" name="student_id" value="{{ $Student->id }}">
                                 </div>

                                 <button type="submit" class="btn btn-upload mb-4 btn-outline-success">{{ trans('Grades_trans.submit') }}</button>
                             </form>


                             <!-- زر التأكيد -->

                             <!-- جدول الملفات -->
                             <div class="table-responsive">
                                 <table class="table table-attachment table-bordered align-middle">
                                     <thead>
                                         <tr>
                                             <th>#</th>
                                             <th scope="col">{{ trans('Students_trans.filename') }}</th>
                                             <th scope="col">{{ trans('Students_trans.created_at') }}</th>
                                             <th scope="col">{{ trans('Students_trans.Processes') }}</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @foreach ($Student->images as $attachment)
                                             <tr>
                                                 <td>{{ $loop->iteration }}</td>
                                                 <td>{{ $attachment->filename }}</td>
                                                 <td>{{ $attachment->created_at->diffForHumans() }}</td>
                                                 <td>
                                                     <a href="{{ url('Download_attachment') }}/{{ $attachment->imageable->user->name }}/{{ $attachment->filename }}"
                                                         class="btn btn-sm btn-download"><i
                                                             class="fa-solid fa-download"></i>{{ trans('Students_trans.Download') }}</a>
                                                     <a class="btn btn-sm btn-delete" data-bs-toggle="modal"
                                                         data-bs-target="#deleteAttachmentModal{{ $attachment->id }}"><i
                                                             class="fas fa-trash-alt"></i>{{ trans('main_trans.delete') }}</a>
                                                 </td>
                                             </tr>

                                             <!-- Modal حذف المرحلة -->
                                             <div class="modal fade" id="deleteAttachmentModal{{ $attachment->id }}"
                                                 tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                 <div class="modal-dialog modal-dialog-centered">
                                                     <form action="{{ route('Images.destroy', $attachment->id) }}"
                                                         method="POST">
                                                         @csrf
                                                         @method('DELETE')

                                                         <div class="modal-content">
                                                             <div class="modal-header">
                                                                 <button type="button" class="btn-close"
                                                                     data-bs-dismiss="modal"
                                                                     aria-label="{{ trans('Grades_trans.Close') }}"></button>
                                                             </div>
                                                             <div class="modal-body text-center">
                                                                 <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                                 <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                                             </div>
                                                             <div class="modal-footer justify-content-center">
                                                                 <button type="submin"
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
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <br><br>
     <br><br>
 @endsection
