
$(document).on('click', '.editRole', function () {

    let role = $(this).data('item');
    $('#RoleId').val(role.id);
    $('.editName').val(role.name);
    $("#editRole").modal('show');

});


$(document).on('click', '.deleteRole', function () {
    let id = $(this).data('id');
    $('#roleDeleteId').val(id);
    $("#deleteRole").modal('show');
});

$(".editTitle").on('input', function(){
    let title = $(".editTitle").val();
  $(".editSlug").val(convertToSlug(title));
});

$(".addTitle").on('input', function(){
    let title = $(".addTitle").val();
  $(".addSlug").val(convertToSlug(title));
});

function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}
