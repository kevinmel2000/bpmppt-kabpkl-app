<section class="panel panel-default">
	<header class="panel-heading">
		<h3 class="panel-title"><?php echo $panel_title ?></h3>
	</header>
	<div class="<?php echo 'panel-body'.($data_page == TRUE ? '-data' : '')?>"><?php bi_echo( $panel_body ) ?></div>
</section>
