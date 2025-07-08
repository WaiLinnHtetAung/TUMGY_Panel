@extends('layouts.app')
@section('title', 'Create New Announcement')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-megaphone' style="color: rgb(128, 7, 133);"></i>
        <div>New Announcement Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">New Announcement Creation</span>

       @include('content_management.announcement.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content/announcement.js')}}"></script>
@endsection
