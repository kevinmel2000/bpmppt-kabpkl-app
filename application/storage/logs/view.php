<?php

define('BASEPATH', '');

// $dir_name = dirname(__FILE__);
$files = glob('log-*.php');

arsort($files);
echo '<ol style="float: left; margin: 0; width:132px;">';
foreach ($files as $file)
{
	echo '<li><a href="?f='.$file.'">'.$file.'</a></li>';
}
echo '</ol>';

if (isset($_GET['f']))
{
	$f = $_GET['f'];

	$out = '<pre style="margin-left: 200px;">';

	$content = file_get_contents($f);
	$content = str_replace('<?php ', '<', $content);
	$content = str_replace(' ?>', '>', $content);

	$out .= $content;
	$out .= '</pre>';

	echo $out;
}
