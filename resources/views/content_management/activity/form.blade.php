<form id="{{request()->is('content-management/activities/create') ? 'activity_create_form' : 'activity_edit_form'}}">
    @csrf
    <div class="row">
        <input type="hidden" name="activity_id" id="activity_id" value="{{isset($activity) ? $activity->id : null}}">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control title" value="{{ old('title', isset($activity) ? $activity->title : null) }}">
                <span class="text-danger title_err"></span>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Date <span class="text-danger">*</span></label>
                <input type="text" name="date" id="date" value="{{isset($activity) ? $activity->date : ''}}" placeholder="YYYY-MM-DD" class="form-control date">
                <span class="text-danger date_err"></span>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Image <span class="text-danger">*</span></label>
                <input type="file" name="image" class="form-control image" value="" >
                <span class="text-danger image_err"></span>
                <img src="{{isset($activity) ? asset('storage'.$activity->image) :  ''}}" class="mt-2" width="150"  style="object-fit: cover;" alt="" id="preview_img">
            </div>
        </div>

        <div class="col-md-8 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Activity Images</label>
                <div class="needslick dropzone" id="news-event-image-dropzone">

                </div>
                <span class="text-danger images_err"></span>
            </div>
        </div>

        <div class="col-md-8 col-sm-12 col-12 ">
            <div class="form-group mb-4">
                <label for="">Activity Content </label>
                <textarea name="content" id="" cols="30" rows="5" class="form-control content" placeholder="Write content ...">{{isset($activity) ? $activity->content : ''}}</textarea>
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
