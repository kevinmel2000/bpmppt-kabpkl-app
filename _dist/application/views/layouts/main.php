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
            <?php echo form_alert() ?>
            <?php $nav = get_nav('side', TRUE) ?>

            <div class="row">
                <section id="main-content" class="<?php echo ($nav ? twbs_set_columns(9, 9, 12, 12, 12) : twbs_set_columns(12, 12, 12)) ?>">
                    <button id="sidebar-toggle" type="button" class="btn btn-default">
                        <i class="fa fa-bars"></i>
                    </button> <!-- .sidebar-toggle -->

                <?php if ( !empty($load_toolbar) ) : ?>
                    <div class="row action-bar">
                        <div class="<?php echo twbs_set_columns(12, 12, 12) ?>">
                            <?php echo set_toolbar( $tool_buttons, $page_link ) ?>
                        </div>
                    </div> <!-- .action-bar -->
                <?php endif ?>

                    <?php echo $contents ?>
                </section> <!-- #main-content -->

            <?php if ($nav): ?>
                <aside id="sidebar" class="collapse <?php echo twbs_set_columns(3, 3, 12, 12, 12) ?>">
                    <div id="sidebar-backdrop"></div>
                    <?php echo $nav ?>
                </aside> <!-- #sidebar -->
            <?php endif ?>
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
