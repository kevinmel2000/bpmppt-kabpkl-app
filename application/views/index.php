<!DOCTYPE html>
<html lang="<?php echo get_lang_code() ?>">
<head>
    <meta charset="<?php echo get_charset() ?>">
    <title><?php echo get_site_title() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="<?php echo get_conf('app_author') ?>">
    <?php echo load_scripts('head').load_styles() ?>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('asset/img/favicon/icon-144.png') ?>">
    <link rel="shortcut icon" href="<?php echo base_url('asset/img/favicon/favicon.png') ?>">
</head>
<body <?php echo get_body_class() ?>>

<div class="wrapper">
    <?php echo get_navbar() ?>
    <section id="contents">
        <div class="container"><?php echo form_alert() . $contents ?></div>
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

<?php echo load_scripts('foot') ?>
</body>
</html>