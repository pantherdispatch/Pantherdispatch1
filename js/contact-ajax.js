function validate() {
    var valid = true;
    $(".alert-danger").remove();
    $(".required:visible").each(function() {
        if ($(this).val() == "" || $(this).val() === null || ($(this).attr('type') == "radio" && $('[name="' + $(this).attr('name') + '"]:checked').val() == undefined)) {
            $(this)
                .closest("div")
                .append('<div class="alert-danger">This field is required</div>');
            valid = false;
        }
    });
    if (!valid) {
        $("html, body").animate({
                scrollTop: $(".alert-danger:first").offset().top - 80,
            },
            100
        );
    }
    return valid;
}


$(document).on('submit', '.submition-form', function(e) {
    e.preventDefault();
    if (!validate())
        return false;
    var form = $(this);
    var data = new FormData(this);
    $(form).find('button[type="submit"]').prop('disabled', true);
    $.ajax({
        type: 'POST',
        data: data,
        cache: !1,
        contentType: !1,
        processData: !1,
        url: $(form).attr('action'),
        async: true,
        headers: {
            "cache-control": "no-cache"
        },
        success: function(response) {
            // updatePage(update_url, target);
            // $(form).closest('#modal').modal('hide');
            $(form).find('button[type="button"]').prop('disabled', true);
            toastr.success(response.success);
        },
        error: function(xhr, status, error) {
            if (xhr.status == 422) {
                $(form).find('div.alert').remove();
                var errorObj = xhr.responseJSON.errors;
                $.map(errorObj, function(value, index) {
                    var appendIn = $(form).find('[name="' + index + '"]').closest('div');
                    if (!appendIn.length) {
                        //toastr.error(value[0]);
                    } else {
                        $(appendIn).append('<div class="alert alert-danger" style="padding: 1px 5px;font-size: 12px"> ' + value[0] + '</div>')
                    }
                });
                $(form).find('button[type="submit"]').prop('disabled', false);
            } else {
                //toastr.error('Unknown Error!');
                $(form).find('button[type="submit"]').prop('disabled', false);
            }
        }
    });
});
