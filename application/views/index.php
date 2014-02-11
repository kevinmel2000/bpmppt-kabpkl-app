<!DOCTYPE html>
<html lang="<?php echo get_lang_code() ?>">
<head>
    <meta charset="<?php echo get_charset() ?>">
    <title><?php echo get_site_title() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="<?php echo get_conf('app_author') ?>">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script charset="utf-8" type="text/javascript" src="<?php echo base_url('asset/js/lib/html5shiv.js') ?>"></script>
        <script charset="utf-8" type="text/javascript" src="<?php echo base_url('asset/js/lib/respond.min.js') ?>"></script>
    <![endif]-->    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/style.min.css') ?>" />
    <!-- Bootstrap -->
    <?php echo load_styles() ?>
    <!-- Rresponsive Icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('asset/img/favicon/icon-144.png') ?>">
    <link rel="shortcut icon" href="<?php echo base_url('asset/img/favicon/favicon.png') ?>">
</head>
<body <?php echo get_body_class() ?>>

<div id="wrapper">
    <?php echo get_navbar() ?>

    <section id="contents">
        <header id="contents-header">
            <div class="container">
                <h1 class="page-header"><?php echo get_page_title() ?></h1>
            </div>
        </header>
        <section id="contents-main">
            <div class="container"><?php echo form_alert() . $contents ?></div>
        </section>
    </section>

</div>

<footer id="foots">
    <div class="container">
        <p class="text-muted pull-left">&copy; <?php echo Setting::get('skpd_name').' '.Setting::get('skpd_city') ?></p>
        <p class="text-muted pull-right"><?php echo get_conf('app_name') ?> Ver. <?php echo get_conf('app_version') ?></p>
    </div>
</footer>

<?php if ( $need_print ) : ?>
    <applet id="qz" name="QZ Print Plugin" code="qz.PrintApplet.class" width="55" height="55">
        <param name="jnlp_href" value="qz-print_jnlp.jnlp">
        <param name="cache_option" value="plugin">
    </applet>
<?php endif ?>

<?php echo get_foot() ?>
    <script charset="utf-8" type="text/javascript" src="<?php echo base_url('asset/js/lib/less.min.js') ?>"></script>
</body>
</html>