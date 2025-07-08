<form id="{{request()->is('content-management/announcements/create') ? 'announcement_create_form' : 'announcement_edit_form'}}">
    @csrf
    <div class="row">
        <input type="hidden" name="announcement_id" id="announcement_id" value="{{isset($announcement) ? $announcement->id : null}}">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control title" value="{{ old('title', isset($announcement) ? $announcement->title : null) }}">
                <span class="text-danger title_err"></span>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Date <span class="text-danger">*</span></label>
                <input type="text" name="date" id="date" value="{{isset($announcement) ? $announcement->date : ''}}" placeholder="YYYY-MM-DD" class="form-control date">
                <span class="text-danger date_err"></span>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Image</label>
                <input type="file" name="image" class="form-control image" value="" >
                <span class="text-danger image_err"></span>
                <img src="{{isset($announcement) ? asset('storage'.$announcement->image) :  ''}}" class="mt-2" width="150"  style="object-fit: cover;" alt="" id="preview_img">
            </div>
        </div>

        <div class="col-md-4 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Document <span class="fw-bold text-danger">(Pdf)</span></label>
                <input type="file" name="document" class="form-control document" accept=".pdf">
                <span class="text-danger document_err"></span>

                @if(isset($announcement) && $announcement->document)
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $announcement->document) }}" target="_blank">
                            <img src="{{ asset('assets/images/pdf_icon.png') }}" width="40" alt="PDF Icon">
                            Current Document
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 col-md-8">
            <div class="form-group mb-4">
                <label for="">Content </label>
                <textarea name="content" id="" cols="30" rows="5" class="form-control content" placeholder="Write content ...">{{isset($announcement) ? $announcement->content : ''}}</textarea>
                <span class="text-danger content_err"></span>
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
