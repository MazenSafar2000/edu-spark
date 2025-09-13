<div class="widget">
    <h3>{{ trans('main_trans.subjects') }}</h3>
    <ul>
        @foreach ($subjects as $subject)
            <li><a href="{{ route('student.subject.materials', $subject->id) }}">
                    <span class="course-name">{{ $subject->subject->name }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>
