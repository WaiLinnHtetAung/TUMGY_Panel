@extends('layouts.app')
@section('title', 'Activity')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-run' style="color: rgb(128, 7, 133);"></i>
        <div>Activity</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Activity List</span>
            @can('activity_create')
                <a href="{{ route('content-management.activities.create') }}" class="btn btn-primary text-decoration-none text-white"><i
                        class='bx bxs-plus-circle me-2'></i>
                    Create New Activity</a>
            @endcan
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>Title</th>
                    <th>Date</th>
                    <th class="no-sort">Image</th>
                    <th class="no-sort">Content</th>
                    <th class="no-sort">Activity Images</th>
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content/activity.js')}}"></script>
@endsection
