$(".toggle-password").click(function () {

    var input = $(this).closest('.input-group').find('input');

    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});
$(".imgBrowse").change(function (e) {
    e.preventDefault();
    var file = $(this).closest('.primary_file_uploader').find('.imgName');
    var filename = $(this).val().split('\\').pop();
    file.val(filename);
});

$(document).on('click', '.editAdmin', function () {
    let admin_id = $(this).data('item-id');
    let url = $('#url').val();
    url = url + '/admin/get-user-data/' + admin_id
    let token = $('.csrf_token').val();

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            '_token': token,
        },
        success: function (admin) {
            $('#adminId').val(admin.id);
            $('#adminName').val(admin.name);
            $('#adminAbout').summernote("code", admin.about);
            $('#adminDob').val(admin.dob);
            $('#adminPhone').val(admin.phone);
            $('#role_id_edit').val(admin.role_id);
            $('#role_id_edit').niceSelect('update');
            $('.country_codeedit').val(admin.country_code);
            $('#adminGender').val(admin.gender);
            $('#adminGender').niceSelect('update');
            $('#adminEmail').val(admin.email);
            $('#adminImage').val(admin.image);
            $("#editAdmin").modal('show');
        },
        error: function (data) {
            toastr.error('Something Went Wrong', 'Error');
        }
    });


});


$(document).on('click', '.deleteAdmin', function () {
    let id = $(this).data('id');
    $('#adminDeleteId').val(id);
    $("#deleteAdmin").modal('show');
})

$(document).on('click', '#add_admin_btn', function () {
    $('#addName').val('');
    $('#addAbout').html('');
    $('#startDate').val('');
    $('#addPhone').val('');
    $('#addEmail').val('');
    $('#addPassword').val('');
    $('#addCpassword').val('');
    $('#addFacebook').val('');
    $('#addTwitter').val('');
    $('#addLinked').val('');
    $('#addInstagram').val('');
});
