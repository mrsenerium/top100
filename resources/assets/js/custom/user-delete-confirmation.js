$(function() {
    $('a.link-delete').on('click', function (event) {
        event.preventDefault();
        var link = $(this);
        var id = link.data('user-id');
        var name = link.data('user-name');
        var message = '<i class="fa fa-warning text-danger"></i> Permanently delete user ' + name + '.';
        bootbox.confirm(message, function(result) {
            if(result === true) {
                link.next('form').submit();
            }
        });
    });
});
