<div class="row">
	<div class="col-md-9">

<?php load_view('toolbar') ?>
<?php echo form_alert() ?>

<?php foreach ( $data_type as $slug => $name ) : if ( $counter[$slug] > 0 ) : ?>

<div id="panel-<?php echo $slug ?>" class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $name ?></h3>
		<div class="btn-group panel-button">
			<?php echo anchor('data/layanan/ijin/'.$slug, 'Detail', 'class="btn btn-default"') ?>
		</div>
	</div>
	
	<?php echo $panel_body[$slug] ?>

	<div class="panel-footer">
		<span class="text-muted"><?php echo get_counter_text( $counter[$slug] ) ?></span>
	</div>
</div>

<?php endif; endforeach; ?>

	</div>
	<div class="col-md-3">
		<?php echo get_nav('side') ?>
	</div>
</div>
