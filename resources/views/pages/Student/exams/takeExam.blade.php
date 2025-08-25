@extends('layouts.main.student_dashboard')

@section('student-content')
    <livewire:student-take-exam :attempt-id="$attemptId" :exam-id="$examId" />
@endsection
