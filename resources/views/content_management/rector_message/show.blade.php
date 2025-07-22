@extends('layouts.app')
@section('title', 'Rector Message Detail')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-message-rounded-dots' style="color: rgb(128, 7, 133);"></i>
        <div>Rector Message Detail</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Rector Message Detail</span>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="DataTable">
                <tr>
                    <th width="25%">ID</th>
                    <td>{{ $rector_message->id }}</td>
                </tr>
                <tr>
                    <th>Title</th>
                    <td>{{ $rector_message->name }}</td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        @if($rector_message->image)
                            <img src="{{ asset('storage/' . $rector_message->image) }}" width="100" />
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Message</th>
                    <td>{!!$rector_message->message !!}</td>
                </tr>

            </table>
            <button class="btn btn-outline-secondary mt-3 back-btn">Back to List</button>
        </div>
    </div>
@endsection
