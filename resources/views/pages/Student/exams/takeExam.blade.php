@extends('layouts.main.exam_layout')

@section('exam-content')
    <livewire:student-take-exam :attempt-id="$attemptId" :exam-id="$examId" />
@endsection
