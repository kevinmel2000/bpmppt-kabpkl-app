<!DOCTYPE html>
<html lang="<?php echo get_lang_code() ?>">
<head>
    <meta charset="<?php echo get_charset() ?>">
    <title><?php echo get_site_title() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="<?php echo config_item('application_author') ?>">
    <link href="<?php echo base_url('asset/css/bpmppt-app-print.css') ?>" type="text/css" rel="stylesheet" media="all">
</head>
<body onload="window.print()" <?php echo get_body_attrs() ?>>

    <p class="align-center bold" style="display: block"><?php echo strtoupper($skpd_name.' '.$skpd_city) ?></p>
    <br>
    <p class="align-left bold" style="display:block;">
        <span style="display:inline-block; width:19%;"><?php echo strtoupper($skpd_city) ?></span>
        <span style="display:inline-block; width:80%;"><?php echo ': '.strtoupper($layanan) ?></span>
    </p>
    <p class="align-left bold" style="display:block;">
        <span style="display:inline-block; width:19%;">BULAN</span>
        <span style="display:inline-block; width:80%;"><?php echo ': '.strtoupper(bdate('%F %Y')) ?></span>
    </p>
    <br>
    <?php echo $contents; ?>
    <br><br>
    <p style="margin-left: 70%; width: 30%" class="align-center bold"><?php print_ttd_kadin() ?></p>

</body>
</html>
