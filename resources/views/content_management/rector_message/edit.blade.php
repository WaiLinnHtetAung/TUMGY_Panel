@extends('layouts.app')
@section('title', 'Edit Rector Message')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-image' style="color: rgb(128, 7, 133);"></i>
        <div>Rector Message Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Rector Message Edition</span>

       @include('content_management.rector_message.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content/rector_message.js')}}"></script>
@endsection
