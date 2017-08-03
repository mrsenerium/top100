$(function() {
    $('#email').on('keyup', function () {
        $parts = $(this).val().split('@');
        $('#username').val($parts[0]);
    });
});
