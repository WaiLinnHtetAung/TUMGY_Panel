@extends('layouts.app')
@section('title', 'Create Department')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-layer' style="color: rgb(128, 7, 133);"></i>
        <div>Department Creation</div>
    </div>
    <div class="card mt-3 p-4">
        <span class="mb-4">Department Creation</span>

       @include('admin.department.form')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/admin/department.js')}}"></script>
@endsection
