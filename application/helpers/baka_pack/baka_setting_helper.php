<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * get_app_config
 * @param	string
 * @return	string
 */
function get_app_config( $name )
{
	$CI =& get_instance();

	return $CI->baka_lib->config_item( $name );
}

/**
 * Get app setting
 * @param	string
 * @return	string
 */
function get_app_setting($name)
{
	$opt_object = _app_setting_object($name);

	return ( is_app_setting_exists($name) ? $opt_object->opt_value : '' );
}

/**
 * set_app_setting
 * @param	string
 * @return	void
 */
function set_app_setting($name, $value = '')
{
	$CI_db =& get_instance()->db;
	$opt_object = _app_setting_object($name);
	$opt_table	= get_app_config( 'system_opt_table' );

	if ( is_app_setting_exists($name) )
		return $CI_db->update( $opt_table, array('opt_key' => $name, 'opt_value' => $value), array('id' => $opt_object->id) );

	return $CI_db->insert( $opt_table, array('opt_key' => $name, 'opt_value' => $value));
}

/**
 * is_app_setting_exists
 * @param	string
 * @return	bool
 */
function is_app_setting_exists($name)
{
	$opt_object = _app_setting_object($name);
	
	if ( $opt_object !== FALSE AND strlen( $opt_object->opt_value ) > 0 )
		return TRUE;

	return FALSE;
}

/**
 * _app_setting_object
 * @param	string
 * @return	mixed
 */
function _app_setting_object($name)
{
	$CI_db =& get_instance()->db;
	$query = $CI_db->get_where( get_app_config( 'system_opt_table' ), array( 'opt_key' => $name ) );
	
	if ( $query->num_rows() === 1 )
		return $query->row();

	return FALSE;
}

/* End of file baka_common_helper.php */
/* Location: ./application/helpers/baka_common_helper.php */