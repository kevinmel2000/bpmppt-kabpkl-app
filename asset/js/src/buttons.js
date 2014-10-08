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
    /*global confirm*/
    if (!confirm($(this).data('message'))) {
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
})
