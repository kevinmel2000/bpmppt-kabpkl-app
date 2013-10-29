<?php load_view('header') ?>
<section id="contents">
	<header id="contents-header">
		<div class="container">
			<h1 class="page-header"><?php echo get_page_title() ?></h1>
		</div>
	</header>
	<section id="contents-main">
		<div class="container"><?php echo $contents ?></div>
	</section>
</section>
<?php load_view('footer') ?>