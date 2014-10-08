$(document).ready( function () {

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
});
