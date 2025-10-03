@extends('layouts.main.student_dashboard')
@section('student-content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <div class="container exam-preview-container">
            <div class="exam-preview-title text-center">
                <h4>
                    <span class="preview-title-text fw-bold">{{ trans('Students_trans.preview_VideoClass') }}</span>
                </h4>
            </div>

            <div class="preview-wrapper p-4">
                <div class="preview-card">
                    <h5 class="exam-title">{{ $class->title }}</h5>

                    <ul class="list-unstyled exam-description">
                        <li><strong>{{ trans('Students_trans.subject') }} :</strong> {{ $class->subject->name }}</li>
                        <li><strong>{{ trans('main_trans.Name_Teacher') }} :</strong>{{ $class->teacher->user->name }}
                        </li>
                        <li><strong>{{ trans('Students_trans.class_description') }} :</strong> {{ $class->description }}
                        </li>
                        <li>
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
                                    <div class="video-container d-flex justify-content-center align-items-center"
                                        style="min-height: 60vh;">
                                        <iframe width="800" height="450"
                                            src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
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
                                    <div class="video-container d-flex justify-content-center" style="width: 100%;">
                                        <div
                                            style="position: relative; width: 100%; max-width: 800px; padding-top: 56.25%;">
                                            <iframe src="https://drive.google.com/file/d/{{ $driveId }}/preview"
                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                                                frameborder="0" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                @else
                                    <p class="alert alert-danger text-danger">
                                        {{ trans('Students_trans.cant_open_drive_video') }}</p>
                                @endif
                            @else
                                <div class="text-center">
                                    <p class="alert alert-danger text-danger">{{ trans('Students_trans.Not_supported') }}</p>
                                    <a href="{{ $url }}" target="_blank"
                                        class="btn btn-lg btn-outline-success">{{ trans('Students_trans.open_video') }}</a>
                                </div>
                            @endif

                        </li>
                    </ul>


                </div>
            </div>
        </div>

        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
