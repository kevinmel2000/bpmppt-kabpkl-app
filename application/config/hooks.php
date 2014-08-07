<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$conf = array(
    'class'    => 'Bakahooks',
    'filename' => 'Bakahooks.php',
    'filepath' => 'bakaigniter/libraries',
    'function' => '',
    );

if (defined('PROJECT_DIR'))
{
    $conf['function'] = 'get_output_hooks';

    $hook['display_override'] = $conf;
}
else
{
    $conf['function'] = 'error_handler_hooks';

    if ( ENVIRONMENT == 'development' )
    {
	    $hook['pre_controller'] = $conf;
    }
}

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */
