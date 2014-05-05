<div id="dashboard-content" class="row">
	<div class="col-md-9">

<?php load_view('toolbar') ?>
<section id="dashboard-callout" class="row">

	<div class="col-md-6">
	<?php $i = 1; $c = count($panel_body); ?>
	<?php foreach ( $panel_body as $link => $izin ) : ?>
		
		<div id="panel-<?php echo $link ?>" class="panel panel-default">
			
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo anchor('data/layanan/'.$link, $izin['label']) ?></h3>
			</div>
			
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4">
						<p>Total Data</p>
						<h1 style="font-size: 60px; font-weight: bold; margin: 0; text-align: right;"><?php echo $izin['total'] ?></h1>
					</div>
					<div class="col-md-8">
						<p class="text-warning"><?php echo $izin['pending'] ?> Tertunda</p>
						<p class="text-primary"><?php echo $izin['approved'] ?> Disetujui</p>
						<p class="text-success"><?php echo $izin['done'] ?> Selesai</p>
						<p class="text-danger"><?php echo $izin['deleted'] ?> Terhapus</p>
					</div>
				</div>
			</div>
		</div>

	<?php echo ($i == ceil($c/2) ? '</div><div class="col-md-6">' : ''); $i++; ?>
	<?php endforeach; ?>
	</div>

</section>

	</div>
	<aside class="col-md-3">
		<?php echo get_nav('side') ?>
	</aside>
</div>
