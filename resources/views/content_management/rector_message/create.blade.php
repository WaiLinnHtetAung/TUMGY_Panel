@extends('layouts.app')
@section('title', 'Create New Rector Messages')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-message-rounded-dots' style="color: rgb(128, 7, 133);"></i>
        <div>New Rector Messages Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">New Rector Messages Creation</span>

       @include('content_management.rector_message.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content/rector_message.js')}}"></script>
@endsection
