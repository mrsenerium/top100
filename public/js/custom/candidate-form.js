$(function() {
    //duplication organization form block when add button is pressed
    $('.add-org').on('click', function (event) {
        event.preventDefault();
        var blocks = $(this).parents('fieldset').find('.organization-block');
        var length = blocks.length;
        var last = blocks.last();
        var clone = last.clone();
        clone.find('label, input, select, textarea').each(function (index, element) {
            var $input = $(element);
            if($input.is('select'))
                $input.prop("selectedIndex", 0);
            else {
                $input.val('');
            }
            var forAttr = $input.prop('for');
            if(forAttr)
                $input.prop('for', forAttr.replace(/\d+/ig, length));

            var idAttr = $input.prop('id');
            if(idAttr)
                $input.prop('id', idAttr.replace(/\d+/ig, length));

            var nameAttr = $input.prop('name');
            if(nameAttr)
                $input.prop('name', nameAttr.replace(/\d+/ig, length));
        });
        last.after(clone);

        checkMax($(this));
    }).each(function (index, element) {
        checkMax($(element));
    });

    function checkMax($addButton) {
        if(window.ORG_MAX > 0 && window.ORG_MAX <= $addButton.parents('fieldset').find('.organization-block').length)
        {
            $addButton.remove();
        }
    }

    //change button to Finish when confirmation is checked
    $('#confirm').on('change', function () {
        if($(this).is(':checked')){
            $('button[type="submit"][name="save_app"]').prop('name', 'submit_app').removeClass('btn-success').addClass('btn-primary').text('Finish');
            $('button[type="submit"][name="preview_app"]').hide();
        }
        else {
            $('button[type="submit"][name="submit_app"]').prop('name', 'save_app').removeClass('btn-primary').addClass('btn-success').text('Save for later');
            $('button[type="submit"][name="preview_app"]').show();
        }
    });
});
