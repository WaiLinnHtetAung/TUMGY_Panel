@extends('layouts.app')
@section('title', 'Edit Thesis')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-graduation' style="color: rgb(11, 133, 7);"></i>
        <div>Thesis Edition</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Thesis Edition </span>

       @include('thesis_management.thesis.form')
    </div>
@endsection

@section('scripts')
    <script>
        let departmentSlug = {!! json_encode($department_slug)!!}
    </script>
    <script src="{{asset('js/thesis/thesis.js')}}"></script>
@endsection
