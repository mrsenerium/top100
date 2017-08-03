$(function() {
    var perPage = getParameterByName('perPage');
    if(perPage !== null)
        $('#perPage').val(perPage);
    var nominated = getParameterByName('nominated');
    if(nominated !== null)
        $('#nominated').val(nominated);
    var disqualified = getParameterByName('disqualified');
    if(disqualified !== null)
        $('#disqualified').val(disqualified);
    var submitted = getParameterByName('submitted');
    if(submitted !== null)
        $('#submitted').val(submitted);
    var top100 = getParameterByName('top100');
    if(top100 !== null)
        $('#top100').val(top100);
    $('#filter-form select').on('change', function () {
        $('#filter-form').submit();
    });

    var search = getParameterByName('search');
    if(search !== null)
        $('#search').val(decodeURI(search));

    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
});
