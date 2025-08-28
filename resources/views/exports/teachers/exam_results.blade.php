<table style="width:50%; border-collapse:collapse; font-family:Arial, sans-serif; margin:auto; text-align:right">
    <tr style="background-color:#f9f9f9">
        <th style="padding:8px; border:1px solid #ccc">{{ trans('main_trans.exam_name') }}:</th>
        <td style="padding:8px; border:1px solid #ccc">{{ $exam->name }}</td>
    </tr>
    <tr>
        <th style="padding:8px; border:1px solid #ccc">{{ trans('main_trans.teacher_name') }}:</th>
        <td style="padding:8px; border:1px solid #ccc">{{ $exam->teacher->user->name ?? '-' }}</td>
    </tr>
    <tr style="background-color:#f9f9f9">
        <th style="padding:8px; border:1px solid #ccc">{{ trans('main_trans.number_students_section') }}:</th>
        <td style="padding:8px; border:1px solid #ccc">{{ $students->count() }}</td>
    </tr>
    <tr>
        <th style="padding:8px; border:1px solid #ccc">{{ trans('main_trans.number_students_tested') }}:</th>
        <td style="padding:8px; border:1px solid #ccc">{{ $testedStudents }}</td>
    </tr>
    <tr style="background-color:#f9f9f9">
        <th style="padding:8px; border:1px solid #ccc">{{ trans('main_trans.number_student_success') }}:</th>
        <td style="padding:8px; border:1px solid #ccc">{{ $passed }}</td>
    </tr>
    <tr>
        <th style="padding:8px; border:1px solid #ccc">{{ trans('main_trans.number_student_failed') }}:</th>
        <td style="padding:8px; border:1px solid #ccc">{{ $failed }}</td>
    </tr>
</table>

<table border="1" style="width:100%; border-collapse:collapse; text-align:center; font-family:Arial, sans-serif">
    <thead style="background-color:#f2f2f2">
        <tr>
            <th>#</th>
            <th>{{ trans('main_trans.student_name') }}</th>
            <th>{{ trans('main_trans.Grade') }}</th>
            <th>{{ trans('main_trans.classroom') }}</th>
            <th>{{ trans('main_trans.section') }}</th>
            <th>{{ trans('main_trans.number_attempt') }}</th>
            <th>{{ trans('main_trans.final_score') }}</th>
            <th>{{ trans('main_trans.status') }}</th>
            <th>{{ trans('main_trans.Delivery_date') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $index => $student)
            @php
                $manualDegree = $degrees[$student->id] ?? null;
                $lastAttempt  = $lastAttempts[$student->id] ?? null;

                $attemptCount = $lastAttempt ? ($attempts[$student->id]->count() ?? 0) : 0;

                // Use manual grade first, then attempt grade
                $grade = $manualDegree->score ?? $lastAttempt->grade_obtained ?? null;
                $date  = $manualDegree->date ?? $lastAttempt->ended_at ?? null;

                $status = $grade === null
                    ? trans('main_trans.not_examed')
                    : ($grade >= $exam->maximum_grade * 0.5
                        ? trans('main_trans.successful')
                        : trans('main_trans.Failed'));
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->grade->Name ?? '-' }}</td>
                <td>{{ $student->classroom->Name_Class ?? '-' }}</td>
                <td>{{ $student->section->Name_Section ?? '-' }}</td>
                <td>{{ $attemptCount }}</td>
                <td>{{ $grade ?? '-' }}</td>
                <td>{{ $status }}</td>
                <td>{{ $date ? \Carbon\Carbon::parse($date)->format('d-m-Y h:ia') : '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
