@extends('layouts.app')
@section('title', 'Ec Thesis')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-graduation' style="color: rgb(11, 133, 7);"></i>
        <div>Thesis</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Thesis List</span>
            {{-- @can('brand_create') --}}
                <a href="{{ route('thesis-management.thesis.create') }}?department={{ $department_slug }}" class="btn btn-primary text-decoration-none text-white"><i
                        class='bx bxs-plus-circle me-2'></i>
                    Create New Thesis</a>
            {{-- @endcan --}}
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>Title</th>
                    <th>Department</th>
                    <th>Author</th>
                    <th>Roll No</th>
                    <th>Submission Year</th>
                    <th>Submission Month</th>
                    <th class="no-sort">File</th>
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let departmentSlug = {!! json_encode($department_slug)!!}
    </script>
    <script src="{{asset('js/thesis/thesis.js')}}"></script>
@endsection
