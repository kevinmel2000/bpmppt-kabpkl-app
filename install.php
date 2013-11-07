<?php

define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

define('ABSPATH', str_replace(SELF, '', __FILE__));

$hostname = 'http://'.str_replace(SELF, '', $_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);

if ( isset($_POST) )
	extract($_POST);

?>

<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<title>Install</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Fery Wardiyanto">
	<meta name="description" content="Installation">

	<link rel="stylesheet" href="asset/css/install.css">

	<style>
	.install {
		width: 500px;
		margin: 60px auto 0;
		padding: 15px;
		padding-bottom: 0;
		border: 1px solid #ddd;
		background: #fff;
	}
	.install .title {
		border-bottom: 1px solid #ddd;
		background: transparent;
		margin-bottom: 15px;
		padding: 0;
		padding-bottom: 10px;
	}
	</style>
</head>
<body>
	<div class="install">
		<h3 class="title">Oops! ada sedikti kekurangan.</h3>
		<p>Kelihatanya aplikasi belum terinstall dengan benar. Silakan isi formulir dibawah ini dengan benar dan selesaikan proses installasi agar aplikasi dapat segera anda gunakan.</p>
		<?php if ( isset($submit) ) echo install() ; ?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" name="form_siswa">
			<fieldset>
				<legend>Aplikasi</legend>
				<div class="group-input">
					<label class="label" for="base_url">URL Aplikasi</label>
					<input type="text" name="base_url" id="base_url" value="<?php echo $hostname; ?>" autofocus>
				</div>
			</fieldset>
			<fieldset>
				<legend>Database</legend>
				<div class="group-input">
					<label class="label" for="db_host">Hostname</label>
					<input type="text" name="db_host" id="db_host" value="<?php echo isset($db_host) ? $db_host : 'localhost'; ?>">
				</div>
				<div class="group-input">
					<label class="label" for="db_user">Username</label>
					<input type="text" name="db_user" id="db_user" value="<?php echo isset($db_user) ? $db_user : 'root'; ?>">
				</div>
				<div class="group-input">
					<label class="label" for="db_pass">Password</label>
					<input type="text" name="db_pass" id="db_pass" value="<?php echo isset($db_pass) ? $db_pass : ''; ?>">
				</div>
				<div class="group-input">
					<label class="label" for="db_name">Nama Database</label>
					<input type="text" name="db_name" id="db_name" value="<?php echo isset($db_name) ? $db_name : ''; ?>">
				</div>
				<div class="group-input">
					<label class="label" for="db_pref">Awalan Database</label>
					<input type="text" name="db_pref" id="db_pref" value="<?php echo isset($db_pref) ? $db_pref : 'app_'; ?>">
				</div>
			</fieldset>
			<div class="group-action">
				<input type="submit" name="submit" value="Pasang">
				<input type="reset" name="cancel" value="Batal">
			</div>
		</form>
	</div>
</body>
</html>

<?php

function install()
{
	$filepath = str_replace(SELF, '', $_SERVER['SCRIPT_NAME']);

	extract( $_POST );

	error_reporting(0);

	if( ! ($connect = mysql_connect( $db_host, $db_user, $db_pass )) )
		$errors[] = 'Koneksi server tidak ditemukan.';

	if( !mysql_select_db( $db_name, $connect ) )
		$errors[] = 'Database <b>"'.$db_name.'"</b> tidak ditemukan pada server <b>"'.$db_host.'"</b>.';

	$sql_file = realpath( ABSPATH.'asset/sql/install.sql');

	if ( strlen( $db_pass ) > 0 )
		$db_pass = " -p" . $db_pass;
	
	shell_exec( "mysql -u" . $db_user . $db_pass . " <" . $sql_file );

	if ( ! mysql_affected_rows( $connect ) )
		$errors[] = 'Proses installasi gagal.';

	if( isset( $errors ) && count( $errors ) > 0 )
	{
		foreach ($errors as $error)
		{
			return '<span class="alert error">'.$error.'</span>';
		}
	}
	else
	{
		return "<span class='alert info'>Proses installasi selesai. Enjoy!</span><meta http-equiv='refresh' content='1;url=$base_url'>";
	}
}