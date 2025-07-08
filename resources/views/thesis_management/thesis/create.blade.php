@extends('layouts.app')
@section('title', 'Create Thesis')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-graduation' style="color: rgb(11, 133, 7);"></i>
        <div>Thesis Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Thesis Creation </span>

       @include('thesis_management.thesis.form')
    </div>
@endsection

@section('scripts')
    <script>
        let departmentSlug = {!! json_encode($department_slug)!!}
    </script>
    <script src="{{asset('js/thesis/thesis.js')}}"></script>
@endsection
