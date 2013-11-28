<!DOCTYPE html>
<html lang="<?php echo get_lang_code() ?>">
<head>
	<meta charset="<?php echo get_charset() ?>">
	<title><?php echo get_site_title() ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="<?php echo get_app_config('app_author') ?>">
	<link href="<?php echo base_url('asset/css/print.css') ?>" type="text/css" rel="stylesheet" media="all">
</head>
<body <?php echo get_body_class() ?>>
<!-- <body onload="window.print()" <?php echo get_body_class() ?>> -->

<?php echo $contents; ?>

</body>
</html>