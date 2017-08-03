$(function() {
    $('.no-js-warning').remove();
    $('.btn-save').on('click', function (event) {
        event.preventDefault();

        //submit first 25 items from selected list
        var selected = $.map($('#selected li'), function (item) {
            return $(item).data('value');
        }).slice(0, 25);

        if(selected.length == 0) {
            return false;
        }

        //TODO: handle server error responses
        $.ajax(window.location.href, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: 'application/json',
            data: JSON.stringify({ 'selected': selected })
        }).done(function (response, textStatus) {
            //remove existing alert
            var $alert = $('#status-alert');
            if($alert.length > 0) {
                $alert.fadeOut(400, function() {
                    $(this).remove();
                });
            }
            $alert = $('<div id="status-alert" class="alert alert-dismissible" role="alert">');
            var $dismissable = $('<span aria-hidden="true">').html('&times;');
            $alert.append($('<button type="button" class="close" data-dismiss="alert" aria-label="Close">')
                  .append($dismissable))
                  .append($('<p>').html(response.message));
            if(response.status === 'success') {
                $alert.addClass('alert-success');
            }
            if(response.status === 'error') {
                $alert.addClass('alert-danger');
            }
            $('.round-2-container').prepend($alert);
        }).always(function(data, textStatus) {

        });

    });

    Sortable.create(candidates, {
        group: 'ranking',
        sort: false,
        draggable: '.draggable',
        handle: '.handle',
        animation: 250,
        onAdd: function (event) {
            //sort list when items are put back;
            tinysort('#candidates>li.draggable', {data: 'sort'});
            toggleArrowDirection(event.item);
        }
    });
    Sortable.create(selected, {
        group: 'ranking',
        sort: true,
        draggable: '.draggable',
        handle: '.handle',
        animation: 250,
        // Called by any change to the list (add / update / remove)
        onSort: function (event) {
            // same properties as onUpdate
            // console.log(event.oldIndex);
            // console.log(event.newIndex);
        },
        onAdd: function (event) {
            toggleArrowDirection(event.item);
        }
    });

    function toggleArrowDirection(item) {
        $(item).find('a>i')
            .toggleClass('fa-arrow-right')
            .toggleClass('fa-arrow-left')
            .toggleClass('text-success')
            .toggleClass('text-danger');
    }

    $('a.link-candidate-app').on('click', function (event) {
        event.preventDefault();
        var url = this.href;
        var name = $(this).text();

        if(StorageHelper) {
            var read = StorageHelper.load('top100.candidates.read');
            if(!read) {
                read = new Array();
            }
            var value = $(this).parent().data('value');
            if(read.indexOf(value) < 0)
                read.push(value);
            StorageHelper.save('top100.candidates.read', read, 262800);
        }
        $(this).removeClass('unread');

        $.ajax(url, {
            success: function (response) {
                var dialog = $('#view-dialog');
                dialog.find('.modal-title').text(name);
                dialog.find('.modal-body').html($(response).find('.col-md-12'));
                dialog.modal('show');
            }
        });
    });

    $('a.btn-shift').on('click', function (event) {
        event.preventDefault();
        var item = $(this).parents('li');
        var list = item.parents('ul');
        if(list.is('#candidates'))
            $('#selected').append(item);
        if(list.is('#selected')) {
            $('#candidates').append(item);
            tinysort('#candidates>li.draggable', {data: 'sort'});
        }
        toggleArrowDirection(item.get(0));
    });

    if(StorageHelper) {
        var read = StorageHelper.load('top100.candidates.read');
        if(read) {
            $('li.draggable').each(function (index, element) {
                var value = $(element).data('value');
                if(read.indexOf(value) > -1)
                    $(element).find('a.unread').removeClass('unread');
            });
        }
    }

});
