@extends('layouts.app')
@section('title', 'News & Events')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-notepad' style="color: rgb(128, 7, 133);"></i>
        <div>News & Events</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>News & Events List</span>
            @can('news_event_create')
                <a href="{{ route('content-management.news-events.create') }}" class="btn btn-primary text-decoration-none text-white"><i
                        class='bx bxs-plus-circle me-2'></i>
                    Create New News & Events</a>
            @endcan
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th class="no-sort">Image</th>
                    <th class="no-sort">Content</th>
                    <th class="no-sort">Gallery Images</th>
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content/news_event.js')}}"></script>
@endsection
