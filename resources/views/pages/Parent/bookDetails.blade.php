@extends('layouts.main.parent_dashboard')
@section('parent_content')
    <div class="parentContent">
        <div class="container">
            <div class="preview-box">
                <div class="preview-header">
                    {{ trans('Teacher_trans.viewBook') }}
                </div>
                <div class="preview-content">
                    <div class="preview-row">
                        <div class="preview-label">{{ trans('Teacher_trans.book_name') }}</div>
                        <div class="preview-value">{{ $book->title }}</div>
                    </div>

                    <div class="preview-row">
                        <div class="preview-label">{{ trans('Teacher_trans.subject') }}</div>
                        <div class="preview-value">{{ $book->subject->name }}</div>
                    </div>

                    <div class="preview-row">
                        <div class="preview-label">{{ trans('main_trans.Date_added') }}</div>
                        <div class="preview-value">{{ $book->created_at }}</div>
                    </div>

                    <div class="preview-buttons d-flex  gap-3">
                        <a href="{{ asset('storage/attachments/library/teachers/' . $book->teacher->user->National_ID . '/' . $book->file_name) }}" class="btn preview-start-btn" target="_blank">
                            <i class="fas fa-download ms-1"></i> {{ trans('Students_trans.Download') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
