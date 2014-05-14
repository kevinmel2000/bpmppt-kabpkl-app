<div class="row">
	<div class="<?php echo twbs_set_columns(9, 11) ?>">

		<section class="panel panel-default">
			<header class="panel-heading">
				<h3 class="panel-title"><?php echo $panel_title ?></h3>
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="<?php echo twbs_set_columns(3, 3) ?>"><?php echo get_nav('panel') ?></div>
					<div class="<?php echo twbs_set_columns(9, 9) ?>">
						<?php if ( isset( $count_log ) ) echo '<p>'.$count_log.'</p>' ?>
						<?php if ( isset( $panel_body ) ) echo $panel_body ?>
					</div>
				</div>
			</div>
		</section>

	</div>
	<aside class="<?php echo twbs_set_columns(3, 1) ?>">
		<?php echo get_nav('side', TRUE) ?>
	</aside>
</div>
