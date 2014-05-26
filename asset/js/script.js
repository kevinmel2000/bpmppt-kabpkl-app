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

    $('#toolbar-btn-cetak').on('click', function(e) {
        var url = $(this).attr('href')
            title = $(this).attr('title');

        new Baka.popup(url, title, 800, 600);

        e.preventDefault();
    })

    $('#toolbar-btn-hapus*').on('click', function(e) {
        var message = $(this).data('message');

        new Baka.confrm(message);

        e.preventDefault();
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

    $('#sidebar-toggle').on('click', function (e) {
        $('#sidebar').show();
        $('body').css('overflow', 'hidden');

        e.preventDefault();
    })

    $('#sidebar-backdrop').on('click', function (e) {
        $('#sidebar').hide();
        $('body').css('overflow', 'auto');

        e.preventDefault();
    })
});