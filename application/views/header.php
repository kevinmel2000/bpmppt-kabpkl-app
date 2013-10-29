<!DOCTYPE html>
<html lang="<?php echo get_lang_code() ?>">
<head>
	<meta charset="<?php echo get_charset() ?>">
	<title><?php echo  get_site_title() ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="<?php echo get_app_config('app_author') ?>">

	<!-- Bootstrap -->
	<link href="<?php echo base_url('asset/vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css" rel="stylesheet" media="screen">
	<link href="<?php echo base_url('asset/css/style.css') ?>" type="text/css" rel="stylesheet" media="screen">

	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('asset/img/ico/favicon/icon-144.png') ?>">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url('asset/img/ico/favicon/icon-114.png') ?>">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url('asset/img/ico/favicon/icon-72.png') ?>">
	<link rel="apple-touch-icon-precomposed" href="<?php echo base_url('asset/img/ico/favicon/icon-57.png') ?>">
	<link rel="shortcut icon" href="<?php echo base_url('asset/img/ico/favicon/favicon.png') ?>">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script charset="utf-8" src="<?php echo base_url('asset/vendor/html5shiv-dist/html5shiv.js') ?>"></script>
		<script charset="utf-8" src="<?php echo base_url('asset/vendor/respond/respond.min.js') ?>"></script>
	<![endif]-->
</head>
<body <?php echo get_body_class() ?>>

<div id="wrapper">
	<?php echo get_navbar() ?>

