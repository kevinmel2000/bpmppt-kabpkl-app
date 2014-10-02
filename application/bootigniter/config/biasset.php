<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package     BootIgniter Pack
 * @subpackage  Biasset
 * @category    Configurations
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     https://github.com/feryardiant/bootigniter/blob/master/license.md
 * @since       Version 0.1.5
 */

/*
|--------------------------------------------------------------------------
| Default Asset folder path.
| It's relative to root path (FCPATH)
|--------------------------------------------------------------------------
*/

$config['biasset_path_prefix'] = 'asset/';

/*
|--------------------------------------------------------------------------
| Registering Stylesheets and Javascripts
|--------------------------------------------------------------------------
*/

$config['biasset_register_styles'] = array(
    'lato-gfonts' => '//fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic',
    'bootigniter'  => 'css/style.min.css',
    );

$config['biasset_register_scripts'] = array(
    'jquery'       => 'js/lib/jquery.min.js',
    'bootstrap'    => 'js/lib/bootstrap.min.js',
    'bootigniter'  => 'js/script.js',
    );

/*
|--------------------------------------------------------------------------
| Asset autoloader
|--------------------------------------------------------------------------
*/

$config['biasset_autoload_style'] = array(
    'lato-gfonts' => '//fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic',
    // 'bootstrap'    => 'bower/bootstrap/dist/css/bootstrap.min.css',
    'bootigniter'  => 'css/style.min.css',
    );

$config['biasset_autoload_script'] = array(
    'jquery'       => 'js/lib/jquery.min.js',
    'bootstrap'    => 'js/lib/bootstrap.min.js',
    'bootigniter'  => 'js/script.js',
    );


/* End of file biasset.php */
/* Location: ./bootigniter/config/biasset.php */
