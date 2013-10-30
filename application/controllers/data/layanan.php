<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layanan extends BAKA_Controller
{
	public function __construct()
	{
		parent::__construct();

		// $this->data['user_id'] = Aplikasi::user_auth();

		$this->data['load_toolbar'] = TRUE;
		$this->baka_theme->set_title('Administrasi data');

		$this->baka_theme->add_navbar( 'data_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
		$this->app_main->data_navbar( 'data_sidebar', 'side');

		$this->data['page_link'] = 'data/layanan/';
	}

	public function index()
	{
		$this->semua();
	}

	public function ijin( $data_type = '', $page = 'data' )
	{
		if ( ! class_exists( $data_type ) )
			show_404();

		$this->data['page_link'] .= 'ijin/'.$data_type;

		if ($data_type !== '')
		{
			$this->$page( $data_type );
		}
		else
		{
			redirect('data/utama/semua');
		}
	}

	public function data( $data_type )
	{
		$delete_link = $this->data['page_link'].'/delete';

		$this->data['page_link']	.= '/form';
		$this->data['btn_text']		 = 'Baru';

		$this->data['panel_title']	 = $this->baka_theme->set_title( 'Semua data ' . $this->app_data->get_name( $data_type ) );
		$this->data['counter']		 = $this->app_data->count_data( $data_type );
		$this->data['panel_body']	 = $this->app_data->get_grid( $data_type, $this->data['page_link'], $delete_link );

		$this->baka_theme->load('pages/panel_data', $this->data);
	}

	public function form( $data_type )
	{
		$this->data['page_link']	.= '/data';
		$this->data['form_page']	 = TRUE;
		$this->data['btn_text']		 = 'Kembali';

		$this->data['panel_title']	= $this->baka_theme->set_title( 'Input data ' . $this->app_data->get_name( $data_type ) );
		$this->data['panel_body']	= $this->app_data->get_form( $data_type, $this->uri->segment(6), $this->data['page_link'] );

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	public function delete( $data_type )
	{
		if ( $delete = $this->app_data->delete_data( $this->uri->segment(6), $data_type ) )
		{
			$this->session->set_flashdata('message', $delete->message);
		}

		redirect( 'data/layanan/ijin/'.$data_type );
	}

	public function prints( $data_type, $data_id )
	{
		return true;
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