<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layanan extends BAKA_Controller
{
	public function __construct()
	{
		parent::__construct();

		// $this->data['user_id'] = Aplikasi::user_auth();

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

		$this->data['load_toolbar']	= TRUE;
		$this->data['page_link']   .= 'ijin/'.$data_type.'/';

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
		$this->data['search_form']	= TRUE;
		$this->data['tool_buttons'][$this->data['page_link'].'form'] = 'Baru|primary';
		$this->data['tool_buttons'][$this->data['page_link'].'status|default'] = array('aktif'=>'Aktif','nonaktif'=>'non-Aktif');

		$delete_link = $this->data['page_link'].'/delete';

		$this->data['page_link']	.= '/form';
		$this->data['btn_text']		 = 'Baru';

		$this->data['panel_title']	 = $this->baka_theme->set_title( 'Semua data ' . $this->app_data->get_name( $data_type ) );
		$this->data['panel_body']	 = $this->app_data->get_grid( $data_type, $this->data['page_link'] );
		$this->data['counter']		 = $this->app_data->count_data( $data_type );

		$this->baka_theme->load('pages/panel_data', $this->data);
	}

	public function form( $data_type )
	{
		$this->data['tool_buttons'][$this->data['page_link'].'data'] = 'Kembali|default';
		$this->data['tool_buttons'][$this->data['page_link'].'cetak'] = 'Cetak|default';
		$this->data['tool_buttons']['Ubah status:dd|default'] = array($this->data['page_link'].'aktif'=>'Aktif',$this->data['page_link'].'nonaktif'=>'non-Aktif');

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

	public function cetak( $data_type )
	{
		$this->data['skpd_name']	= get_app_setting('skpd_name');
		$this->data['skpd_address']	= get_app_setting('skpd_address');
		$this->data['skpd_city']	= get_app_setting('skpd_city');
		$this->data['skpd_prov']	= get_app_setting('skpd_prov');
		$this->data['skpd_telp']	= get_app_setting('skpd_telp');
		$this->data['skpd_fax']		= get_app_setting('skpd_fax');
		$this->data['skpd_pos']		= get_app_setting('skpd_pos');
		$this->data['skpd_web']		= get_app_setting('skpd_web');
		$this->data['skpd_email']	= get_app_setting('skpd_email');
		$this->data['skpd_logo']	= get_app_setting('skpd_logo');

		$this->baka_theme->load('prints/'.$data_type, $this->data, 'print');
	}

	public function test( $data_type, $data_id )
	{
		$this->data['panel_title']	= $this->baka_theme->set_title( 'Input data ' . $this->app_data->get_name( $data_type ) );
		$this->data['panel_body'] = $this->app_data->get_print( $data_type, $data_id );

		$this->baka_theme->load('pages/panel_form', $this->data);
	}
}

/* End of file layanan.php */
/* Location: ./application/controllers/layanan.php */