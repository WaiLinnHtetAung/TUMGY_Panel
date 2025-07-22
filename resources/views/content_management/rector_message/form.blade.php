<form id="{{request()->is('content-management/rector-messages/create') ? 'rector_message_create_form' : 'rector_message_edit_form'}}">
    @csrf
    <div class="row">
        <input type="hidden" name="rector_message_id" id="rector_message_id" value="{{isset($rector_message) ? $rector_message->id : null}}">
         <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
            <div class="form-group mb-4">
                <label for="">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" value="{{isset($rector_message) ? $rector_message->name : ''}}" class="form-control name">
                <span class="text-danger name_err"></span>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Rector's Image <span class="text-danger">*</span></label>
                <input type="file" name="image" class="form-control image" value="" >
                <span class="text-danger image_err"></span>
                <img src="{{isset($rector_message) ? asset('storage'.$rector_message->image) :  ''}}" class="mt-2" width="150"  style="object-fit: cover;" alt="" id="preview_img">
            </div>
        </div>

        <div class="col-12 col-md-8">
            <div class="form-group mb-4">
                <label for="">Message </label>
                <textarea name="message" id="" cols="30" rows="5" class="form-control message" placeholder="Write message ...">{{isset($rector_message) ? $rector_message->message : ''}}</textarea>
                <span class="text-danger message_err"></span>
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
