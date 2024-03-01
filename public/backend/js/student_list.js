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

$(document).on('click', '.viewLearnerProfile', function () {
    $("#viewLearnerProfile").modal('show');
});
$(document).on('click', '.editStudent', function () {
    let student_id = $(this).data('item-id');
    let url = $('#url').val();
    url = url + '/admin/get-user-data/' + student_id
    let token = $('.csrf_token').val();
    $('#race_other_input').val();
    $('#race_otheredit').hide();
    $('#not_workingedit').hide();
    $('#business_natureedit').hide();
    $('#job_designationedit').hide();
    $('#sectoredit').hide();
    $('#sector_otheredit').hide();

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            '_token': token,
        },
        success: function (student) {
            $('#studentId').val(student.id);
            $('#studentName').val(student.name);
            $('#studentAbout').summernote("code", student.about);
            $('#studentDob').val(student.dob);
            $('#studentPhone').val(student.phone);
            $('.country_codeedit').val(student.country_code);
            $('#studentEmail').val(student.email);
            $('#studentGender').val(student.gender);
            $('#studentGender').niceSelect('update');
            $('#studentRaceedit').val(student.race);
            $('#studentRaceedit').niceSelect('update');
            $('#zipedit').val(student.zip);
            $('#nricnumber').val(student.identification_number);
            if(student.race=='Others'){
                $('#race_other_input').val(student.race_other);
                $('#race_otheredit').show();
            }
            $('#employment_statusedit').val(student.employment_status);
            $('#employment_statusedit').niceSelect('update');
            if(student.employment_status=='working'){
                $('#job_designationedit').show();
                $('#sectoredit').show();
            }else if(student.employment_status=='not-working'){
                $('#not_workingedit').show();
            }else{
                $('#business_natureedit').show();
            }
            $('.citizenshipedit').val(student.citizenship);
            $('.citizenshipedit').niceSelect('update');
            if(student.citizenship=='Malaysian'){
                $('.raceeditdiv').show();
            }else{
                $('.nationalityeditdiv').show();
            }
            $('.business_natureedit').val(student.business_nature);
             $('.business_natureedit').niceSelect('update');
              if(student.business_nature=='Others'){
                $('#business_nature_otheredit').show();
            }
            $('#studentnationality').val(student.nationality);
            $('#studentnationality').niceSelect('update');
            $('#not_working').val(student.not_working);
            $('#not_working').niceSelect('update');
            $('.sectoredit').val(student.sector);
            $('.sectoredit').niceSelect('update');
            if(student.sector=='Others'){
                $('#sector_otheredit').show();
            }
            $('#sector_otherinput').val(student.sector_other);
            $('#job_designationinput').val(student.job_designation);
            $('#job_designationinput').niceSelect('update');

            $('#business_nature_otherinput').val(student.business_nature_other);
            $('#highest_academic').val(student.highest_academic);
            $('#highest_academic').niceSelect('update');
            $('#current_residing').val(student.current_residing);
            $('#current_residing').niceSelect('update');
            $('#studentImage').val(student.image);
            $('#studentFacebook').val(student.facebook);
            $('#studentTwitter').val(student.twitter);
            $('#studentLinkedin').val(student.linkedin);
            $('#studentYoutube').val(student.youtube);
            $("#editStudent").modal('show');
        },
        error: function (data) {
            toastr.error('Something Went Wrong', 'Error');
        }
    });



});


$(document).on('click', '.deleteStudent', function () {
    let id = $(this).data('id');
    $('#studentDeleteId').val(id);
    $("#deleteStudent").modal('show');
});
$(document).on('click', '.impersonateStudent', function () {
    let id = $(this).data('id');
    $('#studentImpersonateId').val(id);
    $("#impersonateStudent").modal('show');
});
$(document).on('click', '.notificationstudent', function () {
    console.log('notificationstudent');
    let id = $(this).data('id');
    $('#learner_id').val(id);
    $("#notificationstudent").modal('show');
});
$(document).on('click', '.sendEmailStudent', function () {
    let id = $(this).data('id');
    $('#studentSendEmailId').val(id);
    $("#sendEmailStudent").modal('show');
});
$(document).on('click', '.resetPasswordStudent', function () {
    let id = $(this).data('id');
    $('#studentResetPasswordId').val(id);
    $("#resetPasswordStudent").modal('show');
});


$(document).on('click', '#add_student_btn', function () {
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
    $('#addYoutube').val('');
});


