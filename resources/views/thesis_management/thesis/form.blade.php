<form id="{{request()->is('thesis-management/thesis/create') ? 'thesis_create_form' : 'thesis_edit_form'}}">
    @csrf
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <input type="hidden" name="thesis_id" id="thesis_id" value="{{isset($thesi) ? $thesi->id : null}}">
            <input type="hidden" name="department_slug" id="department_slug" value="{{$department_slug}}">
            <div class="form-group mb-4">
                <label for="">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control title" value="{{ old('title', isset($thesi) ? $thesi->title : null) }}">
                <span class="text-danger title_err"></span>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Department <span class="text-danger">*</span></label>
                <select name="department_id" id=""  class="form-select select2 department_id" data-placeholder="---Please Select---">
                    <option value=""></option>
                    @foreach ($departments as $department)
                        <option value="{{$department->id}}" {{isset($thesi) ? ($thesi->department_id == $department->id ? 'selected' : 'disabled') : ($department->slug == $department_slug ? 'selected' : 'disabled')}}>{{$department->name}}</option>
                    @endforeach
                </select>
                <span class="text-danger logo_err"></span>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Author Name <span class="text-danger">*</span></label>
                <input type="text" name="author" class="form-control author" value="{{ old('author', isset($thesi) ? $thesi->author : null) }}">
                <span class="text-danger author_err"></span>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Roll No <span class="text-danger">*</span></label>
                <input type="text" name="roll_no" class="form-control roll_no" value="{{ old('roll_no', isset($thesi) ? $thesi->roll_no : null) }}">
                <span class="text-danger roll_no_err"></span>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 col-12" >
            <div class="form-group mb-4">
                <label for="">Submission Year <span class="text-danger">*</span></label>
                <div class="d-flex align-items-center gap-3">
                    <div class="w-50">
                        <select name="submission_year" id=""  class="form-select select2 submission_year" data-placeholder="---Please Select---">
                            <option value=""></option>
                            @foreach ($years as $year)
                                <option value="{{$year}}" {{isset($thesi) ? ($thesi->submission_year == $year ? 'selected' : '') :
                                    ''}}>{{$year}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger submission_year_err"></span>
                    </div>
                    <i class='bx bx-minus'></i>
                    <div class="w-50">
                        <select name="submission_month" id=""  class="form-select select2 submission_month" data-placeholder="---Please Select---">
                            <option value=""></option>
                            @foreach ($months as $month)
                                <option value="{{$month}}" {{isset($thesi) ? ($thesi->submission_month == $month ? 'selected' : '') :
                                    ''}}>{{$month}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger submission_month_err"></span>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-4 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Thesis File <span class="fw-bold text-danger">Zip</span> </label>
                <input type="file" name="file" class="form-control file" accept=".zip">
                <span class="text-danger file_err"></span>

                @if(isset($thesi) && $thesi->file)
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $thesi->file) }}" target="_blank">
                            <img src="{{ asset('assets/images/zip_icon.png') }}" width="40" alt="PDF Icon">
                            Current File
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="mt-5">
        <div class="d-flex  gap-2">
            <button class="btn btn-secondary back-btn">Cancel</button>
            <button class="btn btn-primary">Save</button>
        </div>
    </div>
</form>
