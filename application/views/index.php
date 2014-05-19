<!DOCTYPE html>
<html lang="<?php echo get_lang_code() ?>">
<head>
    <meta charset="<?php echo get_charset() ?>">
    <title><?php echo get_site_title() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="<?php echo get_conf('app_author') ?>">
    <meta name="blitz" content="mu-0fe58ea5-804ccb30-8bf9eaa3-606e579a">
    <?php echo load_scripts('head').load_styles() ?>
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
            <?php echo form_alert()?>
            <div class="row">
                <section id="main-content" class="<?php echo twbs_set_columns(9, 9, 11) ?>">
                    <?php echo $contents ?>
                </section> <!-- #main-content -->
                <aside id="sidebar" class="<?php echo twbs_set_columns(3, 3, 1) ?>">
                    <?php echo get_nav('side', TRUE) ?>
                </aside> <!-- #sidebar -->
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

<?php if ( $need_print ) : ?>
<applet id="qz" name="QZ Print Plugin" code="qz.PrintApplet.class" width="55" height="55">
    <param name="jnlp_href" value="qz-print_jnlp.jnlp">
    <param name="cache_option" value="plugin">
</applet>
<?php endif ?>

<?php echo load_scripts('foot') ?>
</body>
</html>