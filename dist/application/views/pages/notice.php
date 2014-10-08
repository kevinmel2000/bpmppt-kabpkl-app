<div class="jumbotron">
	<h3><?php echo $panel_title ?></h3>

	<?php if ( is_array( $panel_body ) ) : ?>
		<?php foreach ( $panel_body as $body ) : ?>
			<p><?php echo $body ?></p>
		<?php endforeach ?>
	<?php else : ?>
		<p><?php echo $panel_body ?></p>
	<?php endif ?>
</div>
