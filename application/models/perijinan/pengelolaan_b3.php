<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengelolaan_b3 extends CI_Model
{
	public $kode = 'B3';
	public $slug = 'izin_pengelolaan_b3';
	public $nama = 'Izin Penyimpanan Sementara dan Pengumpulan Limbah Bahan Berbahaya dan Beracun';

	public function __construct()
	{
		parent::__construct();

		log_message('debug', "Pengelolaan_b3_model Class Initialized");
	}

	public function form( $data_id = '' )
	{
		$fields = array(
			array(
				'name'	=> $this->slug.'_surat_no',
				'label'	=> 'Nomor &amp; Tanggal Surat',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '6',
						'name'	=> 'nomor',
						'label'	=> 'Nomor',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $query->surat_nomor : set_value($this->slug.'_surat_nomor')),
						'validation'=> 'required' ),
					array(
						'col'	=> '6',
						'name'	=> 'tanggal',
						'label'	=> 'Tanggal',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $query->surat_tanggal : set_value($this->slug.'_surat_tanggal')),
						'validation'=> 'required' ),
					)
				),
			array(
				'name'	=> $this->slug.'_fieldset_data_pemohon',
				'label'	=> 'Data Pemohon',
				'type'	=> 'fieldset' ),
			array(
				'name'	=> $this->slug.'_pemohon_nama',
				'label'	=> 'Nama lengkap',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_nama : set_value($this->slug.'_pemohon_nama')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_alamat',
				'label'	=> 'Alamat',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $query->pemohon_alamat : set_value($this->slug.'_pemohon_alamat')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_jabatan',
				'label'	=> 'Jabatan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_jabatan : set_value($this->slug.'_pemohon_jabatan')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_fieldset_data_usaha',
				'label'	=> 'Data Perusahaan',
				'type'	=> 'fieldset' ),
			array(
				'name'	=> $this->slug.'_usaha_nama',
				'label'	=> 'Nama Perusahaan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->usaha_nama : set_value($this->slug.'_usaha_nama')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_usaha_bidang',
				'label'	=> 'Bidang usaha',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->usaha_bidang : set_value($this->slug.'_usaha_bidang')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_usaha_alamat',
				'label'	=> 'Alamat Kantor',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $query->usaha_alamat : set_value($this->slug.'_usaha_alamat')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_usaha_lokasi',
				'label'	=> 'Lokasi Usaha',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $query->usaha_lokasi : set_value($this->slug.'_usaha_lokasi')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_usaha_kontak',
				'label'	=> 'Nomor Telp. &amp; Fax.',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '6',
						'name'	=> 'telp',
						'label'	=> 'No. Telpon',
						'type'	=> 'tel',
						'std'	=> ($data_id != '' ? $query->usaha_kontak_telp : set_value($this->slug.'_usaha_kontak_telp')) ),
					array(
						'col'	=> '6',
						'name'	=> 'fax',
						'label'	=> 'No. Fax',
						'type'	=> 'tel',
						'std'	=> ($data_id != '' ? $query->usaha_kontak_fax : set_value($this->slug.'_usaha_kontak_fax')) ),
					)
				),
			array(
				'name'	=> $this->slug.'_usaha_tps',
				'label'	=> 'Tempat Pembuangan Sementara',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '3',
						'name'	=> 'fungsi',
						'label'	=> 'Keterangan fungsi',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $query->_usaha_tps_fungsi : set_value($this->slug.'__usaha_tps_fungsi')),
						'validation'=> 'required'),
					array(
						'col'	=> '3',
						'name'	=> 'ukuran',
						'label'	=> 'Ukuran',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $query->_usaha_tps_ukuran : set_value($this->slug.'__usaha_tps_ukuran')),
						'validation'=> 'required'),
					array(
						'col'	=> '3',
						'name'	=> 'koor_s',
						'label'	=> 'Koor. S',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $query->_usaha_tps_koor_s : set_value($this->slug.'__usaha_tps_koor_s')),
						'validation'=> 'required'),
					array(
						'col'	=> '3',
						'name'	=> 'koor_e',
						'label'	=> 'Koor. E',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $query->_usaha_tps_koor_e : set_value($this->slug.'__usaha_tps_koor_e')),
						'validation'=> 'required'),
					)
				),
			);

		return $fields;
	}

	public function data()
	{
		$post_data['daftar_no'] = $this->input->post('daftar_no');
		$post_data['daftar_tgl'] = $this->input->post('daftar_tgl');
		$post_data['pemohon_nama'] = $this->input->post('pemohon_nama');
		$post_data['pemohon_alamat'] = $this->input->post('pemohon_alamat');
		$post_data['pemohon_rt'] = $this->input->post('pemohon_rt');
		$post_data['pemohon_rw'] = $this->input->post('pemohon_rw');
		$post_data['pemohon_propinsi'] = $this->input->post('pemohon_propinsi');
		$post_data['pemohon_kota'] = $this->input->post('pemohon_kota');
		$post_data['pemohon_kecamatan'] = $this->input->post('pemohon_kecamatan');
		$post_data['pemohon_kelurahan'] = $this->input->post('pemohon_kelurahan');
		$post_data['perusahaan_nama'] = $this->input->post('perusahaan_nama');
		$post_data['perusahaan_bidang'] = $this->input->post('perusahaan_bidang');
		$post_data['perusahaan_kantor_alamat'] = $this->input->post('perusahaan_kantor_alamat');
		$post_data['perusahaan_kantor_rt'] = $this->input->post('perusahaan_kantor_rt');
		$post_data['perusahaan_kantor_rw'] = $this->input->post('perusahaan_kantor_rw');
		$post_data['perusahaan_kantor_propinsi'] = $this->input->post('perusahaan_kantor_propinsi');
		$post_data['perusahaan_kantor_kota'] = $this->input->post('perusahaan_kantor_kota');
		$post_data['perusahaan_kantor_kecamatan'] = $this->input->post('perusahaan_kantor_kecamatan');
		$post_data['perusahaan_kantor_kelurahan'] = $this->input->post('perusahaan_kantor_kelurahan');
		$post_data['perusahaan_kegiatan_alamat'] = $this->input->post('perusahaan_kegiatan_alamat');
		$post_data['perusahaan_kegiatan_rt'] = $this->input->post('perusahaan_kegiatan_rt');
		$post_data['perusahaan_kegiatan_rw'] = $this->input->post('perusahaan_kegiatan_rw');
		$post_data['perusahaan_kegiatan_propinsi'] = $this->input->post('perusahaan_kegiatan_propinsi');
		$post_data['perusahaan_kegiatan_kota'] = $this->input->post('perusahaan_kegiatan_kota');
		$post_data['perusahaan_kegiatan_kecamatan'] = $this->input->post('perusahaan_kegiatan_kecamatan');
		$post_data['perusahaan_kegiatan_kelurahan'] = $this->input->post('perusahaan_kegiatan_kelurahan');
		$post_data['pemohon_telp'] = $this->input->post('pemohon_telp');
		$post_data['pemohon_fax'] = $this->input->post('pemohon_fax');

		$perusahaan_tps_tujuan		= $this->input->post('perusahaan_tps_tujuan');
		$perusahaan_tps_ukuran		= $this->input->post('perusahaan_tps_ukuran');
		$perusahaan_tps_koordinat	= $this->input->post('perusahaan_tps_koordinat');

		for ($i=0; $i<count($perusahaan_tps_tujuan); $i++)
		{
			$perusahaan_tps[$i]['perusahaan_tps_tujuan']	= $perusahaan_tps_tujuan[$i];
			$perusahaan_tps[$i]['perusahaan_tps_ukuran']	= $perusahaan_tps_ukuran[$i];
			$perusahaan_tps[$i]['perusahaan_tps_koordinat']	= $perusahaan_tps_koordinat[$i];
		}

		$post_data['perusahaan_tps'] = serialize( $perusahaan_tps );

		// surat_no:
		// surat_tgl:28-10-2013
		// daftar_no:
		// daftar_tgl:28-10-2013
		// pemohon_nama:
		// pemohon_alamat:
		// perusahaan_nama:
		// perusahaan_bidang:
		// perusahaan_kantor_alamat:
		// perusahaan_kegiatan_alamat:
		// pemohon_telp:
		// pemohon_fax:
		// total_syarat:7
	}
}

/* End of file Izin_kelola_b3.php */
/* Location: ./application/models/app/Izin_kelola_b3.php */