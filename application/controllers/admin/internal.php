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

		$fields[]	= array(
			'name'	=> 'skpd_name',
			'type'	=> 'text',
			'label'	=> 'Nama SKPD',
			'std'	=> get_app_setting('skpd_name'),
			'validation'=>'required' );

		$fields[]	= array(
			'name'	=> 'skpd_addrresses',
			'type'	=> 'fieldset',
			'label'	=> 'Data Alamat SKPD' );

		$fields[]	= array(
			'name'	=> 'skpd_address',
			'type'	=> 'textarea',
			'label'	=> 'Alamat',
			'std'	=> get_app_setting('skpd_address'),
			'validation'=>'required' );

		$fields[]	= array(
			'name'	=> 'skpd_city',
			'type'	=> 'text',
			'label'	=> 'Kota',
			'std'	=> get_app_setting('skpd_city'),
			'validation'=>'required' );

		$fields[]	= array(
			'name'	=> 'skpd_kab',
			'type'	=> 'text',
			'label'	=> 'Lokasi',
			'std'	=> get_app_setting('skpd_kab'),
			'validation'=>'required' );

		$fields[]	= array(
			'name'	=> 'skpd_prov',
			'type'	=> 'text',
			'label'	=> 'Propinsi',
			'std'	=> get_app_setting('skpd_prov'),
			'validation'=>'required' );

		$fields[]	= array(
			'name'	=> 'skpd_contact',
			'type'	=> 'fieldset',
			'label'	=> 'Data Kontak SKPD' );

		$fields[]	= array(
			'name'	=> 'skpd_telp',
			'type'	=> 'tel',
			'label'	=> 'No. Telp.',
			'std'	=> get_app_setting('skpd_telp'),
			'validation'=>'required|min_length[6]|max_length[15]' );

		$fields[]	= array(
			'name'	=> 'skpd_fax',
			'type'	=> 'tel',
			'label'	=> 'No. Telp.',
			'std'	=> get_app_setting('skpd_fax'),
			'validation'=>'required|min_length[6]|max_length[15]' );

		$fields[]	= array(
			'name'	=> 'skpd_pos',
			'type'	=> 'text',
			'label'	=> 'Kode Pos',
			'std'	=> get_app_setting('skpd_pos'),
			'validation'=>'numeric|exact_length[5]' );

		$fields[]	= array(
			'name'	=> 'skpd_web',
			'type'	=> 'url',
			'label'	=> 'Alamat Web',
			'std'	=> get_app_setting('skpd_web')  );

		$fields[]	= array(
			'name'	=> 'skpd_email',
			'type'	=> 'email',
			'label'	=> 'Alamat Email',
			'std'	=> get_app_setting('skpd_email'),
			'validation'=>'valid_email' );

		$fields[]	= array(
			'name'	=> 'skpd_leader',
			'type'	=> 'fieldset',
			'label'	=> 'Data Pimpinan SKPD' );

		$fields[]	= array(
			'name'	=> 'skpd_lead_name',
			'type'	=> 'text',
			'label'	=> 'Nama Pimpinan',
			'std'	=> get_app_setting('skpd_lead_name'),
			'validation'=>'required' );

		$fields[]	= array(
			'name'	=> 'skpd_lead_nip',
			'type'	=> 'text',
			'label'	=> 'Nama Pimpinan',
			'std'	=> get_app_setting('skpd_lead_nip'),
			'validation'=>'required' );

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

		if ( $email_protocol == 'sendmail' )
		{
			$fields[]	= array('name'	=> 'email_mailpath',
								'type'	=> 'text',
								'label'	=> 'Email path',
								'std'	=> get_app_setting('email_mailpath') );
		}
		else if ( $email_protocol == 'smtp' )
		{
			$fields[]	= array('name'	=> 'email_smtp_host',
								'type'	=> 'text',
								'label'	=> 'Host SMTP',
								'std'	=> get_app_setting('email_smtp_host'),
								'validation'=> 'required' );

			$fields[]	= array('name'	=> 'email_smtp_user',
								'type'	=> 'text',
								'label'	=> 'Pengguna SMTP',
								'std'	=> get_app_setting('email_smtp_user'),
								'validation'=> 'required|valid_email' );

			$fields[]	= array('name'	=> 'email_smtp_pass',
								'type'	=> 'password',
								'label'	=> 'Password SMTP',
								'std'	=> get_app_setting('email_smtp_pass'),
								'validation'=> 'required' );

			$fields[]	= array('name'	=> 'email_smtp_port',
								'type'	=> 'number',
								'label'	=> 'Port SMTP',
								'std'	=> get_app_setting('email_smtp_port'),
								'validation'=> 'required|numeric' );

			$fields[]	= array('name'	=> 'email_smtp_timeout',
								'type'	=> 'number',
								'label'	=> 'Batas waktu SMTP',
								'std'	=> get_app_setting('email_smtp_timeout'),
								'validation'=> 'numeric' );
		}

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

	private $env_table = 'system_env';

	public function prop( $page = '', $prop_id = NULL )
	{
		$this->data['page_link'] = 'admin/internal/prop/';

		$this->data['load_toolbar']	= TRUE;

		switch ( $page ) {
			case 'form':
				$this->_prop_form( $prop_id );
				break;

			case 'hapus':
				$this->_prop_del( $prop_id );
				break;

			case 'data':
			default:
				$this->_prop_data();
				break;
		}
	}

	private function _prop_data()
	{
		$this->data['panel_title']	= $this->baka_theme->set_title('Pengaturan Properti Data');

		$this->data['tool_buttons']['form'] = 'Baru|primary';

		$this->load->library('baka_pack/baka_grid');

		$query = $this->db->select()
						  ->from($this->env_table)
						  ->where('user_id', $this->baka_auth->get_user_id())
						  ->or_where('user_id', 0);

		$grid = $this->baka_grid->identifier('id')
								->set_baseurl($this->data['page_link'])
								->set_column('Key', 'env_key', '45%', FALSE, '<strong>%s</strong>')
								->set_column('Value', 'env_value', '40%', FALSE, '%s')
								->set_buttons('form/', 'eye-open', 'primary', 'Lihat data')
								->set_buttons('hapus/', 'trash', 'danger', 'Hapus data');
						  
		$this->data['panel_body'] = $grid->make_table( $query );

		$this->baka_theme->load('pages/panel_data', $this->data);
	}

	private function _prop_form( $prop_id = NULL )
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Pengaturan Properti Data');

		$this->data['tool_buttons']['data'] = 'Kembali|default';

		$prop = (! is_null($prop_id) ? $this->db->get_where($this->env_table, array('id' => $prop_id) ) : FALSE );

		$fields[]	= array('name'	=> 'app_env_key',
							'type'	=> 'text',
							'label'	=> 'Nama Properti',
							'std'	=> ( $prop ? $prop->env_key : '' ),
							'validation'=> ( !$prop ? 'required' : '' ) );

		$fields[]	= array('name'	=> 'app_env_value',
							'type'	=> 'text',
							'label'	=> 'Nilai Properti',
							'std'	=> ( $prop ? $prop->env_value : '' ),
							'validation'=> ( !$prop ? 'required' : '' ) );

		$form = $this->baka_form->add_form( current_url(), 'internal-prop' )
								->add_fields( $fields );

		if ( $form->validate_submition() )
		{
			$return = FALSE;

			$form_data = $form->submited_data();

			if ( $prop )
			{
				$return = $this->db->update($this->env_table, array('env_key'	=> $form_data['app_env_value'],
																	'env_value'	=> $form_data['app_env_value'] ),
															  array('id'		=> $prop_id ));
			}
			else
			{
				$return = $this->db->insert($this->env_table, array('user_id'	=> $this->baka_auth->get_user_id(),
																	'env_key'	=> $form_data['app_env_value'],
																	'env_value'	=> $form_data['app_env_value'] ));
			}

			if ( $return === FALSE )
			{
				$this->session->set_flashdata('error', array('Terjadi masalah penyimpanan konfigurasi.'));
				redirect( current_url() );
			}
			else
			{
				$this->session->set_flashdata('success', array('Properti berhasil disimpan.'));
				redirect( $this->data['page_link'].'data/' );
			}
		}

		$this->data['panel_body'] = $form->render();

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	private function _prop_del( $prop_id )
	{
		if ( $this->db->delete( $this->env_table, array('id' => $prop_id) ) )
		{
			$this->session->set_flashdata('success', array('Properti berhasil dihapus.'));
			redirect( current_url() );
		}
		else
		{
			$this->session->set_flashdata('error', array('Terjadi masalah penghapusan konfigurasi.'));
			redirect( current_url() );
		}
	}

	private function _option_form( $fields )
	{
		$form = $this->baka_form->add_form( current_url(), 'internal-skpd' )
								->add_fields( $fields );

		if ( $form->validate_submition() )
		{
			$return = FALSE;

			$this->db->trans_start();

			foreach ( $form->submited_data() as $opt_key => $opt_val )
			{
				if ( get_app_setting( $opt_key) != $opt_val )
				{
					set_app_setting( $opt_key, $opt_val );

					$return = TRUE;
				}
			}

			$this->db->trans_complete();

			if ( $return === FALSE )
				$this->session->set_flashdata('error', array('Terjadi masalah penyimpanan konfigurasi.'));
			else
				$this->session->set_flashdata('success', array('Konfigurasi berhasil disimpan.'));

			redirect( current_url() );
		}

		return $form->render();
	}
}

/* End of file internal.php */
/* Location: ./application/controllers/internal.php */