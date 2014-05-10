<div class="row">
	<div class="col-md-9 col-sm-11">

		<?php load_view('toolbar') ?>
		<section class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $panel_title ?></h3>
			</div>
			<div class="panel-body"><?php baka_echo( $panel_body ) ?></div>
		</section>

	</div>
	<aside class="col-md-3 col-sm-1">
		<?php echo get_nav('side', TRUE) ?>
	</aside>
</div>