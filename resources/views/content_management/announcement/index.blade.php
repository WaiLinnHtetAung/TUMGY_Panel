@extends('layouts.app')
@section('title', 'Announcement')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-megaphone' style="color: rgb(128, 7, 133);"></i>
        <div>Announcement</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Announcement List</span>
            @can('announcement_create')
                <a href="{{ route('content-management.announcements.create') }}" class="btn btn-primary text-decoration-none text-white"><i
                        class='bx bxs-plus-circle me-2'></i>
                    Create New Announcement</a>
            @endcan
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>Title</th>
                    <th>Date</th>
                    <th class="no-sort">Image</th>
                    <th class="no-sort">Document</th>
                    <th class="no-sort">Content</th>
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content/announcement.js')}}"></script>
@endsection
