<form id="{{request()->is('admin/departments/create') ? 'department_create_form' : 'department_edit_form'}}">
    @csrf
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
            <input type="hidden" name="department_id" id="department_id" value="{{isset($department) ? $department->id : null}}">
            <div class="form-group mb-4">
                <label for="">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control name" value="{{ old('name', isset($department) ? $department->name : null) }}">
                <span class="text-danger name_err"></span>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 col-12">
            <div class="form-group mb-4">
                <label for="">Logo <span class="text-danger">*</span></label>
                <input type="file" name="logo" class="form-control logo" value="" >
                <span class="text-danger logo_err"></span>
                <img src="{{isset($department) ? asset('storage'.$department->logo) :  ''}}" class="mt-2" width="150"  style="object-fit: cover;" alt="" id="preview_img">
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
