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
        ajax: '/content-management/announcement-list',
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
                data: 'document',
                name: 'document'
            },
            {
                data: 'content',
                name: 'content'
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
     $(document).on('submit', '#announcement_create_form', function(e) {
        e.preventDefault();

        const field_status = check_fields_validation();
        if(!field_status) {
            return;
        }

        ask_confirm().then(result => {
            if(result.isConfirmed) {
                let formData = new FormData($('#announcement_create_form')[0]);

                $.ajax({
                    url: "/content-management/announcements",
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
                            window.location.href = "/content-management/announcements";
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
    $(document).on('submit', '#announcement_edit_form', function(e) {
        e.preventDefault();

        const field_status = check_fields_validation();
        if(!field_status) {
            return;
        }

        ask_confirm().then(result => {
            if(result.isConfirmed) {
                let formData = new FormData($('#announcement_edit_form')[0]);
                let id = $('#announcement_id').val();

                $.ajax({
                    url: "/content-management/update-announcement/"+id,
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
                            window.location.href = "/content-management/announcements";
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
                        url: "/content-management/announcements/" + id,
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

        let announcement_id = $('#announcement_id').val();

        let names = [
            announcement_id ? null : "image",
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
