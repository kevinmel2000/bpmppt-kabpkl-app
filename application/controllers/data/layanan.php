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
		redirect( 'dashboard' );
	}

	public function ijin( $data_type = '', $page = 'data', $data_id = NULL )
	{
		if ( ! class_exists( $data_type ) )
			show_404();

		$this->data['load_toolbar']	= TRUE;
		$this->data['page_link']   .= 'ijin/'.$data_type.'/';

		switch ( $page )
		{
			case 'form':
				$this->form( $data_type, $data_id );
				break;

			case 'cetak':
				$this->cetak( $data_type, $data_id );
				break;

			case 'hapus':
				$this->ubah_status( 'deleted', $data_id, $this->data['page_link'] );
				break;

			case 'ubah-status':
				$this->ubah_status( $this->uri->segment(7) , $data_id, $this->data['page_link'] );
				break;

			case 'data':
			default:
				$this->data( $data_type );
				break;
		}
	}

	public function data( $data_type )
	{
		$this->data['search_form']	= TRUE;

		$this->data['tool_buttons']['form'] = 'Baru|primary';
		$this->data['tool_buttons']['status:dd|default'] = array(
			'data/status/semua'		=> 'Semua',
			'data/status/pending'	=> 'Pending',
			'data/status/approved'	=> 'Disetujui',
			'data/status/done'		=> 'Selesai',
			'data/status/deleted'	=> 'Dihapus' );

		$this->data['panel_title']	 = $this->baka_theme->set_title( 'Semua data ' . $this->app_data->get_name( $data_type ) );
		$this->data['panel_body']	 = $this->app_data->get_table( $data_type, $this->data['page_link'] );
		$this->data['counter']		 = $this->app_data->count_data( $data_type );

		$this->baka_theme->load('pages/panel_data', $this->data);
	}

	public function form( $data_type, $data_id = NULL )
	{
		$this->data['tool_buttons']['data']	= 'Kembali|default';
		$this->data['tool_buttons']['form'] = 'Baru|primary';

		if ( $data_id != '' )
		{
			$this->data['tool_buttons']['aksi|default']	= array(
				'cetak/'.$data_id => 'Cetak',
				'hapus/'.$data_id => 'Hapus' );
			$this->data['tool_buttons']['Ubah status:dd|default']	= array(
				'ubah-status/'.$data_id.'/pending/'		=> 'Pending',
				'ubah-status/'.$data_id.'/approved/'	=> 'Disetujui',
				'ubah-status/'.$data_id.'/done/'		=> 'Selesai' );
		}

		$this->data['panel_title']	= $this->baka_theme->set_title( 'Input data ' . $this->app_data->get_name( $data_type ) );
		$this->data['panel_body']	= $this->app_data->get_form( $data_type, $data_id, $this->data['page_link'].'form' );

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	public function delete( $data_type, $data_id )
	{
		if ( $delete = $this->app_data->delete_data( $data_id, $data_type ) )
		{
			$this->session->set_flashdata('message', $delete->message);
		}

		redirect( 'data/layanan/ijin/'.$data_type );
	}

	public function cetak( $data_type, $data_id )
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

	public function ubah_status( $new_status, $data_id, $redirect )
	{
		if ( $this->app_data->change_status( $data_id, $new_status ) )
		{
			$this->session->set_flashdata('success', array('Status dokumen dengan id #'.$data_id.' berhasil diganti menjadi '._x('status_'.$new_status)) );
		}
		else
		{
			$this->session->set_flashdata('error', array('Terjadi kesalahan penggantian status dokumen dengan id #'.$data_id) );
		}

		redirect( $redirect );
	}
}

/* End of file layanan.php */
/* Location: ./application/controllers/layanan.php */