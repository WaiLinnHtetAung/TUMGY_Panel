@extends('layouts.app')
@section('title', 'Create New News & Events')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-notepad' style="color: rgb(128, 7, 133);"></i>
        <div>News & Events Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4"> News & Events Creation</span>

       @include('content_management.news_event.form')
    </div>
@endsection

@section('scripts')
    <script>
        Dropzone.autoDiscover = false;
        let news_event_images = []
    </script>
    <script src="{{asset('js/content/news_event.js')}}"></script>
@endsection
