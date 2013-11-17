<div class="row">
	<div class="col-md-9">

<?php load_view('toolbar') ?>
<?php echo form_alert() ?>

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $panel_title ?></h3>
	</div>

	<?php baka_echo( $panel_body ) ?>

</div>

	</div>
	<div class="col-md-3">
		<?php echo get_nav('side') ?>
	</div>
</div>
