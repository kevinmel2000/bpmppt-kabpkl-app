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

		$form = $this->baka_form->add_form( current_url(), 'internal-skpd' )
								->add_fields(array(
									array(
										'name'	=> 'skpd_name',
										'type'	=> 'text',
										'label'	=> 'Nama SKPD',
										'std'	=> get_app_setting('skpd_name'),
										),
									array(
										'name'	=> 'skpd_address',
										'type'	=> 'text',
										'label'	=> 'Alamat',
										'std'	=> get_app_setting('skpd_address'),
										),
									array(
										'name'	=> 'skpd_city',
										'type'	=> 'text',
										'label'	=> 'Kota',
										'std'	=> get_app_setting('skpd_city'),
										),
									array(
										'name'	=> 'skpd_prov',
										'type'	=> 'text',
										'label'	=> 'Propinsi',
										'std'	=> get_app_setting('skpd_prov'),
										),
									array(
										'name'	=> 'skpd_telp',
										'type'	=> 'text',
										'label'	=> 'No. Telp.',
										'std'	=> get_app_setting('skpd_telp'),
										),
									array(
										'name'	=> 'skpd_fax',
										'type'	=> 'text',
										'label'	=> 'No. Fax.',
										'std'	=> get_app_setting('skpd_fax'),
										),
									array(
										'name'	=> 'skpd_pos',
										'type'	=> 'text',
										'label'	=> 'Kode Pos',
										'std'	=> get_app_setting('skpd_pos'),
										),
									array(
										'name'	=> 'skpd_web',
										'type'	=> 'url',
										'label'	=> 'Alamat Web',
										'std'	=> get_app_setting('skpd_web'),
										),
									array(
										'name'	=> 'skpd_email',
										'type'	=> 'email',
										'label'	=> 'Alamat Email',
										'std'	=> get_app_setting('skpd_email'),
										),
									));

		if ( $form->validate_submition() )
		{
			foreach ($form->submited_data() as $opt_key => $opt_val)
			{
				$return = FALSE;

				if ( get_app_setting($opt_key) != $opt_val )
					$return = $this->app_settings->set($opt_key, $opt_val);
			}

			if ( $return )
				$this->baka_app->set_message('Berhasil', 'success');
			else
				$this->baka_app->set_message('Gagal', 'danger');
		}

		$this->data['panel_body'] = $form->render();

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	public function app()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Pengaturan Aplikasi');

		$form = $this->baka_form->add_form( current_url(), 'internal-skpd' )
								->add_fields(array(
									array(
										'name'	=> 'app_data_show_limit',
										'type'	=> 'number',
										'label'	=> 'Tampilan Data Tiap halaman',
										'std'	=> get_app_setting('app_data_show_limit'),
										),
									array(
										'name'	=> 'app_date_format',
										'type'	=> 'text',
										'label'	=> 'Format Tanggal',
										'std'	=> get_app_setting('app_date_format'),
										),
									array(
										'name'	=> 'app_datetime_format',
										'type'	=> 'text',
										'label'	=> 'Format Waktu &amp; Tanggal',
										'std'	=> get_app_setting('app_datetime_format'),
										),
									));

		if (!$form->validate_submition())
			$this->data['panel_body'] = $form->render();
		else
			$this->data['panel_body'] = $form->submited_data();

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	public function prop()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Pengaturan Properti Data');

		// $query = $this->db->get('system_opt');

		$this->data['panel_body'] = '';
		
		$this->baka_theme->load('pages/test_panel', $this->data);
	}
}

/* End of file internal.php */
/* Location: ./application/controllers/internal.php */