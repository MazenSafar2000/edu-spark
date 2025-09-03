@extends('layouts.main.parent_dashboard')
@section('parent_content')
    <div class="parentContent">
        <div class="container">
            <div class="preview-box">
                <div class="preview-header">
                    {{ trans('Students_trans.preview_VideoClass') }}
                </div>
                <div class="preview-content">
                    <div class="preview-row">
                        <div class="preview-label">عنوان الدرس :</div>
                        <div class="preview-value">{{ $class->title }}</div>
                    </div>

                    <div class="preview-row">
                        <div class="preview-label">{{ trans('Students_trans.subject') }}:</div>
                        <div class="preview-value">{{ $class->subject->name }}</div>
                    </div>

                    <div class="preview-row">
                        <div class="preview-label">{{ trans('Students_trans.class_description') }} :</div>
                        <div class="preview-value">{{ $class->description }}</div>
                    </div>

                    <div class="preview-row-feedback">
                        <div>
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
                                    <p class="alert alert-danger text-danger">{{ trans('Students_trans.Not_supported') }}
                                    </p>
                                    <a href="{{ $url }}" target="_blank"
                                        class="btn btn-lg btn-outline-success">{{ trans('Students_trans.open_video') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
