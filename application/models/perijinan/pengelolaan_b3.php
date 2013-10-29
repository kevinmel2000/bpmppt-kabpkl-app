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
				'label'	=> 'Nomor Surat',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->surat_no : set_value($this->slug.'_surat_no')),
				),
			array(
				'name'	=> $this->slug.'_surat_tgl',
				'label'	=> 'Tanggal',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->surat_tgl : set_value($this->slug.'_surat_tgl')),
				),
			array(
				'name'	=> $this->slug.'_fieldset_data_pemohon',
				'label'	=> 'Data Pemohon',
				'type'	=> 'fieldset',
				),
			array(
				'name'	=> $this->slug.'_pemohon_nama',
				'label'	=> 'Nama lengkap',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_nama : set_value($this->slug.'_pemohon_nama')),
				),
			array(
				'name'	=> $this->slug.'_pemohon_jabatan',
				'label'	=> 'Jabatan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_jabatan : set_value($this->slug.'_pemohon_jabatan')),
				),
			array(
				'name'	=> $this->slug.'_pemohon_usaha',
				'label'	=> 'Perusahaan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_usaha : set_value($this->slug.'_pemohon_usaha')),
				),
			array(
				'name'	=> $this->slug.'_pemohon_alamat',
				'label'	=> 'Alamat',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $query->pemohon_alamat : set_value($this->slug.'_pemohon_alamat')),
				),
			array(
				'name'	=> $this->slug.'_fieldset_data_lokasi',
				'label'	=> 'Data Lokasi',
				'type'	=> 'fieldset',
				),
			array(
				'name'	=> $this->slug.'_lokasi_tujuan',
				'label'	=> 'Tujuan Permohonan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->lokasi_tujuan : set_value($this->slug.'_lokasi_tujuan')),
				),
			array(
				'name'	=> $this->slug.'_lokasi_alamat',
				'label'	=> 'Alamat Lokasi',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $query->lokasi_alamat : set_value($this->slug.'_lokasi_alamat')),
				),
			array(
				'name'	=> $this->slug.'_lokasi_nama',
				'label'	=> 'Luas Area (M<sup>2</sup>)',
				'type'	=> 'number',
				'std'	=> ($data_id != '' ? $query->lokasi_nama : set_value($this->slug.'_lokasi_nama')),
				),
			array(
				'name'	=> $this->slug.'_lokasi_area_hijau',
				'label'	=> 'Area terbuka hijau',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->lokasi_area_hijau : set_value($this->slug.'_lokasi_area_hijau')),
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