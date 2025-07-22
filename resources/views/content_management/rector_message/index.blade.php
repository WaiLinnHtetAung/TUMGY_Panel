@extends('layouts.app')
@section('title', 'Rector Message')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-message-rounded-dots' style="color: rgb(128, 7, 133);"></i>
        <div>Rector Messages</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Rector Messages List</span>
            @can('rector_message_create')
                @if ($count < 1)
                    <a href="{{ route('content-management.rector-messages.create') }}" class="btn btn-primary text-decoration-none text-white"><i
                        class='bx bxs-plus-circle me-2'></i>
                    Create New Messages</a>
                @endif
            @endcan
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Message</th>
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content/rector_message.js')}}"></script>
@endsection
