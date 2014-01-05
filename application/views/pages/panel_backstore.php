<div class="row">
	<div class="col-md-9">

<?php echo form_alert() ?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $panel_backup_title ?></h3>
	</div>
	<div class="panel-body"><?php baka_echo( $panel_backup_body ) ?></div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $panel_restore_title ?></h3>
	</div>
	<div class="panel-body"><?php baka_echo( $panel_restore_body ) ?></div>
</div>

	</div>
	<div class="col-md-3">
		<?php echo get_nav('side') ?>
	</div>
</div>
