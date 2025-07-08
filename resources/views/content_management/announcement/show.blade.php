@extends('layouts.app')
@section('title', 'Announcement Detail')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-megaphone' style="color: rgb(128, 7, 133);"></i>
        <div>Announcement Detail</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Announcement Detail</span>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="DataTable">
                <tr>
                    <th width="25%">ID</th>
                    <td>{{ $announcement->id }}</td>
                </tr>
                <tr>
                    <th>Title</th>
                    <td>{{ $announcement->title }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $announcement->date }}</td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        @if($announcement->image)
                            <img src="{{ asset('storage/' . $announcement->image) }}" width="100" />
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Document</th>
                    <td>
                        @if($announcement->document)
                            <a href="{{ asset('storage/' . $announcement->document) }}" target="_blank">
                                <img src="{{ asset('assets/images/pdf_icon.png') }}" width="40" class="me-2" />
                                View
                            </a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Content</th>
                    <td>{!!$announcement->content !!}</td>
                </tr>

            </table>
            <button class="btn btn-outline-secondary mt-3 back-btn">Back to List</button>
        </div>
    </div>
@endsection
