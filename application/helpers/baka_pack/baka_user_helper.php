<?php

function get_pegawai( $id )
{
	$CI_pegawai =& get_instance()->pegawai;
	
	return $CI_pegawai->get_nama_pengguna( $id );
}