$(document).ready(function () {
    //$("#order,  .type,  .language, .level, .rating").on('change keyup paste', function (e) {
    //    ApplyFilter();
    //});

    //$('.duration, .content_provider').keypress(function (e) {
    //    var key = e.which;
    //    if(key == 13)  // the enter key code
    //    {
    //        ApplyFilter();
    //    }
    //});

    //$('#contentprovider').on('change', function(){
    //        ApplyFilter();
    //    })


    //    $('.duration_range').click(function (e) {
    //        console.log('welcome');
    //        ApplyFilter();
    //    });

    $('.price_range').click(function (e) {
        ApplyFilter();
    });

    // $('.search_category').click(function (e) {
    //     ApplyFilter();
    // });
});

//$('.search_category').click(function (e) {
//        ApplyFilter();
//    });

function ApplyFilter() {
    var order = $('#order').find(":selected").val();
    let url = $('.class_route').val();
    let search = $('.search').val();
    var type = [];
    $('.type:checked').each(function (i) {
        type[i] = $(this).val();
    });
    url += '/?type=' + type.toString();

    var language = [];
    $('.language:checked').each(function (i) {
        language[i] = $(this).val();
    });
    url += '&language=' + language.toString();


    var level = [];
    $('.level:checked').each(function (i) {
        level[i] = $(this).val();
    });
    url += '&level=' + level.toString();

    var category = [];
    $('.category:checked').each(function (i) {
        category[i] = $(this).val();
    });
    url += '&category=' + category.toString();
    url += '&order=' + order.toString();

    var ratings = [];
    $('.rating:checked').each(function (i) {
        ratings[i] = $(this).val();
    });
    url += '&ratings=' + ratings.toString();

    var version = [];
    $('.version:checked').each(function (i) {
        version[i] = $(this).val();
    });
    url += '&version=' + version.toString();

    var duration = '';
    duration = $('.duration').val();
    if(duration != undefined){
        url += '&duration=' + duration.toString();
    }

    var durationrange = '';
        durationrange = $('.duration_range').val();
        url += '&durationRange=' + durationrange.toString();

    var startduration = '';
        startduration = $('.start_duration').val();
        url += '&startDuration=' + startduration.toString();

    var endduration = '';
        endduration = $('.end_duration').val();
        url += '&endDuration=' + endduration.toString();

    /*var content_provider = '';
    content_provider = $('.content_provider').val();
    url += '&content_provider=' + content_provider.toString();*/
    var content_provider = '';
        content_provider = $('#contentprovider').val();
        url += '&content_provider=' + content_provider.toString();

    var start_price = '';
    start_price = $('.start_price').val();
    url += '&startprice=' + start_price.toString();

    var end_price = '';
    end_price = $('.end_price').val();
    url += '&endprice=' + end_price.toString();

    if (search != "") {
        url += '&query=' + search;
    }
    /*console.log('url = '+url);
    return false;*/
    window.location.href = url;

}
