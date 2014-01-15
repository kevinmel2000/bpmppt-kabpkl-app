<div id="dashboard-content" class="row">
	<div class="col-md-9">

<?php load_view('toolbar') ?>
<?php echo form_alert() ?>

<div id="dashboard-callout" class="row">
	<!-- <div class="col-md-6">

<?php // foreach ( $data_type as $alias => $label ) : if ( $counter[$alias] > 0 ) : ?>
<?php // $i = $counter[$alias]/2 ?>
<div id="panel-<?php // echo $alias ?>" class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><?php // echo $label ?></h3>
	</div>
	
	<?php // echo $panel_body[$alias] ?>
</div>

<?php // echo ( $i % $counter[$alias]  === 0 ) ? '</div><div class="col-md-6">' : '' ?>
<?php // endif; endforeach; ?>

	</div> -->
</div>

	</div>
	<div class="col-md-3">
		<?php echo get_nav('side') ?>
	</div>
</div>
