$(document).ready(function () {

  function biPopup(url, title, w, h) {
    var left = (screen.width/2)-(w/2)
    var top = (screen.height/2)-(h/2)-20

    window.open(url, title, 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,width='+w+',height='+h+',top='+top+',left='+left)
    this.target = title
  }

  $('#toolbar-btn-cetak').on('click', function(e) {
    biPopup($(this).attr('href'), $(this).attr('title'), 800, 600)

    e.preventDefault()
  })

  $('#toolbar-btn-hapus*').on('click', function(e) {
    if (!window.confirm($(this).data('message'))) {
      e.preventDefault()
    }
  })

  $('#sidebar-toggle').on('click', function (e) {
    $('#sidebar').show()
    $('body').css('overflow', 'hidden')

    e.preventDefault()
  })

  $('#sidebar-backdrop').on('click', function (e) {
    $('#sidebar').hide()
    $('body').css('overflow', 'auto')

    e.preventDefault()
  })

  /*global Morris*/
  Morris.Donut({
    element: $(this).attr('id'),
    data: [
      {label: "Pending", value: $(this).data('pending')},
      {label: "Approved", value: $(this).data('approved')},
      {label: "Deleted", value: $(this).data('deleted')},
      {label: "Done", value: $(this).data('done')}
    ]
  })

  $('.table-exp').each(function () {
    var table = $(this);

    if (table.find('tbody > tr').length === 1) {
      table.find('.remove-btn').addClass('disabled')
    }

    table
      .on('click', '.btn-primary', function () {
        table.find('tbody').append( table.find('tbody > tr:first').clone() );
        table.find('tbody > tr:last input[type="text"]').val('');
        table.find('tbody > tr:last input[type="text"]:first').focus();
        table.find('.remove-btn').removeClass('disabled');
      })
      .on('click', '.remove-btn', function () {
        $(this).parents('tr').remove()
        if (table.find('tbody > tr').length === 1) {
          table.find('.remove-btn').addClass('disabled')
        }
      })
  })

})
