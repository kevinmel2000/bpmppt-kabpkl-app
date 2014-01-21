var Baka = {

	confirm: function(message) {
		return confirm(message)
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

	$('[id="toolbar-btn-hapus*"]').on('click', function(e) {
		var message = $(this).data('message');

		return new Baka.confirm(message);
	})

	// $('.form-control.bs-tooltip').on('focus', function () {
	// 	$(this).tooltip('show');
	// })

	// $('.btn.bs-tooltip').on('hover', function () {
	// 	$(this).tooltip('show');
	// })

	$('#table-koordinat .btn-primary').on('click', function () {
		var table = $('#table-koordinat');
		
		table.find('tbody').append( table.find('tbody > tr:first').clone() )
	})
	
});