<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usaha_pertambangan extends App_main
{
	public $kode = 'IUP';
	public $slug = 'izin_usaha_pertambangan';
	public $nama = 'Izin Usaha Pertambangan';

	public function __construct()
	{
		log_message('debug', "#BAKA_modul: Usaha_pertambangan_model Class Initialized");
	}

	public function form( $data_obj = NULL )
	{
		$fields[]	= array(
			'name'	=> $this->slug.'_rekomendasi',
			'label'	=> 'Surat Rekomendasi',
			'type'	=> 'subfield',
			'attr'	=> (! is_null($data_obj) ? 'disabled' : '' ),
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'nomor',
					'label'	=> 'Nomor',
					'type'	=> 'text',
					'std'	=> (! is_null($data_obj) ? $data_obj->rekomendasi_nomor : ''),
					'validation'=> 'required' ),
				array(
					'col'	=> '6',
					'name'	=> 'tanggal',
					'label'	=> 'Tanggal',
					'type'	=> 'datepicker',
					'std'	=> (! is_null($data_obj) ? $data_obj->rekomendasi_tanggal : ''),
					'validation'=> 'required',
					'callback'=> 'string_to_date' ),
				));

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_data_pemohon',
			'label'	=> 'Data Pemohon',
			'attr'	=> (! is_null($data_obj) ? array( 'disabled' => TRUE ) : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_nama',
			'label'	=> 'Nama lengkap',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->pemohon_nama : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_pemohon_alamat',
			'label'	=> 'Alamat',
			'type'	=> 'textarea',
			'std'	=> (! is_null($data_obj) ? $data_obj->pemohon_alamat : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_tambang',
			'label'	=> 'Ketentuan Perijinan',
			'attr'	=> (! is_null($data_obj) ? array( 'disabled' => TRUE ) : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_tambang_waktu',
			'label'	=> 'Jangka waktu',
			'type'	=> 'subfield',
			'fields'=> array(
				array(
					'col'	=> '6',
					'name'	=> 'nomor',
					'label'	=> 'Mulai',
					'type'	=> 'text',
					'std'	=> (! is_null($data_obj) ? $data_obj->tambang_waktu_mulai : ''),
					'validation'=> 'required' ),
				array(
					'col'	=> '6',
					'name'	=> 'tanggal',
					'label'	=> 'Selesai',
					'type'	=> 'datepicker',
					'std'	=> (! is_null($data_obj) ? $data_obj->tambang_waktu_selesai : ''),
					'validation'=> 'required',
					'callback'=> 'string_to_date' ),
				));

		$fields[]	= array(
			'name'	=> $this->slug.'_tambang_jns_galian',
			'label'	=> 'Jenis Galian',
			'type'	=> 'text',
			'std'	=> (! is_null($data_obj) ? $data_obj->tambang_jns_galian : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_tambang_luas',
			'label'	=> 'Luas Area (M<sup>2</sup>)',
			'type'	=> 'number',
			'std'	=> (! is_null($data_obj) ? $data_obj->tambang_luas : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_tambang_alamat',
			'label'	=> 'Alamat Lokasi',
			'type'	=> 'textarea',
			'std'	=> (! is_null($data_obj) ? $data_obj->tambang_alamat : ''),
			'validation'=> 'required' );

		$fields[]	= array(
			'name'	=> $this->slug.'_fieldset_tambang',
			'label'	=> 'Ketentuan Perijinan',
			'attr'	=> (! is_null($data_obj) ? 'disabled' : '' ),
			'type'	=> 'fieldset' );

		$fields[]	= array(
			'name'	=> $this->slug.'_tambang_koor',
			'label'	=> 'Kode Koordinat',
			'type'	=> 'custom',
			'value'	=> $this->custom_field(),
			'validation'=> 'required' );

		return $fields;
	}

	private function custom_field( $data = NULL)
	{
		// if ( ! $this->load->is_loaded('table'))
		$this->load->library('table');

		$head[] = array(
			'data'	=> 'No. Titik',
			'class'	=> 'head-id',
			'width'	=> '10%' );

		$head[] = array(
			'data'	=> 'Garis Bujur',
			'class'	=> 'head-value',
			'width'	=> '30%',
			'colspan'=> 3 );

		$head[] = array(
			'data'	=> 'Garis Lintang',
			'class'	=> 'head-value',
			'width'	=> '30%',
			'colspan'=> 4 );

		$head[] = array(
			'data'	=> form_button( array(
				'name'	=> 'no',
				'type'	=> 'button',
				'id'	=> 'no',
				'class'	=> 'btn btn-primary bs-tooltip btn-block btn-sm',
				'value'	=> 'add',
				'title'	=> 'Tambahkan baris',
				'content'=> 'Add' ) ),
			'class'	=> 'head-action',
			'width'	=> '10%' );

		$this->table->set_heading( $head );

		if ( ! is_null( $data ) )
		{
			foreach ( $query->result() as $row )
			{
				$cols[] = array(
					'data'	=> anchor($form_link.'/'.$row->id, '#'.$row->id),
					'class'	=> 'data-id',
					'width'	=> '10%' );

				$cols[] = array(
					'data'	=> '<strong>'.anchor($form_link.'/'.$row->id, 'No. '.$row->no_agenda).'</strong><br><small class="text-muted">'.format_datetime($row->created_on).'</small>',
					'class'	=> 'data-value',
					'width'	=> '30%' );

				$cols[] = array(
					'data'	=> '<strong>'.$row->petitioner.'</strong><br><small class="text-muted">'.format_datetime($row->adopted_on).'</small>',
					'class'	=> 'data-value',
					'width'	=> '30%' );

				$cols[] = array(
					'data'	=> $row->status,
					'class'	=> '',
					'width'	=> '10%' );
			}
		}
		else
		{
			$cols[] = array(
				'data'	=> form_input( array(
					'name'	=> 'no',
					'type'	=> 'text',
					'id'	=> 'no',
					'class'	=> 'form-control bs-tooltip input-sm',
					'title'	=> 'Masukan nomor titik',
					'placeholder'=> 'No' ), '', ''),
				'class'	=> 'data-id',
				'width'	=> '10%' );

			$cols[] = array(
				'data'	=> form_input( array(
					'name'	=> 'no',
					'type'	=> 'text',
					'id'	=> 'no',
					'class'	=> 'form-control bs-tooltip input-sm',
					'title'	=> 'Masukan nilai &deg; Garis Bujur',
					'placeholder'=> '&deg;' ), '', ''),
				'class'	=> 'data-id',
				'width'	=> '10%' );

			$cols[] = array(
				'data'	=> form_input( array(
					'name'	=> 'no',
					'type'	=> 'text',
					'id'	=> 'no',
					'class'	=> 'form-control bs-tooltip input-sm',
					'title'	=> 'Masukan nilai &apos; Garis Bujur',
					'placeholder'=> '&apos;' ), '', ''),
				'class'	=> 'data-id',
				'width'	=> '10%' );

			$cols[] = array(
				'data'	=> form_input( array(
					'name'	=> 'no',
					'type'	=> 'text',
					'id'	=> 'no',
					'class'	=> 'form-control bs-tooltip input-sm',
					'title'	=> 'Masukan nilai &quot; Garis Bujur',
					'placeholder'=> '&quot;' ), '', ''),
				'class'	=> 'data-id',
				'width'	=> '10%' );

			$cols[] = array(
				'data'	=> form_input( array(
					'name'	=> 'no',
					'type'	=> 'text',
					'id'	=> 'no',
					'class'	=> 'form-control bs-tooltip input-sm',
					'title'	=> 'Masukan nilai &deg; Garis Lintang',
					'placeholder'=> '&deg;' ), '', ''),
				'class'	=> 'data-id',
				'width'	=> '10%' );

			$cols[] = array(
				'data'	=> form_input( array(
					'name'	=> 'no',
					'type'	=> 'text',
					'id'	=> 'no',
					'class'	=> 'form-control bs-tooltip input-sm',
					'title'	=> 'Masukan nilai &apos; Garis Lintang',
					'placeholder'=> '&apos;' ), '', ''),
				'class'	=> 'data-id',
				'width'	=> '10%' );

			$cols[] = array(
				'data'	=> form_input( array(
					'name'	=> 'no',
					'type'	=> 'text',
					'id'	=> 'no',
					'class'	=> 'form-control bs-tooltip input-sm',
					'title'	=> 'Masukan nilai &quot; Garis Lintang',
					'placeholder'=> '&quot;' ), '', ''),
				'class'	=> 'data-id',
				'width'	=> '10%' );

			$cols[] = array(
				'data'	=> form_input( array(
					'name'	=> 'no',
					'type'	=> 'text',
					'id'	=> 'no',
					'class'	=> 'form-control bs-tooltip input-sm',
					'title'	=> 'ini tooltip',
					'placeholder'=> 'LS/U' ), '', ''),
				'class'	=> 'data-id',
				'width'	=> '10%' );

			$cols[] = array(
				'data'	=> form_button( array(
					'name'	=> 'no',
					'type'	=> 'button',
					'id'	=> 'no',
					'class'	=> 'btn btn-danger bs-tooltip btn-block btn-sm',
					'value'	=> 'remove',
					'title'	=> 'Hapus baris ini',
					'content'=> '&times;' ) ),
				'class'	=> '',
				'width'	=> '10%' );
		}

		$this->table->add_row( $cols );

		$this->table->set_template( array('table_open' => '<table id="table-koordinat" class="table table-striped table-hover table-condensed">' ) );

		return $this->table->generate();
	}

	public function data()
	{
		$post_data['surat_rekomendasi_nomor']		= $this->input->post('surat_rekomendasi_nomor');
		$post_data['surat_rekomendasi_tanggal']		= $this->input->post('surat_rekomendasi_tanggal');
		$post_data['pemohon_nama']					= $this->input->post('pemohon_nama');
		$post_data['pemohon_alamat']				= $this->input->post('pemohon_alamat');
		$post_data['pemohon_propinsi']				= $this->input->post('pemohon_propinsi');
		$post_data['pemohon_kota']					= $this->input->post('pemohon_kota');
		$post_data['pemohon_kecamatan']				= $this->input->post('pemohon_kecamatan');
		$post_data['pemohon_kelurahan']				= $this->input->post('pemohon_kelurahan');
		$post_data['pemohon_rt']					= $this->input->post('pemohon_rt');
		$post_data['pemohon_rw']					= $this->input->post('pemohon_rw');
		$post_data['pemohon_an']					= $this->input->post('pemohon_an');
		$post_data['tambang_jangka_waktu_mulai']	= string_to_date( $this->input->post('tambang_jangka_waktu_mulai') );
		$post_data['tambang_jangka_waktu_selesai']	= string_to_date( $this->input->post('tambang_jangka_waktu_selesai') );
		$post_data['tambang_jenis_bahan']			= $this->input->post('tambang_jenis_bahan');
		$post_data['tambang_luas']					= $this->input->post('tambang_luas');
		$post_data['tambang_alamat']				= $this->input->post('tambang_alamat');
		$post_data['tambang_propinsi']				= $this->input->post('tambang_propinsi');
		$post_data['tambang_kota']					= $this->input->post('tambang_kota');
		$post_data['tambang_kecamatan']				= $this->input->post('tambang_kecamatan');
		$post_data['tambang_kelurahan']				= $this->input->post('tambang_kelurahan');
		$post_data['tambang_rt']					= $this->input->post('tambang_rt');
		$post_data['tambang_rw']					= $this->input->post('tambang_rw');

		// surat_no:
		// surat_tgl:28-10-2013
		// surat_rekomendasi_nomor:
		// surat_rekomendasi_tanggal:28-10-2013
		// pemohon_nama:
		// pemohon_alamat:
		// pemohon_alamat:
		// pemohon_an:
		// tambang_jangka_waktu_mulai:28-10-2013
		// tambang_jangka_waktu_selesai:28-10-2013
		// tambang_jenis_bahan:
		// tambang_luas:
		// tambang_kode:
		// tambang_alamat:
		// tambang_alamat:
		// tambang_koordinat[]:
		// tambang_koordinat[]:
		// tambang_koordinat[]:
		// tambang_koordinat[]:
		// tambang_koordinat[]:
		// tambang_koordinat[]:
		// tambang_koordinat[]:
		// tambang_koordinat[]:
	}
}

/* End of file Izin_usaha_pertambangan.php */
/* Location: ./application/models/app/Izin_usaha_pertambangan.php */