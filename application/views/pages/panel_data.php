<div class="row">
	<div class="<?php echo twbs_set_columns(9, 11) ?>">

		<?php load_view('toolbar') ?>
		<section class="panel panel-default">
			<header class="panel-heading">
				<h3 class="panel-title"><?php echo $panel_title ?></h3>
			</header>
			<?php baka_echo( $panel_body ) ?>
		</section>

	</div>
	<aside class="<?php echo twbs_set_columns(3, 1) ?>">
		<?php echo get_nav('side', TRUE) ?>
	</aside>
</div>
