<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Utama extends BAKA_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->baka_theme->set_title('Dashboard');

		$this->baka_theme->add_navbar( 'data_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
		$this->app_main->data_navbar( 'data_sidebar', 'side');
	}

	public function index()
	{
		$this->stat();
	}

	public function stat()
	{
		$this->data['panel_title']	= $this->baka_theme->set_title('Dashboard ');
		$this->data['data_type']	= $this->app_data->get_type_list_assoc();
		$this->data['data_count']	= $this->app_data->count_data();
		$this->data['panel_body']	= 'anu';

		$this->baka_theme->load('pages/dashboard', $this->data);
	}

	public function semua()
	{
		$this->data['load_toolbar'] = TRUE;
		$this->data['search_form']	= TRUE;

		$data_list = $this->app_data->get_type_list_assoc();

		foreach ($data_list as $key => $value)
		{
			$this->data['tool_buttons']['Baru:dd|primary'][$key] = $value;
		}
		
		$this->data['data_type']	= $data_list;
		$this->data['panel_title']	= $this->baka_theme->set_title('Semua data perijinan');
		$this->data['panel_body']	= $this->app_data->get_grids();
		$this->data['counter']		= $this->app_data->count_data();

		$this->baka_theme->load('pages/panel_alldata', $this->data);
	}

	public function laporan()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Laporan data');

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
									));

		if (!$form->validate_submition())
			$this->data['panel_body'] = $form->render();
		else
			$this->data['panel_body'] = $form->submited_data();

		$this->baka_theme->load('pages/panel_form', $this->data);
	}
}

/* End of file utama.php */
/* Location: ./application/controllers/utama.php */