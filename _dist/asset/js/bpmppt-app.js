/*!
 * BPMPPT App v0.1.6 (http://feryardiant.github.com/bpmppt)
 * Aplikasi Pengelolaan Dokumen Perijinan di BPMPPT Kab. Pekalongan
 * Copyright (c) 2013-2014 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * Licensed under MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 */

$(document).ready(function () {
  'use strict';

  function biPopup(url, title, w, h) {
    var left = (screen.width / 2) - (w / 2)
    var top = (screen.height / 2) - (h / 2) - 20

    window.open(url, '', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,width=' + w + ',height=' + h + ',top=' + top + ',left=' + left)
    // this.target = title
  }

  $('.btn-cetak').click(function (e) {
    e.preventDefault()
    biPopup($(this).attr('href'), $(this).attr('title'), 800, 600)
  })

  $('.btn-hapus').click(function (e) {
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

  $('.charts').each(function () {
    /*global Morris*/
    Morris.Donut({
      element: $(this).attr('id'),
      data: [
        { label: 'Pending', value: $(this).data('pending') },
        { label: 'Approved', value: $(this).data('approved') },
        { label: 'Deleted', value: $(this).data('deleted') },
        { label: 'Done', value: $(this).data('done') }
      ]
    })

  })

  $('.table-exp').each(function () {
    var table = $(this)

    if (table.find('tbody > tr').length === 1) {
      table.find('.remove-btn').addClass('disabled')
    }

    table
      .on('click', '.btn-primary', function () {
        table.find('tbody').append(table.find('tbody > tr:first').clone())
        table.find('tbody > tr:last input[type="text"]').val('')
        table.find('tbody > tr:last input[type="text"]:first').focus()
        table.find('.remove-btn').removeClass('disabled')
      })
      .on('click', '.remove-btn', function () {
        $(this).parents('tr').remove()
        if (table.find('tbody > tr').length === 1) {
          table.find('.remove-btn').addClass('disabled')
        }
      })
  })

  function showHide(el, state) {
    if (state) {
      el.removeClass('hide')
    } else {
      el.addClass('hide')
    }
  }

  // Folding functions
  $('.form-group').each(function () {
    var el  = $(this)

    if ($(this).data('fold') == 1) {
      var key = el.data('fold-key')
      var val = el.data('fold-value')
      var tgt = '[name=\"' + key + '\"]'

      if ($(tgt).hasClass('bs-switch')) {
        $(tgt).on('switchChange.bootstrapSwitch', function (event, state) {
          showHide(el, val.indexOf(state) !== -1)
        })
      } else {
        $(tgt).change(function () {
          if ($(tgt).is(':radio')) {
            showHide(el, val.indexOf($(tgt).filter(':checked').val()) !== -1)
          } else if ($(tgt).is(':checkbox')) {
            showHide(el, val.indexOf($(tgt).is(':checked')) !== -1)
          } else {
            showHide(el, val.indexOf($(tgt).val()) !== -1)
          }
        })
      }
    }
  })

  // jQuery-UI Spinner
  $('.jqui-spinner').each(function () {
    $(this).spinner({
      spin: function (e, ui) {
        var val = ui.value
        var max = $(this).data('spinner-max')
        var min = $(this).data('spinner-min')

        if (val > max) {
          val = min
        } else if (val < min) {
          val = max
        }

        $(this).spinner('value', val)
        e.preventDefault()
      }
    })
  })

  // jQuery-UI Slider
  $('.jqui-slider').each(function () {
    var el = $(this)
    var elmin = el.data('slider-min')
    var elmax = el.data('slider-max')
    var input = $(el.data('slider-target'))

    $(this).slider({
      max: elmax,
      min: elmin,
      step: el.data('slider-step'),
      range: 'min',
      value: input.val(),
      slide: function (event, ui) {
        input.val(ui.value)
      }
    })

    input.on('change', function () {
      var val = +$(this).val()

      if (val > elmax) {
        val = elmax
      } else if (val < elmin) {
        val = elmin
      }

      $(this).val(val)
      el.slider('value', val)
    })
  })

  // jQuery-UI Rangeslider
  $('.jqui-rangeslider').each(function () {
    var el = $(this)
    var elmin = el.data('slider-min')
    var elmax = el.data('slider-max')
    var inputMin = el.data('slider-target-min')
    var inputMax = el.data('slider-target-max')

    $(this).slider({
      max: elmax,
      min: elmin,
      step: el.data('slider-step'),
      range: true,
      values: [$(inputMin).val(), $(inputMax).val()],
      slide: function (event, ui) {
        $(inputMin).val(ui.values[0])
        $(inputMax).val(ui.values[1])
      }
    })

    $(inputMin).on('change', function () {
      var val = +$(this).val()

      if (val <= elmin) {
        val = elmin
      } else if (val > $(inputMax).val()) {
        val = $(inputMax).val()
      }

      $(inputMin).val(val)
      el.slider('values', 0, val)
    })

    $(inputMax).on('change', function () {
      var val = +$(this).val()

      if (val >= elmax) {
        val = elmax
      } else if (val < $(inputMin).val()) {
        val = $(inputMin).val()
      }

      $(inputMax).val(val)
      el.slider('values', 1, val)
    })
  })

  // Summernote
  $('.form-textrich').each(function () {
    var snel = $(this)

    snel.summernote({
      lang: snel.data('edtr-locale'),
      height: snel.data('edtr-height'),
      defaultFontName: snel.data('edtr-fontname'),
      fontSizes: ['5', '6', '7', '8', '9', '10', '11', '12', '14', '18', '24', '36'],
      fontNames: [
        'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New',
        'Tahoma', 'Times New Roman', 'Verdana'
      ],
      toolbar: [
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
        // ['table', ['table']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ]
    })
  })

  $('.summernote').parents('form').on('submit', function () {
    $('.summernote').val($('.summernote').code())
  })

  // Bootstrap Switch
  $('.bs-switch').each(function () {
    $(this).bootstrapSwitch()
  })

  // Select 2
  $('.form-control-select2').each(function () {
    $(this).select2()
  })

  // jQuery Autosize
  $('textarea').each(function () {
    $(this).autosize()
  })

  // Form Datepicker (jquery-ui and bootstrap)
  $('.form-datepicker').each(function () {
    var mode = $(this).data('mode')
    var lang = $(this).data('lang')
    var format = $(this).data('format')

    if (mode == 'bootstrap') {
      $(this).datepicker({
        format: format,
        language: lang,
        autoclose: true,
        todayBtn: true
      })
    } else if (mode == 'jqueryui') {
      // jQuery-UI Datepicker
      var $j = jQuery.noConflict();
      $j(this).datepicker({
        dateFormat: format
      })
    }
  })

})
