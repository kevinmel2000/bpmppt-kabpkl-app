<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layanan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// $this->data['user_id'] = Aplikasi::user_auth();

		$this->baka_theme->set_title('Administrasi data');

		$this->baka_theme->add_navbar( 'data_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
		$this->app_main->data_navbar( 'data_sidebar', 'side');
	}

	public function index()
	{
		$this->semua();
	}

	public function ijin( $service = '', $page = 'data' )
	{
		if ( ! class_exists( $service ) )
			show_404();

		if ($service !== '')
		{
			$this->$page( $service );
		}
		else
		{
			redirect('data/utama/semua');
		}
	}

	public function data( $service )
	{
		$this->data['panel_title'] = $this->baka_theme->set_title( 'Semua data ' . $this->app_data->get_name( $service ) );

		$this->data['counter'] = $this->app_data->count_data( $service );

		$this->data['panel_body'] = $this->app_data->get_grid( $service );

		$this->baka_theme->load('pages/panel_data', $this->data);
	}

	public function form( $service )
	{
		$this->data['panel_title'] = $this->baka_theme->set_title( 'Input data ' . $this->app_data->get_name( $service ) );

		$this->data['panel_body'] = $this->app_data->get_form( $service );

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	function _test()
	{
		switch ($segment = $this->uri->segment(5)) {
			case 'form':
				$this->_formulir($slug, $this->uri->segment(6));
				break;

			case 'print':
				$this->_print( $this->uri->segment(6) );
				break;

			case 'page':
			default:
				$configs['page_segment'] = 6;
				$configs['url'] = $this->data['link'];

				if ($segment == 'status') {
					$configs['find']['status'] = $this->uri->segment(6);
				}

				$this->data['perizinan'] = $this->perizinan->get_grid( $this->_label->slug, $configs );

				Template::load('datas/layanan', $this->data);
				break;
		}
	}
}

/* End of file layanan.php */
/* Location: ./application/controllers/layanan.php */