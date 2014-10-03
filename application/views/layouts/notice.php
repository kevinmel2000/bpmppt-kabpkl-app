<!DOCTYPE html>
<html lang="<?php echo get_lang_code() ?>">
<head>
    <meta charset="<?php echo get_charset() ?>">
    <title><?php echo get_site_title() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="<?php echo config_item('application_author') ?>">
    <?php echo get_styles() ?>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('asset/img/favicon/icon-144.png') ?>">
    <link rel="shortcut icon" href="<?php echo base_url('asset/img/favicon/favicon.png') ?>">
</head>
<body <?php echo get_body_attrs() ?>>

<div class="wrapper">
    <header id="top" class="navbar navbar-default navbar-app navbar-static-top" role="banner">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button> <!-- .navbar-toggle -->
                <?php echo $brand_link ?>
            </div> <!-- .navbar-header -->
            <div class="navbar-collapse collapse">
                <?php echo get_navbar() ?>
            </div> <!-- .nav-collapse -->
        </div> <!-- .container -->
    </header> <!-- #top -->

	<section id="contents">
	    <div class="container">
	        <div class="row">
	            <?php echo $contents ?>
	        </div> <!-- .row -->
	    </div> <!-- .container-->
	</section> <!-- #contents -->
</div> <!-- .wrapper -->

<footer id="foots">
    <div class="container">
        <p class="text-muted pull-left"><?php echo $footer_left ?></p>
        <p class="text-muted pull-right"><?php echo $footer_right ?></p>
    </div> <!-- .container-->
</footer> <!-- #foots-->

<?php echo get_scripts() ?>
</body>
</html>

