window.$ = window.jQuery = require('jquery')
require('bootstrap');

$( document ).ready(function() {
    //console.log($.fn.tooltip.Constructor.VERSION);

    // $('.dropdown').hover(function() {
    //     $(this).addClass('open');
    // },
    // function() {
    //     $(this).removeClass('open');
    // });

    console.log($.fn.jquery);

    $('[data-toggle="offcanvas"]').click(function () {
        $('.row-offcanvas').toggleClass('active');
    });

    $('.spinner').on('click', function () {
        $(this).append(' <i class="fa fa-spinner fa-spin"></i>');
    });

    //setup ckeditor
    if(typeof CKEDITOR !== "undefined") {
      $('.wysiwyg-admin').each(function (index, element) {
        CKEDITOR.replace(element.getAttribute('name'), {
          removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor,Underline,Strike,Subscript,Superscript,About',
          skin: 'flat,'+BASE_URL+'/js/vendor/ckeditor/skins/flat/'
        });
      });

      $('.wysiwyg').each(function (index, element) {
        CKEDITOR.replace(element.getAttribute('name'), {
          removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor,Underline,Strike,Subscript,Superscript,About,Link,Unlink',
          skin: 'flat,'+BASE_URL+'/js/vendor/ckeditor/skins/flat/'
        });
      });
    }

    //show filename next to pretty file upload
    $('.bs-file-upload').on('change', function () {
      $(this).parents('.btn-file').next('.file-upload-info').html(this.files[0].name);
    })

    //show spinner when button is pressed
    $('.has-spinner').on('click', function () {
        $(this).find('i.fa-spinner').removeClass('hidden');
    });

});
