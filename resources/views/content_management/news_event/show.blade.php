@extends('layouts.app')
@section('title', 'News & Events Detail')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-megaphone' style="color: rgb(128, 7, 133);"></i>
        <div>News & Events Detail</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>News & Events Detail</span>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="DataTable">
                <tr>
                    <th width="25%">ID</th>
                    <td>{{ $news_event->id }}</td>
                </tr>
                <tr>
                    <th>Title</th>
                    <td>{{ $news_event->title }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $news_event->date }}</td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td>{{ $news_event->type }}</td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        @if($news_event->image)
                            <img src="{{ asset('storage/' . $news_event->image) }}" width="100" />
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Gallery Images</th>
                    <td>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($news_event->images as $file)
                                <img style="width: 120px; object-fit: cover;" src="{{asset('storage/'. $file->image)}}" alt="">
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Content</th>
                    <td>{!!$news_event->content !!}</td>
                </tr>

            </table>
            <button class="btn btn-outline-secondary mt-3 back-btn">Back to List</button>
        </div>
    </div>
@endsection
