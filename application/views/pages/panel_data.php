<div class="row">
	<div class="col-md-9">

<?php load_view('toolbar') ?>

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $panel_title ?></h3>
	</div>

	<?php baka_echo( $panel_body ) ?>

	<div class="panel-footer">
		<span class="text-muted"><?php echo get_counter_text( $counter ) ?></span>
	</div>

</div>

	</div>
	<?php load_view('sidebar') ?>
</div>
