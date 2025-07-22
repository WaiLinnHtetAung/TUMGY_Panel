@extends('layouts.app')
@section('title', 'Activity Detail')

@section('content')
    <div class="card-head-icon">
        <i class='bx bx-run' style="color: rgb(128, 7, 133);"></i>
        <div>Activity Detail</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Activity Detail</span>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="DataTable">
                <tr>
                    <th width="25%">ID</th>
                    <td>{{ $activity->id }}</td>
                </tr>
                <tr>
                    <th>Title</th>
                    <td>{{ $activity->title }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $activity->date }}</td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        @if($activity->image)
                            <img src="{{ asset('storage/' . $activity->image) }}" width="100" />
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Activity Images</th>
                    <td>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($activity->images as $file)
                                <img style="width: 120px; object-fit: cover;" src="{{asset('storage/'. $file->image)}}" alt="">
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Content</th>
                    <td>{!!$activity->content !!}</td>
                </tr>

            </table>
            <button class="btn btn-outline-secondary mt-3 back-btn">Back to List</button>
        </div>
    </div>
@endsection
