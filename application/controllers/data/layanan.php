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

			case 'laporan':
				$this->cetak( $data_type );
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
		$this->data['tool_buttons']['cetak'] = 'Laporan|info';
		$this->data['tool_buttons']['status:dd|default'] = array(
			'data/status/semua'		=> 'Semua',
			'data/status/pending'	=> 'Pending',
			'data/status/approved'	=> 'Disetujui',
			'data/status/done'		=> 'Selesai',
			'data/status/deleted'	=> 'Dihapus' );

		$this->data['panel_title']	 = $this->baka_theme->set_title( 'Semua data ' . $this->app_data->get_label( $data_type ) );
		
		$this->data['panel_body']	 = $this->app_data->get_table( $data_type, $this->data['page_link'] );
		// $this->data['counter']		 = $this->app_data->count_data( $data_type );

		$this->baka_theme->load('pages/panel_data', $this->data);
	}

	public function form( $data_type, $data_id = NULL )
	{
		$this->data['tool_buttons']['data']	= 'Kembali|default';

		if ( ! is_null($data_id) )
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

		$this->data['panel_title']	= $this->baka_theme->set_title( 'Input data ' . $this->app_data->get_label( $data_type ) );

		$modul_slug	= $this->app_data->get_modul($data_type)['slug'];
		$data_obj	= ( ! is_null( $data_id ) ? $this->app_data->get_fulldata_by_id( $data_id ) : FALSE );

		if ( $data_obj )
		{
			$status	= $data_obj->status;
			$date	= ( $status != 'pending' ? ' pada: '.format_datetime( $data_obj->{$status.'_on'} ) : '' );

			$fields[]	= array(
				'name'	=> $modul_slug.'_pemohon_jabatan',
				'label'	=> 'Status Pengajuan',
				'type'	=> 'static',
				'std'	=> '<span class="label label-'.$status.'">'._x('status_'.$status).'</span>'.$date );
		}

		$fields[]	= array(
			'name'	=> $modul_slug.'_surat',
			'label'	=> 'Nomor &amp; Tanggal Permohonan',
			'type'	=> 'subfield',
			'attr'	=> ( $data_obj ? 'disabled' : ''),
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'nomor',
					'label'	=> 'Nomor',
					'type'	=> 'text',
					'std'	=> ( $data_obj ? $data_obj->surat_nomor : ''),
					'validation'=> ( !$data_obj ? 'required' : '' ) ),
				array(
					'col'	=> '6',
					'name'	=> 'tanggal',
					'label'	=> 'Tanggal',
					'type'	=> 'datepicker',
					'std'	=> ( $data_obj ? format_date( $data_obj->surat_tanggal ) : ''),
					'validation'=> ( !$data_obj ? 'required' : '' ),
					'callback'=> 'string_to_date' ),
				)
			);

		$form = $this->baka_form->add_form( current_url(), $modul_slug )
								->add_fields( array_merge( $fields, $this->$data_type->form( $data_obj )) );

		if ( $data_id != '' )
			$form->disable_buttons();

		if ( $form->validate_submition() )
		{
			$form_data	= $form->submited_data();

			if ( $data = $this->create_data( $modul_name, $form_data ) )
			{
				$this->session->set_flashdata( 'success', $this->_messages['success'] );
			}
			else
			{
				$this->session->set_flashdata( 'error', $this->_messages['error'] );
			}

			return redirect( $link.'/'.$data );
		}
		else
		{
			$this->session->set_flashdata( 'error', $form->validation_errors() );
		}

		$this->data['panel_body']	= $form->render();
		// $this->data['panel_body']	= $this->app_data->get_form( $data_type, $data_id, $this->data['page_link'].'form' );

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	public function cetak( $data_type, $data_id = NULL )
	{
		if ( is_null($data_id) )
		{
			$this->data['tool_buttons']['data']	= 'Kembali|default';

			$this->data['panel_title'] = $this->baka_theme->set_title('Laporan data '.$this->app_data->get_label( $data_type ));

			$fields[]	= array(
				'name'	=> 'data_status',
				'label'	=> 'Status Pengajuan',
				'type'	=> 'dropdown',
				'option'=> array(
					'all'		=> 'Semua',
					'pending'	=> 'Tertunda',
					'approved'	=> 'Disetujui',
					'done'		=> 'Selesai' ),
				'desc'	=> 'tentukan status dokumennya, pilih <em>Semua</em> untuk mencetak semua dokumen dengan jenis dokumen diatas, atau anda dapat sesuaikan dengan kebutuhan.' );

			$fields[]	= array(
				'name'	=> 'data_date',
				'label'	=> 'BUlan &amp; Tahun',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'name' => 'data_month',
						'col'	=> 6,
						'label'	=> 'Bulan',
						'type'	=> 'dropdown',
						'option'=> add_placeholder( get_month_assoc(), 'Pilih Bulan') ),
					array(
						'name' => 'data_year',
						'col'	=> 6,
						'label'	=> 'Tahun',
						'type'	=> 'dropdown',
						'option'=> add_placeholder( get_year_assoc(), 'Pilih Tahun') )
					),
				'desc'	=> 'Tentukan tanggal dan bulan dokumen.' );

			$fields[]	= array(
				'name'	=> 'data_sort',
				'label'	=> 'Urutan',
				'type'	=> 'radiobox',
				'option'=> array(
					'asc'	=> 'Ascending',
					'des'	=> 'Descending'),
				'std'	=> 'asc',
				'desc'	=> 'Tentukan jenis pengurutan output dokumen.' );

			$fields[]	= array(
				'name'	=> 'data_output',
				'label'	=> 'Pilihan Output',
				'type'	=> 'radiobox',
				'option'=> array(
					'print'	=> 'Cetak Langsung',
					'excel'	=> 'Export ke file MS Excel'),
				'std'	=> 'print' );

			$buttons[]= array(
				'name'	=> 'do-print',
				'type'	=> 'submit',
				'label'	=> 'Cetak sekarang',
				'class'	=> 'btn-primary pull-right' );

			$form = $this->baka_form->add_form( current_url(), 'internal-skpd' )
									->add_fields( $fields )
									->add_buttons( $buttons );

			if ( $form->validate_submition() )
			{
				$submited_data = $form->submited_data();

				// $return = $this->app_data-
			}
				
			$this->data['panel_body'] = $form->render();

			$this->baka_theme->load('pages/panel_form', $this->data);
		}
		else
		{
			$data['skpd_name']		= get_app_setting('skpd_name');
			$data['skpd_address']	= get_app_setting('skpd_address');
			$data['skpd_city']		= get_app_setting('skpd_city');
			$data['skpd_prov']		= get_app_setting('skpd_prov');
			$data['skpd_telp']		= get_app_setting('skpd_telp');
			$data['skpd_fax']		= get_app_setting('skpd_fax');
			$data['skpd_pos']		= get_app_setting('skpd_pos');
			$data['skpd_web']		= get_app_setting('skpd_web');
			$data['skpd_email']		= get_app_setting('skpd_email');
			$data['skpd_logo']		= get_app_setting('skpd_logo');
			$data['skpd_lead_name']	= get_app_setting('skpd_lead_name');
			$data['skpd_lead_nip']	= get_app_setting('skpd_lead_nip');

			$data = array_merge( (array) $data, (array) $this->app_data->get_fulldata_by_id( $data_id ) );

			// $this->data['panel_body'] = $data;

			// $this->baka_theme->load('pages/panel_form', $this->data);

			$this->baka_theme->load('prints/'.$data_type, $data, 'print');
		}
	}

	public function delete( $data_type, $data_id )
	{
		if ( $delete = $this->app_data->delete_data( $data_id, $data_type ) )
		{
			$this->session->set_flashdata('message', $delete->message);
		}

		redirect( 'data/layanan/ijin/'.$data_type );
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