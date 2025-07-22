@extends('layouts.app')
@section('title', 'Create New Activity')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-run' style="color: rgb(128, 7, 133);"></i>
        <div>Activity Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4"> Activity Creation</span>

       @include('content_management.activity.form')
    </div>
@endsection

@section('scripts')
    <script>
        Dropzone.autoDiscover = false;
        let activity_images = []
    </script>
    <script src="{{asset('js/content/activity.js')}}"></script>
@endsection
