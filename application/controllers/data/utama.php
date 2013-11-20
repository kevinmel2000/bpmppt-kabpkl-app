<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Utama extends BAKA_Controller
{
	private $modules_arr = array();

	public function __construct()
	{
		parent::__construct();

		$this->baka_theme->set_title('Dashboard');

		$this->baka_theme->add_navbar( 'data_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
		$this->app_main->data_navbar( 'data_sidebar', 'side' );

		$this->modules_arr = $this->app_data->get_modules_assoc();

		$this->data['page_link'] = 'data/';
	}

	public function index()
	{
		redirect('dashboard');
	}

	public function stat()
	{
		$this->data['panel_title']	= $this->baka_theme->set_title('Semua data perijinan');
		$this->data['data_type']	= $this->modules_arr;

		if ( count($this->modules_arr) > 0 )
		{
			$this->data['load_toolbar'] = TRUE;
			// $this->data['search_form']	= TRUE;
			$this->data['page_link'] .= 'layanan/index/';

			foreach ($this->modules_arr as $alias => $name)
			{
				$this->data['tool_buttons']['Baru:dd|primary'][$alias.'/form'] = $name;
			}

			$this->data['tool_buttons']['utama/laporan'] = 'Laporan|default';
			$this->data['panel_body']	= $this->app_data->get_tables( $this->data['page_link'] );
			$this->data['counter']		= $this->app_data->count_data();

			$this->baka_theme->load('pages/panel_alldata', $this->data);
		}
		else
		{
			$this->_notice( 'no-data-accessible' );
		}
	}

	public function laporan()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Laporan data');

		$fields[]	= array(
			'name'	=> 'data_type',
			'label'	=> 'Pilih data perijinan',
			'type'	=> 'dropdown',
			'option'=> add_placeholder($this->modules_arr),
			'validation'=> 'required',
			'desc'	=> 'Pilih jenis dokumen yang ingi dicetak. Saat ini terdapat '.count($this->modules_arr).' jenis dokumen untuk anda.' );

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

			$this->session->set_flashdata('error', 'Tidak dapat menemukan data yang anda cari.');

			redirect( current_url() );
		}
			
		$this->data['panel_body'] = $form->render();

		$this->baka_theme->load('pages/panel_form', $this->data);
	}
}

/* End of file utama.php */
/* Location: ./application/controllers/utama.php */