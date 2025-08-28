<table style="width:50%; border-collapse:collapse; font-family:Arial, sans-serif; margin:auto; text-align:right">
    <tr style="background-color:#f9f9f9">
        <th style="padding:8px; border:1px solid #ccc">{{ trans('Teacher_trans.homework_title') }}:</th>
        <td style="padding:8px; border:1px solid #ccc">{{ $homework->title }}</td>
    </tr>
    <tr>
        <th style="padding:8px; border:1px solid #ccc">{{ trans('main_trans.teacher_name') }}:</th>
        <td style="padding:8px; border:1px solid #ccc">{{ $homework->teacher->user->name ?? '-' }}</td>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('main_trans.student_name') }}</th>
            <th>{{ trans('main_trans.Grade') }}</th>
            <th>{{ trans('main_trans.classroom') }}</th>
            <th>{{ trans('main_trans.section') }}</th>
            <th>{{ trans('main_trans.status') }}</th>
            <th>{{ trans('main_trans.final_score') }}</th>
            <th>{{ trans('Teacher_trans.Feedback') }}</th>
            <th>{{ trans('main_trans.Delivery_date') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $index => $student)
            @php
                $submission = $submissions[$student->id] ?? null;
                $status = $submission ? trans('Teacher_trans.Delivered') : trans('Teacher_trans.Not_delivered');
                $degree = $submission->degree ?? ($status === 'Not Submitted' ? 0 : null);
                $feedback = $submission->feedback ?? '-';
                $date = $submission ? \Carbon\Carbon::parse($submission->submitted_at)->format('d-m-Y H:i') : '-';
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $student->user->name }}</td>
                <td>{{ $student->grade->Name ?? '-' }}</td>
                <td>{{ $student->classroom->Name_Class ?? '-' }}</td>
                <td>{{ $student->section->Name_Section ?? '-' }}</td>
                <td>{{ $status }}</td>
                <td>{{ $degree }}</td>
                <td>{{ $feedback }}</td>
                <td>{{ $date }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
