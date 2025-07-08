@extends('layouts.app')
@section('title', 'Slider')

@section('content')
    <div class="card-head-icon">
        <i class='bx bxs-image' style="color: rgb(128, 7, 133);"></i>
        <div>Sliders</div>
    </div>

    <div class="card mt-3">
        <div class="d-flex justify-content-between m-3">
            <span>Sliders List</span>
            @can('image_slider_create')
                <a href="{{ route('content-management.image-sliders.create') }}" class="btn btn-primary text-decoration-none text-white"><i
                        class='bx bxs-plus-circle me-2'></i>
                    Create New Slider</a>
            @endcan
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped w-100" id="DataTable">
                <thead>
                    <th class="no-sort"></th>
                    <th>Image</th>
                    <th>Image Order No</th>
                    <th class="no-sort text-nowrap">Action</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/content/image_slider.js')}}"></script>
@endsection
