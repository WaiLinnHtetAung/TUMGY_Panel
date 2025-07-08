@extends('layouts.app')
@section('title', 'Edit News & Event')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-megaphone' style="color: rgb(128, 7, 133);"></i>
        <div>News & Event Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">News & Event Edition</span>

       @include('content_management.news_event.form')
    </div>
@endsection

@section('scripts')
    <script>
        Dropzone.autoDiscover = false;
        let news_event_images = {!! json_encode($news_event_images)!!}
    </script>
    <script src="{{asset('js/content/news_event.js')}}"></script>
@endsection
