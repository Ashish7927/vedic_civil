$("#categoryFilter").on('change', function () {
    let category = this.value;
    let cource = $("#courceFilter").val();
    let version = $("#versionFilter").val();
    let site = $('#siteUrl').val();
    window.location.replace(site + "?category=" + category + "&version=" + version);

});

$("#courceFilter").on('change', function () {
    let category = $("#categoryFilter").val();
    let version = $("#versionFilter").val();
    let cource = this.value;
    let site = $('#siteUrl').val();
    window.location.replace(site + "?cource=" + cource);
});

$("#versionFilter").on('change', function () {
    let category = $("#categoryFilter").val();
    let cource = $("#courceFilter").val();
    let version = this.value;
    let site = $('#siteUrl').val();
    if((category == '' && cource == '') || (category == undefined && cource == undefined))
        window.location.replace(site + "?version=" + version);
    else
        window.location.replace(site + "?category=" + category + "&version=" + version);
});