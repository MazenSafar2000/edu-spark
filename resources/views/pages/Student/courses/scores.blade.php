@extends('layouts.main.student_dashboard')
@section('student-content')
    <div id="mainContent" class="transition-all with-sidebar">

        <div class="container mt-5">
            <div class="page-title">
                <h2> {{ trans('main_trans.scores') }} - <span>{{ $teacher_section->subject->name }}</span></h2>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-center custom-mark">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('main_trans.name') }}</th>
                            <th>{{ trans('main_trans.final_score') }}</th>
                            <th>{{ trans('Students_trans.Feedback') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $i => $row)
                            <tr class="custom-row">
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $row['title'] }}</td>
                                <td>
                                    @if ($row['score'])
                                        <span class="mark-present">{{ $row['score'] }}</span>
                                    @else
                                        <span class="mark-missing">{{ trans('main_trans.Not_observed') }}</span>
                                    @endif
                                </td>
                                <td>{{ $row['feedback'] ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">{{ trans('main_trans.no_data') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
