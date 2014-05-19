<section id="main-content" class="<?php echo twbs_set_columns(4, 4) ?>">

	<div class="panel panel-default">

		<div class="panel-heading"><h3 class="panel-title"><?php echo $panel_title ?></h3></div>
		<div class="panel-body"><?php echo $panel_body ?></div>

	</div>

</section>

<div id="auth-desc" class="<?php echo twbs_set_columns(8, 8) ?>">

	<div class="page-header">
		<h1><?php echo $desc_title ?></h1>
	</div>
	<?php foreach ($desc_body as $k => $body): if (!is_array($body)) : ?>
		<p><?php echo $body ?></p>
	<?php else: ?>
		<ul>
			<?php foreach ($body as $list): ?>
				<li><?php echo $list ?></li>
			<?php endforeach ?>
		</ul>
	<?php endif; endforeach; ?>

</div>
