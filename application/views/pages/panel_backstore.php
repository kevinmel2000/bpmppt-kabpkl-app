<div class="row">
	<div class="<?php echo twbs_set_columns(9, 11) ?>">

		<section class="panel panel-default">
			<header class="panel-heading">
				<h3 class="panel-title"><?php echo $panel_backup_title ?></h3>
			</header>
			<div class="panel-body"><?php baka_echo( $panel_backup_body ) ?></div>
		</section>

		<section class="panel panel-default">
			<header class="panel-heading">
				<h3 class="panel-title"><?php echo $panel_restore_title ?></h3>
			</header>
			<div class="panel-body"><?php baka_echo( $panel_restore_body ) ?></div>
		</section>

	</div>
	<aside class="<?php echo twbs_set_columns(3, 1) ?>">
		<?php echo get_nav('side', TRUE) ?>
	</aside>
</div>
