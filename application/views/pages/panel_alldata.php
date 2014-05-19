<?php load_view('toolbar') ?>
<div id="dashboard-callout" class="row">
<?php $widget_col = twbs_set_columns(6, 6, 6, 6, 12) ?>
	<div class="<?php echo $widget_col ?>">
	<?php $i = 1; $c = count($panel_body); ?>
	<?php foreach ( $panel_body as $link => $izin ) : ?>
		<article id="panel-<?php echo $link ?>" class="panel panel-default">
			<header class="panel-heading">
				<h3 class="panel-title"><?php echo anchor('data/layanan/'.$link, $izin['label']) ?></h3>
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="<?php echo twbs_set_columns(4, 4, 4, 6, 4) ?>">
						<p>Total Data</p>
						<?php $chart_attr = array(
							'id'             => $link.'-chart',
							'class'          => 'charts',
							'width'          => '100px',
							'height'         => '100px',
							'data-pending'   => $izin['pending'],
							'data-approved'  => $izin['approved'],
							'data-done'      => $izin['done'],
							'data-deleted'   => $izin['deleted'],
						); ?>
						<canvas <?php echo parse_attrs($chart_attr) ?>></canvas>
						<h1 class="total-layanan"><?php echo $izin['total'] ?></h1>
					</div>
					<div class="<?php echo twbs_set_columns(8, 8, 8, 6, 8) ?>">
						<p class="text-warning"><?php echo $izin['pending'] ?> Tertunda</p>
						<p class="text-primary"><?php echo $izin['approved'] ?> Disetujui</p>
						<p class="text-success"><?php echo $izin['done'] ?> Selesai</p>
						<p class="text-danger"><?php echo $izin['deleted'] ?> Terhapus</p>
					</div>
				</div>
			</div>
		</article>
	<?php echo ($i == ceil($c/2) ? '</div><div class="'.$widget_col.'">' : ''); $i++; ?>
	<?php endforeach; ?>
	</div>
</div>
