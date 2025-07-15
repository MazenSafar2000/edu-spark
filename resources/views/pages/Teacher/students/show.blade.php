@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
     <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

         <h3 class="header-data-std">{{ trans('Students_trans.Student_details') }}</h3>

         <div class="student-data">

             <ul class="nav nav-tabs mb-3 nav-std-data" id="myTab" role="tablist">
                 <li class="nav-item" role="presentation">
                     <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#details"
                         type="button" role="tab">{{ trans('Students_trans.Student_details') }}</button>
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
                 </div>
             </div>
         </div>
     </div>
     <br><br>
     <br><br>
 @endsection
