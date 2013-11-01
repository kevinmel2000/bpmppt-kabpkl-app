<div class="row">
	<div class="col-md-9">

<div class="alert alert-info alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo saepe libero inventore quidem expedita. Ab, exercitationem, doloremque natus quis libero unde facilis adipisci quisquam omnis fugit eos reiciendis officiis repudiandae?</p>
</div>

<div class="row">
	<div class="col-md-6">

	<div id="panel-sumary" class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">Test Dir</h3></div>
		<div class="panel-body">
			<dl class="dl-horizontal">
			<?php foreach ( $data_type as $slug => $name ) : ?>
				<dt><?php echo $data_count[$slug] ?></dt>
				<dd><?php echo anchor( 'data/layanan/ijin/'.$slug, $name ) ?></dd>
			<?php endforeach ?>
			</dl>
		</div>
	</div>

	</div>
	<div class="col-md-6">

	<div id="panel-sumary" class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">Test Dir</h3></div>
		<div class="panel-body">
			<dl class="dl-horizontal">
			<?php foreach ( $data_type as $slug => $name ) : ?>
				<dt><?php echo $data_count[$slug] ?></dt>
				<dd><?php echo anchor( 'data/layanan/ijin/'.$slug, $name ) ?></dd>
			<?php endforeach ?>
			</dl>
		</div>
	</div>

	</div>
</div>

	</div>
	<div class="col-md-3">
		<?php echo get_nav('side') ?>
	</div>
</div>
