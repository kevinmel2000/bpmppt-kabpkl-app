<div id="dashboard-content" class="row">
	<div class="<?php echo twbs_set_columns(9, 11) ?>">

		<?php load_view('toolbar') ?>
		<section id="dashboard-callout" class="row">
		<?php $widget_col = twbs_set_columns(6, 6, 6, 12) ?>

			<div class="<?php echo $widget_col ?>">
			<?php $i = 1; $c = count($panel_body); ?>
			<?php foreach ( $panel_body as $link => $izin ) : ?>
				
				<div id="panel-<?php echo $link ?>" class="panel panel-default">
					<header class="panel-heading">
						<h3 class="panel-title"><?php echo anchor('data/layanan/'.$link, $izin['label']) ?></h3>
					</header>
					<div class="panel-body">
						<div class="row">
							<div class="<?php echo twbs_set_columns(4, 4, 4) ?>">
								<p>Total Data</p>
								<h1 style="font-size: 60px; font-weight: bold; margin: 0; text-align: right;"><?php echo $izin['total'] ?></h1>
							</div>
							<div class="<?php echo twbs_set_columns(8, 8, 8) ?>">
								<p class="text-warning"><?php echo $izin['pending'] ?> Tertunda</p>
								<p class="text-primary"><?php echo $izin['approved'] ?> Disetujui</p>
								<p class="text-success"><?php echo $izin['done'] ?> Selesai</p>
								<p class="text-danger"><?php echo $izin['deleted'] ?> Terhapus</p>
							</div>
						</div>
					</div>
				</div>

			<?php echo ($i == ceil($c/2) ? '</div><div class="'.$widget_col.'">' : ''); $i++; ?>
			<?php endforeach; ?>
			</div>

		</section>

	</div>
	<aside class="<?php echo twbs_set_columns(3, 1) ?>">
		<?php echo get_nav('side', TRUE) ?>
	</aside>
</div>
