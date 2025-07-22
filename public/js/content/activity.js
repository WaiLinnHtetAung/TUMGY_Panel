$(document).ready(function() {
    $(document).on('change', '.image', function(e) {
        if (this.files && this.files[0]) {
            let reader = new FileReader();

            reader.onload = function(e) {
                $('#preview_img').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }
    });

    const domainName = `${window.location.protocol}//${window.location.host}`;
    const dropzone_store_url = `${domainName}/content-management/storeMedia`;
    const dropzone_del_url = `${domainName}/content-management/deleteMedia`;

    let uploadedImageMap = {}
    $("#news-event-image-dropzone").dropzone({
        url: dropzone_store_url,
        maxFilesize: 20,
        addRemoveLinks: true,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        },
        success: function (file, response) {
            $("form").append(
                '<input type="hidden" name="images[]" value="' +
                    response.name +
                    '">'
            );
            uploadedImageMap[file.name] = response.name;
        },
        removedfile: function (file) {
            file.previewElement.remove();
            file.previewElement.remove();
            let name =
                file.file_name || uploadedImageMap[file.name];
            $(
                'input[name="images[]"][value="' + name + '"]'
            ).remove();

            $.ajax({
                url: dropzone_del_url,
                method: "POST",
                data: {
                    file_name: name,
                },
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content"),
                },
                success: function (response) {
                    console.log(
                        "File deleted successfully:",
                        response
                    );
                },
                error: function (xhr, status, error) {
                    console.error(
                        "Error deleting file:",
                        error
                    );
                },
            });
        },
        init: function () {
            if (activity_images.length > 0) {
                for (const img of activity_images) {
                    // Create a mock file object for Dropzone
                    var file = {
                        file_name: img.image_name, // Extract the file name from the path
                        size: 2000000, // Set an approximate size (adjust as needed)
                        accepted: true,
                    };

                    // Add the file to Dropzone's files array
                    this.files.push(file);

                    // Emit the Dropzone events to add the file visually
                    this.emit("addedfile", file); // Notify Dropzone about the new file
                    this.emit("thumbnail", file, img.image_path); // Set the thumbnail image
                    this.emit("complete", file); // Mark the file as complete

                    // Append a hidden input to the form to retain the image on submission
                    $("form").append(
                        '<input type="hidden" name="images[]" value="' + img.image_name + '">'
                    );

                    // Map the uploaded image for Dropzone's internal tracking
                    uploadedImageMap[file.file_name] = img.image_path;

                    // Adjust thumbnail styles for proper display
                    const previewElement = file.previewElement;
                    if (previewElement) {
                        const thumbnailElement = previewElement.querySelector(".dz-image img");
                        if (thumbnailElement) {
                            thumbnailElement.style.maxWidth = "100%";
                            thumbnailElement.style.height = "100%";
                            thumbnailElement.style.objectFit = "cover";
                        }
                    }
                }
            }
        },

    });

    let date = $('.date');
    if(date) {
        date.flatpickr({
            enableTime: false,
            dateFormat: "Y-m-d",
        })
    }

    let contentEl = document.querySelector( '.content' );

    if(contentEl) {
        ClassicEditor
            .create(contentEl)
            .catch( error => {
            console.error( error );
        });
    }

    const table = new DataTable('#DataTable', {
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: '/content-management/activities-list',
        columns: [{
                data: 'plus-icon',
                name: 'plus-icon'
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'image',
                name: 'image'
            },
            {
                data: 'content',
                name: 'content'
            },
            {
                data: 'images',
                name: 'images'
            },
            {
                data: 'action',
                name: 'action'
            },
        ],
        columnDefs: [{
            targets: 'no-sort',
            sortable: false,
            searchable: false
        }, {
            targets: [0],
            class: 'control'
        }]
    })

     //submit create form
     $(document).on('submit', '#activity_create_form', function(e) {
        e.preventDefault();

        const field_status = check_fields_validation();
        if(!field_status) {
            return;
        }

        ask_confirm().then(result => {
            if(result.isConfirmed) {
                let formData = new FormData($('#activity_create_form')[0]);

                $.ajax({
                    url: "/content-management/activities",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (res) {
                        console.log(res);
                        if (res == "success") {
                            window.location.href = "/content-management/activities";
                        } else {
                            warning_alert('Something Wrong !')
                        }
                    },
                    error: function (xhr, status, err) {
                        //validation error
                        if (xhr.status === 422) {
                            let noti = ``;
                            for (const key in xhr.responseJSON.errors) {
                                console.log(xhr.responseJSON.errors[key][0]);
                                noti += `
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    ${xhr.responseJSON.errors[key][0]}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            `;
                            }

                            $(".error").html(noti);

                            toast_error("Something went wrong !");

                            // Scroll to the top of the browser window
                            $("html, body").animate({ scrollTop: 0 });
                        } else {
                            toast_error("Something wrong");
                        }
                    },
                })
            }
        })

    })

    //submit edit form
    $(document).on('submit', '#activity_edit_form', function(e) {
        e.preventDefault();

        const field_status = check_fields_validation();
        if(!field_status) {
            return;
        }

        ask_confirm().then(result => {
            if(result.isConfirmed) {
                let formData = new FormData($('#activity_edit_form')[0]);
                let id = $('#activity_id').val();

                $.ajax({
                    url: "/content-management/update-activities/"+id,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (res) {
                        console.log(res);
                        if (res == "success") {
                            window.location.href = "/content-management/activities";
                        }
                    },
                    error: function (xhr, status, err) {
                        //validation error
                        if (xhr.status === 422) {
                            let noti = ``;
                            for (const key in xhr.responseJSON.errors) {
                                console.log(xhr.responseJSON.errors[key][0]);
                                noti += `
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    ${xhr.responseJSON.errors[key][0]}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            `;
                            }

                            $(".error").html(noti);

                            toast_error("Something went wrong !");

                            // Scroll to the top of the browser window
                            $("html, body").animate({ scrollTop: 0 });
                        } else {
                            toast_error("Something wrong");
                        }
                    },
                })
            }
        })

    })

    //delete function
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();

        let id = $(this).data('id');

        if(id) {
            ask_confirm('Are you sure to delete ?').then(result => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: "/content-management/activities/" + id,
                        type: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function(res) {
                            if(res == 'success') {
                                toast_success('Success !')
                                table.ajax.reload();
                            }
                        }
                    })
                }
            })
        }
    })

    const check_fields_validation = () => {
        let status = true;

        let activity_id = $('#activity_id').val();

        let names = [
            activity_id ? null : "image",
            "title",
            "date",
            "content"
        ];

        let err = [];

        names.forEach((name) => {
            if(name) {
                if ($(`.${name}`).val() == "" || $(`.${name}`).val() == null) {
                    $(`.${name}_err`).html("Need to be filled");
                    err.push(name);
                } else {
                    $(`.${name}_err`).html(" ");
                    if (err.includes(name)) {
                        err.splice(err.indexOf(`${name}`), 1);
                    }
                }
            }
        });

        if (err.length > 0) {
            toast_error("Please fill require fields !");
            window.scrollTo(0, 0);
            status = false;
        }

        if(err.length == 0) {
            status = true;
        }

        return status
    }
})
