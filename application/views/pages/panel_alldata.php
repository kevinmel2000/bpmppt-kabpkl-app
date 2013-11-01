<div class="row">
	<div class="col-md-9">

<?php load_view('toolbar') ?>

<?php foreach ( $data_type as $slug => $name ) : ?>

<div id="panel-<?php echo $slug ?>" class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $name ?></h3>
		<div class="btn-group panel-button">
			<button type="button" class="btn btn-default">Detail</button>
		</div>
	</div>
	
	<?php echo $panel_body[$slug] ?>

	<div class="panel-footer">
		<span class="text-muted"><?php echo get_counter_text( $counter[$slug] ) ?></span>
	</div>
</div>

<?php endforeach ?>

	</div>
	<div class="col-md-3">
		<?php echo get_nav('side') ?>
	</div>
</div>
