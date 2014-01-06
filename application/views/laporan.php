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
<p style="text-align: center; font-weight: bold;"><?php echo strtoupper($skpd_name.' '.$skpd_city) ?></p>
<p>&nbsp;</p>
<p style="font-weight: bold; display: block;"><span style="display: inline-block; width: 20%;">KABUPATEN PEKALONGAN</span><span style="display: inline-block; width:80%;"><?php echo ': '.strtoupper($layanan) ?></span></p>
<p style="font-weight: bold; display: block;"><span style="display: inline-block; width: 20%;">BULAN</span><span style="display: inline-block; width:80%;"><?php echo ': '.strtoupper(bdate('F Y')) ?></span></p>
<p>&nbsp;</p>

<?php echo $contents; ?>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="margin-left: 70%; width: 30%" class="align-center">Kajen, <?php echo format_date() ?></p>
<p style="margin-left: 70%; width: 30%" class="align-center">Kepala <?php echo $skpd_name ?></p>
<p style="margin-left: 70%; width: 30%" class="align-center"><?php echo $skpd_city ?></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="margin-left: 70%; width: 30%; font-weight: bold;" class="align-center"><?php echo $skpd_lead_name ?></p>
<p style="margin-left: 70%; width: 30%" class="align-center">Pembina Tingkat I</p>
<p style="margin-left: 70%; width: 30%" class="align-center">NIP. <?php echo $skpd_lead_nip ?></p>

</body>
</html>