@extends('layouts.app')
@section('title', 'Create New Slider')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-image' style="color: rgb(128, 7, 133);"></i>
        <div>New Slider Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">New Slider Creation</span>

       @include('content_management.image_slider.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content/image_slider.js')}}"></script>
@endsection
