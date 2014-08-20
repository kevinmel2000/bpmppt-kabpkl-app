<!DOCTYPE html>
<html lang="<?php echo get_lang_code() ?>">
<head>
    <meta charset="<?php echo get_charset() ?>">
    <title><?php echo get_site_title() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="<?php echo get_conf('app_author') ?>">
    <link href="<?php echo base_url('asset/css/print.css') ?>" type="text/css" rel="stylesheet" media="all">
</head>
<body onload="window.print()" <?php echo get_body_attrs() ?>>
<?php $types = array('izin_reklame', 'izin_gangguan') ?>
<table width="100%" class="<?php echo $type ?>">
    <tr class="t-header">
        <td colspan="7" width="100%" <?php echo (in_array($type, $types) ? 'style="border: 1px solid #000"' : '') ?>>
<?php echo img( array(
    'src'   =>  $skpd_logo,
    'alt'   => 'Logo cetak',
    'class' => 'img',
    'width' => '62',
    'height'=> 'auto',
    'style' => 'position:absolute; top:0; left:5px;')); ?>
<p class="align-center bold" style="margin-top: 5px">
PEMERINTAH KABUPATEN PEKALONGAN<br>
<span style="font-size: 16px"><?php echo strtoupper($skpd_name) ?></span><br>
<span style="font-size: 10px;"><?php echo strtoupper($skpd_address.', telp. '.$skpd_telp.' '.$skpd_city.' '.$skpd_pos) ?></span></p>
        </td>
    </tr>
    <?php echo (in_array($type, $types) ? '<tr><td>'.nbs(1).'</td></tr>' : '') ?>
    <tr><td  <?php echo (in_array($type, $types) ? 'style="border: 1px solid #000"' : '') ?>><?php echo $contents; ?></td></tr>
</table>

</body>
</html>
