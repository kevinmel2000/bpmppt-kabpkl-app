<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function get_counter_text( $count = NULL )
{
	if ( (int) $count > 0 )
	{
		$limit = get_app_setting('app_data_show_limit');

		if ( $count >= $limit )
			return 'Menampilkan '.$limit.' data dari total '.$count.' data keseluruhan';
		else
			return 'Menampilkan '.$count.' dari keseluruhan data';
	}
	else
		return 'Belum ada data';
}


/* End of file app_data_helper.php */
/* Location: ./application/helpers/app/app_data_helper.php */