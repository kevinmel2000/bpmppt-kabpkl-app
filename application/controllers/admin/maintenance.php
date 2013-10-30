<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends BAKA_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->baka_theme->add_navbar( 'admin_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
		$this->app_main->admin_navbar( 'admin_sidebar', 'side' );

		$this->baka_theme->set_title('Backup dan Restore Database');
	}

	public function index()
	{
		$this->backstore();
	}

	public function backstore()
	{
		$this->baka_theme->set_title('Backup dan Restore Database');

		$this->data['panel_backup_title'] = 'Backup Database';

		$form = $this->baka_form->add_form( current_url(), 'backup' )
								->add_fields(array(
									array(
										'name'	=> 'backup-all',
										'type'	=> 'checkbox',
										'label'	=> 'Backup semua tabel',
										'option'=> array('semua' => 'Semua'),
										),
									// array(
									// 	'name'	=> 'backup-tables',
									// 	'type'	=> 'multiselect',
									// 	'label'	=> 'Pilih tabel tertentu',
									// 	'option'=> $this->db->list_tables(),
									// 	),
								))
								->add_buttons(array(
									array(
										'name'	=> 'do-backup',
										'type'	=> 'submit',
										'value'	=> 'Backup sekarang',
										'class'	=> 'btn-primary pull-right'
										)
								));

		$this->load->library('baka_pack/baka_dbutil');

		if ($form->validate_submition())
		{
			$data = $form->submited_data();
			
			if ($data['backup-all'] == 'semua')
			{
				if ($this->baka_dbutil->backup())
					$this->baka_app->set_message( 'Berhasil', 'success' );
				else
					$this->baka_app->set_message( $this->baka_dbutil->errors, 'danger' );

				redirect( current_url(), 'refresh' );
			}
		}
		else
		{
			$this->data['panel_backup_body'] = $form->render();
		}

		$this->data['panel_restore_title'] = 'Restore Database';

		$form = $this->baka_form->add_form( current_url(), 'restore' )
								->add_fields(array(
									array(
										'name'	=> 'restore-from-file',
										'type'	=> 'upload',
										'label'	=> 'Restore dari berkas',
										'desc'	=> 'Pilih berkas yang akan digunakan untuk me-restore database, berkas yg diperbolehkan antara lain: <i>.zip</i> dan <i>.sql</i>'
										),
									))
								->add_buttons(array(
									array(
										'name'	=> 'do-restore',
										'type'	=> 'submit',
										'value'	=> 'Restore sekarang',
										'class'	=> 'btn-primary pull-right'
										)
									));

		if (!$form->validate_submition())
			$this->data['panel_restore_body'] = $form->render();
		else
			$this->data['panel_restore_body'] = $form->submited_data();

		$this->baka_theme->load('pages/panel_backstore', $this->data);
	}

	public function syslogs()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Aktifitas sistem');

		$this->baka_theme->add_navbar( 'log_sidebar', 'nav-tabs nav-stacked nav-tabs-left', 'panel' );

		foreach (directory_map( APPPATH.'storage/logs/') as $log)
		{
			if ( $log != 'index.html')
			{
				$log	= strtolower(str_replace(EXT, '', $log));
				$label	= 'Tanggal '.format_date(str_replace('log-', '', $log));

				$this->baka_theme->add_navmenu( 'log_sidebar', $log, 'link', current_url().'?read='.$log, $label, array(), 'panel' );
			}
		}

		if ( $read_log = $this->input->get('read') )
		{
			$this->load->helper('file');
			$this->data['panel_title'] .= 'Tanggal '.format_date(str_replace('log-', '', $read_log));
			$this->data['panel_body'] = read_file( APPPATH.'storage/logs/'.$read_log.EXT );
		}

		$this->baka_theme->load('pages/syslogs', $this->data);
	}
}

/* End of file maintenance.php */
/* Location: ./application/controllers/admin/maintenance.php */