$(document).ready( function () {

	$('.form-control.bs-tooltip').on('focus', function () {
		$(this).tooltip('show');
	})

	$('.btn.bs-tooltip').on('hover', function () {
		$(this).tooltip('show');
	})

	$('.bs-datepicker').datepicker({
		format: "dd/mm/yyyy",
		language: "id",
		autoclose: true,
		todayHighlight: true,
		todayBtn: true
	})

	$('#table-koordinat .btn-primary').on('click', function () {
		var table = $('#table-koordinat');
		
		table.find('tbody').append( table.find('tbody > tr:first').clone() )
	})

});