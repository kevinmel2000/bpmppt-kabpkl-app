<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Internal extends BAKA_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->baka_theme->add_navbar( 'admin_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
		$this->app_main->admin_navbar( 'admin_sidebar', 'side' );
	}

	public function index()
	{
		$this->skpd();
	}

	public function skpd()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Properti data SKPD');

		$fields[]	= array('name'	=> 'skpd_name',
							'type'	=> 'text',
							'label'	=> 'Nama SKPD',
							'std'	=> get_app_setting('skpd_name'),
							'validation'=>'required' );

		$fields[]	= array('name'	=> 'skpd_address',
							'type'	=> 'textarea',
							'label'	=> 'Alamat',
							'std'	=> get_app_setting('skpd_address'),
							'validation'=>'required' );

		$fields[]	= array('name'	=> 'skpd_city',
							'type'	=> 'text',
							'label'	=> 'Kota',
							'std'	=> get_app_setting('skpd_city'),
							'validation'=>'required' );

		$fields[]	= array('name'	=> 'skpd_prov',
							'type'	=> 'text',
							'label'	=> 'Propinsi',
							'std'	=> get_app_setting('skpd_prov'),
							'validation'=>'required' );

		$fields[]	= array('name'	=> 'skpd_telp',
							'type'	=> 'tel',
							'label'	=> 'No. Telp.',
							'std'	=> get_app_setting('skpd_telp'),
							'validation'=>'required|min_length[6]|max_length[15]' );

		$fields[]	= array('name'	=> 'skpd_pos',
							'type'	=> 'text',
							'label'	=> 'Kode Pos',
							'std'	=> get_app_setting('skpd_pos'),
							'validation'=>'numeric|exact_length[5]' );

		$fields[]	= array('name'	=> 'skpd_web',
							'type'	=> 'url',
							'label'	=> 'Alamat Web',
							'std'	=> get_app_setting('skpd_web')  );

		$fields[]	= array('name'	=> 'skpd_email',
							'type'	=> 'email',
							'label'	=> 'Alamat Email',
							'std'	=> get_app_setting('skpd_email'),
							'validation'=>'valid_email' );

		$this->data['panel_body'] = $this->_option_form( $fields );

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	public function app()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Pengaturan Aplikasi');

		$fields[]	= array('name'	=> 'app_data_show_limit',
							'type'	=> 'number',
							'label'	=> 'Jumlah data ditampilkan',
							'std'	=> get_app_setting('app_data_show_limit'),
							'desc'	=> 'Jumlah data yang ditampilkan ditiap halaman',
							'validation'=>'required|numeric' );

		$fields[]	= array('name'	=> 'app_date_format',
							'type'	=> 'text',
							'label'	=> 'Format Tanggal',
							'std'	=> get_app_setting('app_date_format'),
							'desc'	=> 'Format tanggal menggunakan dasar '.anchor('http://php.net/manual/en/function.date.php', 'pengformatan tanggal pada PHP'),
							'validation'=>'required' );

		$fields[]	= array('name'	=> 'app_datetime_format',
							'type'	=> 'text',
							'label'	=> 'Format Waktu &amp; Tanggal',
							'std'	=> get_app_setting('app_datetime_format'),
							'desc'	=> 'Format tanggal dan waktu menggunakan dasar '.anchor('http://php.net/manual/en/function.date.php', 'pengformatan tanggal pada PHP'),
							'validation'=>'required' );

		$fields[]	= array('name'	=> 'app_fieldset_email',
							'type'	=> 'fieldset',
							'label'	=> 'Pengaturan Email' );

		$email_protocol = get_app_setting('email_protocol');

		$fields[]	= array('name'	=> 'email_protocol',
							'type'	=> 'radiobox',
							'label'	=> 'Email Protocol',
							'option'=> array(
								'mail'		=> 'Mail',
								'sendmail'	=> 'Sendmail',
								'smtp'		=> 'SMPT'),
							'std'	=> $email_protocol );

		$fields[]	= array('name'	=> 'email_mailpath',
							'type'	=> 'text',
							'label'	=> 'Email_mailpath',
							'std'	=> get_app_setting('email_mailpath') );

		$smtp_enabled = ( $email_protocol != 'smtp' ? 'disabled' : '');

		$fields[]	= array('name'	=> 'email_smtp_host',
							'type'	=> 'text',
							'label'	=> 'Host SMTP',
							'attr'	=> $smtp_enabled,
							'std'	=> get_app_setting('email_smtp_host') );

		$fields[]	= array('name'	=> 'email_smtp_user',
							'type'	=> 'text',
							'label'	=> 'Pengguna SMTP',
							'attr'	=> $smtp_enabled,
							'std'	=> get_app_setting('email_smtp_user') );

		$fields[]	= array('name'	=> 'email_smtp_pass',
							'type'	=> 'text',
							'label'	=> 'Password SMTP',
							'attr'	=> $smtp_enabled,
							'std'	=> get_app_setting('email_smtp_pass') );

		$fields[]	= array('name'	=> 'email_smtp_port',
							'type'	=> 'text',
							'label'	=> 'Port SMTP',
							'attr'	=> $smtp_enabled,
							'std'	=> get_app_setting('email_smtp_port') );

		$fields[]	= array('name'	=> 'email_smtp_timeout',
							'type'	=> 'text',
							'label'	=> 'Batas waktu SMTP',
							'attr'	=> $smtp_enabled,
							'std'	=> get_app_setting('email_smtp_timeout') );

		$fields[]	= array('name'	=> 'email_wordwrap',
							'type'	=> 'radiobox',
							'label'	=> 'Wordwrap',
							'option'=> array(
								0	=> 'Tidak',
								1	=> 'Ya' ),
							'std'	=> get_app_setting('email_wordwrap') );

		$fields[]	= array('name'	=> 'email_mailtype',
							'type'	=> 'radiobox',
							'label'	=> 'Tipe email',
							'option'=> array(
								'text'	=> 'Teks Email',
								'html'	=> 'HTML Email' ),
							'std'	=> get_app_setting('email_mailtype') );

		$fields[]	= array('name'	=> 'email_priority',
							'type'	=> 'number',
							'label'	=> 'Prioritas',
							'std'	=> get_app_setting('email_priority'),
							'desc'	=> 'Prioritas email diisi dengan angka 1-5, angka 1 untuk paling tinggi dan 5 untuk paling rendah.',
							'validation'=> 'numeric|greater_than[0]|less_than[6]' );

		$this->data['panel_body'] = $this->_option_form( $fields );

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	public function keamanan()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Pengaturan Keamanan');

		$fields[]	= array('name'	=> 'auth_username_length',
							'type'	=> 'subfield',
							'label'	=> 'Jumlah karakter Username',
							'fields'=> array(
								array(	'name'	=> 'min',
										'col'	=> 6,
										'type'	=> 'number',
										'label'	=> 'Minimal',
										'std'	=> get_app_setting('auth_username_min_length'),
										'validation'=>'required|numeric' ),
								array(	'name'	=> 'max',
										'col'	=> 6,
										'type'	=> 'number',
										'label'	=> 'Maksimal',
										'std'	=> get_app_setting('auth_username_max_length'),
										'validation'=>'required|numeric' )
								),
							'desc'	=> 'Jumlah minimal dan maksimal karakter Username' );

		$fields[]	= array('name'	=> 'auth_password_length',
							'type'	=> 'subfield',
							'label'	=> 'Jumlah karakter Password',
							'fields'=> array(
								array(	'name'	=> 'min',
										'col'	=> 6,
										'type'	=> 'number',
										'label'	=> 'Minimal',
										'std'	=> get_app_setting('auth_password_min_length'),
										'validation'=>'required|numeric' ),
								array(	'name'	=> 'max',
										'col'	=> 6,
										'type'	=> 'number',
										'label'	=> 'Maksimal',
										'std'	=> get_app_setting('auth_password_max_length'),
										'validation'=>'required|numeric' )
								),
							'desc'	=> 'Jumlah minimal dan maksimal karakter Password' );

		$fields[]	= array('name'	=> 'auth_fieldset_register',
							'type'	=> 'fieldset',
							'label'	=> 'Pendaftaran' );

		$fields[]	= array('name'	=> 'auth_allow_registration',
							'type'	=> 'radiobox',
							'label'	=> 'Ijinkan registrasi Umum',
							'std'	=> get_app_setting('auth_allow_registration'),
							'option'=> array(
								0	=> 'Tidak',
								1	=> 'Ya' ),
							'desc'	=> 'Ijinkan registrasi umum',
							'validation'=>'required|numeric' );

		$fields[]	= array('name'	=> 'auth_email_activation',
							'type'	=> 'radiobox',
							'label'	=> 'Aktivasi via email',
							'std'	=> get_app_setting('auth_email_activation'),
							'option'=> array(
								0	=> 'Tidak',
								1	=> 'Ya' ),
							'validation'=>'required' );

		$auth_email_act_expire = get_app_setting('auth_email_act_expire');

		$fields[]	= array('name'	=> 'auth_email_act_expire',
							'type'	=> 'number',
							'label'	=> 'Batas aktivasi email',
							'std'	=> $auth_email_act_expire,
							'desc'	=> 'Batas waktu aktivasi email dalam detik. Nilai '.$auth_email_act_expire.' detik = '.second_to_day( $auth_email_act_expire ).' hari.',
							'validation'=>'required|numeric' );

		$fields[]	= array('name'	=> 'auth_use_username',
							'type'	=> 'radiobox',
							'label'	=> 'Gunakan username',
							'std'	=> get_app_setting('auth_use_username'),
							'option'=> array(
								0	=> 'Tidak',
								1	=> 'Ya' ),
							'desc'	=> 'Gunakan username untuk setiap pengguna.',
							'validation'=>'required' );

		$fields[]	= array('name'	=> 'auth_fieldset_login',
							'type'	=> 'fieldset',
							'label'	=> 'Login' );

		$fields[]	= array('name'	=> 'auth_login_by_username',
							'type'	=> 'radiobox',
							'label'	=> 'Gunakan username saat login',
							'std'	=> get_app_setting('auth_login_by_username'),
							'option'=> array(
								0	=> 'Tidak',
								1	=> 'Ya' ),
							'validation'=>'required' );

		$fields[]	= array('name'	=> 'auth_login_by_email',
							'type'	=> 'radiobox',
							'label'	=> 'Gunakan email saat login',
							'std'	=> get_app_setting('auth_login_by_email'),
							'option'=> array(
								0	=> 'Tidak',
								1	=> 'Ya' ),
							'validation'=>'required' );

		$fields[]	= array('name'	=> 'auth_login_record_ip',
							'type'	=> 'radiobox',
							'label'	=> 'Rekam IP',
							'std'	=> get_app_setting('auth_login_record_ip'),
							'option'=> array(
								0	=> 'Tidak',
								1	=> 'Ya' ),
							'validation'=>'required' );

		$fields[]	= array('name'	=> 'auth_login_count_attempts',
							'type'	=> 'radiobox',
							'label'	=> 'Hitung kegagalan login',
							'std'	=> get_app_setting('auth_login_count_attempts'),
							'option'=> array(
								0	=> 'Tidak',
								1	=> 'Ya' ),
							'validation'=>'required' );

		$fields[]	= array('name'	=> 'auth_login_max_attempts',
							'type'	=> 'number',
							'label'	=> 'Maksimum login',
							'std'	=> get_app_setting('auth_login_max_attempts'),
							'desc'	=> 'batas maksimum login untuk tiap pengguna',
							'validation'=>'required' );

		$auth_login_attempt_expire = get_app_setting('auth_login_attempt_expire');

		$fields[]	= array('name'	=> 'auth_login_attempt_expire',
							'type'	=> 'number',
							'label'	=> 'Masa kadaluarsa login',
							'std'	=> $auth_login_attempt_expire,
							'desc'	=> 'Batas waktu pengguna dapat login kembali dalam detik. Nilai '.$auth_login_attempt_expire.' detik = '.second_to_day( $auth_login_attempt_expire ).' hari.',
							'validation'=>'required' );

		$fields[]	= array('name'	=> 'auth_fieldset_captcha',
							'type'	=> 'fieldset',
							'label'	=> 'Validasi Tambahan' );

		$fields[]	= array('name'	=> 'auth_captcha_registration',
							'type'	=> 'radiobox',
							'label'	=> 'Gunakan captcha',
							'std'	=> get_app_setting('auth_captcha_registration'),
							'option'=> array(
								0	=> 'Tidak',
								1	=> 'Ya' ),
							'validation'=>'required' );

		$fields[]	= array('name'	=> 'auth_use_recaptcha',
							'type'	=> 'radiobox',
							'label'	=> 'Gunakan reCaptcha',
							'std'	=> get_app_setting('auth_use_recaptcha'),
							'option'=> array(
								0	=> 'Tidak',
								1	=> 'Ya' ),
							'desc'	=> 'Gunakan '.anchor('https://www.google.com/recaptcha', 'google reCaptcha', 'target="_blank"').' untuk validasi.',
							'validation'=>'required' );

		$key_attr = '';
		$key_validation = 'required';

		if ( get_app_setting('auth_use_recaptcha') == 0 )
		{
			$key_attr = 'disabled';
			$key_validation = '';
		}

		$fields[]	= array('name'	=> 'auth_recaptcha_public_key',
							'type'	=> 'text',
							'attr'	=> $key_attr,
							'label'	=> 'reCaptcha public key',
							'std'	=> get_app_setting('auth_recaptcha_public_key'),
							'validation'=> $key_validation );

		$fields[]	= array('name'	=> 'auth_recaptcha_private_key',
							'type'	=> 'text',
							'attr'	=> $key_attr,
							'label'	=> 'reCaptcha private key',
							'std'	=> get_app_setting('auth_recaptcha_private_key'),
							'validation'=> $key_validation );

		$fields[]	= array('name'	=> 'auth_fieldset_blacklist',
							'type'	=> 'fieldset',
							'label'	=> 'Daftar hitam' );

		$fields[]	= array('name'	=> 'auth_username_blacklist',
							'type'	=> 'text',
							'label'	=> 'Nama pengguna',
							'std'	=> get_app_setting('auth_username_blacklist'),
							'desc'	=> 'Daftar username yang tidak diijinkan, dipisahkan dengan tanda koma (,)' );

		$fields[]	= array('name'	=> 'auth_username_blacklist_prepend',
							'type'	=> 'text',
							'label'	=> 'Awalan Nama Pengguna',
							'std'	=> get_app_setting('auth_username_blacklist_prepend'),
							'desc'	=> 'Daftar kata awalan username yang tidak diijinkan, dipisahkan dengan tanda koma (,)' );

		$fields[]	= array('name'	=> 'auth_username_exceptions',
							'type'	=> 'text',
							'label'	=> 'Username Pengecualian',
							'std'	=> get_app_setting('auth_username_exceptions'),
							'desc'	=> 'Daftar pengecualian username yang diijinkan, dipisahkan dengan tanda koma (,)' );

		$this->data['panel_body'] = $this->_option_form( $fields );

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	public function prop()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Pengaturan Properti Data');

		// $query = $this->db->get('system_opt');

		$this->data['panel_body'] = '';
		
		$this->baka_theme->load('pages/test_panel', $this->data);
	}

	private function _option_form( $fields )
	{
		$form = $this->baka_form->add_form( current_url(), 'internal-skpd' )
								->add_fields( $fields );

		if ( $form->validate_submition() )
		{
			foreach ( $form->submited_data() as $opt_key => $opt_val )
			{
				$return = FALSE;

				if ( get_app_setting( $opt_key ) != $opt_val )
					$return = set_app_setting( $opt_key, $opt_val );
			}

			redirect( current_url() );

			// if ( $return )
			// 	$this->baka_lib->set_message('Berhasil' );
			// else
			// 	$this->baka_lib->set_message('Gagal' );
		}

		return $form->render();
	}
}

/* End of file internal.php */
/* Location: ./application/controllers/internal.php */