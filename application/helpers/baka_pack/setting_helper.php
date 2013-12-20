<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CI default get spesific config item with 'baka_' prefix
 *
 * @param   string  $name  Config name
 *
 * @return  mixed
 */
function get_conf( $name )
{
    return config_item( 'baka_'.$name );
}

/* End of file setting_helper.php */
/* Location: ./application/helpers/setting_helper.php */