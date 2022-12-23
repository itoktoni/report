@once
@push('footer')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function showModal(url, size) {
    size = (typeof size == 'undefined' || size == '') ? 'modal-lg' : size;
    var title = $('.page-title').text();
    $.ajax({
        url: url,
        success: function(response) {

            $('#modal-body').html(response);
            $('.modal-title').text(title);
            $('#modal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('.modal-dialog').addClass(size);

            $(".flatpickr-calendar").not(':first').remove();
        },
        complete: function() {
            // $('#loader').hide();
        },
        error: function(jqXHR, testStatus, error) {
            swal.fire({
                icon : 'error',
                title : 'Error!',
                text : error,
            });
        },
        timeout: 8000
    });
}

// Make sure only one backdrop is rendered
$(document).on('show.bs.modal', '.modal', function () {
    if ($(".modal-backdrop").length > 1) {
        $(".modal-backdrop").not(':first').remove();
        $(".flatpickr-calendar").not(':first').remove();
    }
});
// Remove all backdrop on close
$(document).on('hide.bs.modal', '.modal', function () {
    if ($(".modal-backdrop").length > 1) {
        $(".modal-backdrop").remove();
        $(".flatpickr-calendar").remove();
    }
});

$('body').on('click', '.button-update', function(event) {
    event.preventDefault();
    showModal($(this).attr('href'), $(this).attr('size'));
});

$('body').on('click', '.button-create', function(event) {
    event.preventDefault();
    showModal($(this).attr('href'), $(this).attr('size'));
});

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

$('body').on('click', '.button-delete', function(event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr('href'),
        id = url.substring(url.indexOf('=') + 1),
        csrf_token = $('meta[name="csrf-token"]').attr('content');

    swal.fire({
        title: '{{ __("Anda yakin ingin menghapus ?") }}',
        text: '{{ __("Data akan hilang setelah dihapus!") }}',
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#ff1111',
        cancelButtonColor: '#f8bb86',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "POST",
                dataType: 'json',
                data: {
                    'id': id
                },
                success: function(response) {
                    if (response.status) {
                        swal.fire({
                            icon: 'success',
                            title: '{{ __("Success!") }}',
                            text: '{{ __("Data has been deleted!") }}',
                            timer: 3000
                        }).then(function() {
                            window.location.reload();
                        });

                    } else if (response.status == false) {
                        swal.fire({
                            icon: 'error',
                            title: '{{ __("Error!") }}',
                            text: response.data
                        });
                    } else {
                        swal.fire({
                            icon: 'error',
                            title: '{{ __("Error!") }}',
                            text: '{{ __("Data failed to deleted!") }}'
                        });
                    }
                },
                error: function(xhr, status, error) {

                    if (xhr.status == 422) {

                        swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '{{ __("Validation Error !") }}'
                        });
                    } else {
                        swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '{{ __("Something went wrong!") }}'
                        });
                    }
                }
            });
        } else {

        }
    });
});

$('body').on('click', '.button-delete-all', function(event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr('href'),
        id = me.attr('data'),
        csrf_token = $('meta[name="csrf-token"]').attr('content');

    var data = [];
    $('.checkbox').each(function() {
        if ($(this).is(":checked")) {
            data.push($(this).val());
        }
    });

    if(data.length == 0){
        swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Select Data terlebih dahulu !'
        });

        return;
    }

    swal.fire({
        title: 'Anda yakin ingin menghapus ?',
        text: 'Data akan hilang setelah dihapus!',
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#ff1111',
        cancelButtonColor: '#f8bb86',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "POST",
                dataType: 'json',
                data: {
                    'code': data
                },
                success: function(response) {
                    if (response.status) {
                        swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Data has been deleted!',
                            timer: 3000
                        }).then(function() {
                            window.location.reload();
                        });

                    } else if (response.status == false) {
                        swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.data
                        });
                    } else {
                        swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Data failed to deleted!'
                        });
                    }
                },
                error: function(xhr, status, error) {

                    if (xhr.status == 422) {

                        swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Validation Error !'
                        });
                    } else {
                        swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });
                    }
                }
            });
        } else {

        }
    });
});
</script>
@endpush
@endonce