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

if (!defined('PROJECT_DIR'))
{
    $hook['pre_controller'] = array(
        'class'    => 'Errror',
        'function' => 'reload',
        'filename' => 'Errror.php',
        'filepath' => 'hooks'
        );
}
else
{
    $hook['display_override'] = array(
        'class'    => 'Display',
        'function' => 'get_output',
        'filename' => 'Display.php',
        'filepath' => 'hooks'
        );
}

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */