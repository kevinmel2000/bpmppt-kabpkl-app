var Baka = {

    confrm: function(message) {
        confirm(message)
    },

    popup: function(url, title, w, h) {
        var left = (screen.width/2)-(w/2),
            top = (screen.height/2)-(h/2)-20;

        window.open(url, title, 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,width='+w+',height='+h+',top='+top+',left='+left);
        this.target = title;
    }
}

$(document).ready( function () {

    $('.twbs-tooltip').tooltip();

    $('#toolbar-btn-cetak').on('click', function(e) {
        var url = $(this).attr('href')
            title = $(this).attr('title');

        new Baka.popup(url, title, 800, 600);

        e.preventDefault();
    })

    $('#toolbar-btn-hapus*').on('click', function(e) {
        var message = $(this).data('message');

        return new Baka.confrm(message);
    })

    if ($('.table-exp tbody tr').length === 1) {
        $('.table-exp .remove-btn').addClass('disabled')
    }

    $('.table-exp')
        .on('click', '.btn-primary', function () {
            var table = $('.table-exp');
            table.find('tbody').append( table.find('tbody > tr:first').clone() );
            $('.remove-btn').removeClass('disabled');
        })
        .on('click', '.remove-btn', function () {
            $(this).parents('tr').remove()
            if ($('.remove-btn').length === 1) {
                $('.remove-btn').addClass('disabled')
            }
        })

    function showHide(el, state) {
        if (state) {
            el.removeClass('hide')
        } else {
            el.addClass('hide')
        }
    }

    $('.form-group').each(function () {
        if ($(this).data('fold') === 1) {
            var el  = $(this),
                key = el.data('fold-key'),
                val = el.data('fold-value'),
                tgt = '[name="'+key+'"]';

            if ($(tgt).val() != val) {
                $(this).addClass('hide');
            }

            if ($(tgt).hasClass('bs-switch')) {
                $(tgt).on('switchChange.bootstrapSwitch', function(event, state) {
                    showHide(el, (val == state))
                });
            } else {
                $(tgt).change(function (e) {
                    showHide(el, ($(this).val() == val))
                })
            }
        }
    })
});