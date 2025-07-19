@extends('layouts.main.student_dashboard')
@section('student-content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <div class="container exam-preview-container">
            <div class="exam-preview-title text-center">
                <h4>
                    <span class="preview-title-text fw-bold">معاينة </span>
                    <span class="preview-title-highlight fw-bold">الدرس</span>
                </h4>
            </div>

            <div class="preview-wrapper p-4">
                <div class="preview-card">
                    <h5 class="exam-title">{{ $class->title }} </h5>

                    <ul class="list-unstyled exam-description">
                        <li><strong>{{ trans('Students_trans.subject') }} :</strong>{{ $class->subject->name }}</li>
                        <li><strong>{{ trans('Sections_trans.Name_Teacher') }}:</strong>{{ $class->teacher->user->name }}
                        </li>
                        <li><strong> {{ trans('Students_trans.class_description') }} :</strong> {{ $class->description }}
                        </li>
                        <li>
                            {{-- <video controls class="w-100 rounded shadow">
                <source src="../images/vid-1.mp4" type="video/mp4">
                المتصفح لا يدعم تشغيل الفيديو.
              </video> --}}

                            @php
                                $url = $class->video_url;
                            @endphp
                            <!-- YouTube View -->
                            @if (Str::contains($url, 'youtube.com') || Str::contains($url, 'youtu.be'))
                                @php
                                    // استخراج ID الفيديو
                                    preg_match('/(youtu\.be\/|v=)([^&]+)/', $url, $matches);
                                    $youtubeId = $matches[2] ?? null;
                                @endphp

                                @if ($youtubeId)
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item"
                                            src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                            allowfullscreen></iframe>
                                    </div>
                                @else
                                    <p class="text-danger">{{ trans('Students_trans.cant_open_youtube_video') }}</p>
                                @endif

                                <!-- Drive View -->
                            @elseif (Str::contains($url, 'drive.google.com'))
                                @php
                                    preg_match('/\/d\/(.*?)\//', $url, $matches);
                                    $driveId = $matches[1] ?? null;
                                @endphp

                                @if ($driveId)
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item"
                                            src="https://drive.google.com/file/d/{{ $driveId }}/preview"
                                            allowfullscreen></iframe>
                                    </div>
                                @else
                                    <p class="text-danger">{{ trans('Students_trans.cant_open_drive_video') }}</p>
                                @endif
                            @else
                                <!-- Other links View -->
                                <a href="{{ $url }}" target="_blank"
                                    class="btn btn-info">{{ trans('Students_trans.open_video') }}</a>
                            @endif

                        </li>
                    </ul>


                </div>
            </div>
        </div>

        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
