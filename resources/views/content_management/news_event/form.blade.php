<form id="{{request()->is('content-management/news-events/create') ? 'new_event_create_form' : 'new_event_edit_form'}}">
    @csrf
    <div class="row">
        <input type="hidden" name="new_event_id" id="new_event_id" value="{{isset($news_event) ? $news_event->id : null}}">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control title" value="{{ old('title', isset($news_event) ? $news_event->title : null) }}">
                <span class="text-danger title_err"></span>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Date <span class="text-danger">*</span></label>
                <input type="text" name="date" id="date" value="{{isset($news_event) ? $news_event->date : ''}}" placeholder="YYYY-MM-DD" class="form-control date">
                <span class="text-danger date_err"></span>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Type <span class="text-danger">*</span></label>
                <select name="type" id=""  class="form-select select2 type" data-placeholder="---Please Select---">
                    <option value=""></option>
                    <option value="News" {{isset($news_event) ? ($news_event->type == 'News' ? 'selected' : '') : ''}}>News</option>
                    <option value="Event" {{isset($news_event) ? ($news_event->type == 'Event' ? 'selected' : '') : ''}}>Event</option>
                </select>
                <span class="text-danger logo_err"></span>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Image</label>
                <input type="file" name="image" class="form-control image" value="" >
                <span class="text-danger image_err"></span>
                <img src="{{isset($news_event) ? asset('storage'.$news_event->image) :  ''}}" class="mt-2" width="150"  style="object-fit: cover;" alt="" id="preview_img">
            </div>
        </div>

        <div class="col-md-8 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Gallery Images</label>
                <div class="needslick dropzone" id="news-event-image-dropzone">

                </div>
                <span class="text-danger images_err"></span>
            </div>
        </div>

        <div class="col-12 ">
            <div class="form-group mb-4">
                <label for="">Content </label>
                <textarea name="content" id="" cols="30" rows="5" class="form-control content" placeholder="Write content ...">{{isset($news_event) ? $news_event->content : ''}}</textarea>
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
