<!DOCTYPE html>
<html lang="<?php echo get_lang_code() ?>">
<head>
	<meta charset="<?php echo get_charset() ?>">
	<title><?php echo get_site_title() ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="<?php echo get_app_config('app_author') ?>">
	<link href="<?php echo base_url('assets/css/print.css') ?>" type="text/css" rel="stylesheet" media="print">
</head>
<body <?php echo get_body_class() ?>>
<!-- <body onload="window.print()" <?php echo get_body_class() ?>> -->

<table class="t-header" width="100%">
	<tr>
		<td width="10%">
			<?php echo img( array(
				'src'	=>  $skpd_logo,
				'alt'	=> 'Logo cetak',
				'class'	=> 'img',
				'width'	=> '100',
				'height'=> 'auto')); ?>
		</td>
		<td width="90%">
			<p style="text-align:center"><b>PEMERINTAH KABUPATEN PEKALONGAN</b></p>
			<p style="text-align:center"><b><?php echo strtoupper($skpd_name) ?></b></p>
			<p style="text-align:center"><b><?php echo $skpd_address ?> Telp. <?php echo $skpd_telp ?> kode pos <?php echo $skpd_pos ?></b></p>
		</td>
	</tr>
</table>

<?php echo $contents; ?>

</body>
</html>