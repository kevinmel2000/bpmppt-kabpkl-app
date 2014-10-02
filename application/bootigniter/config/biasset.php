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
    'gfonts' => array(
        'src' => '//fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic',
        ),
    'fineuploader' => array(
        'src' => 'js/lib/fineuploader.min.css',
        'ver' => '5.0.3',
        ),
    'select2' => array(
        'src' => 'js/lib/select2.css',
        'ver' => '3.4.5',
        ),
    'bootigniter' => array(
        'src' => 'css/style.min.css',
        'ver' => Bootigniter::VERSION,
        'dep' => array('gfonts'),
        ),
    );

$vendor_path = 'js/lib/';
$jqueryui_path = $vendor_path.'jquery-ui/';
$jqueryui_version = '1.10.4';

$config['biasset_register_scripts'] = array(
    'jquery' => array(
        'src' => $vendor_path.'jquery.min.js',
        'ver' => '2.0.3',
        ),
    'jq-autosize' => array(
        'src' => $vendor_path.'jquery.autosize.min.js',
        'ver' => '1.18.0',
        'dep' => array('jquery'),
        ),
    'jq-datatables' => array(
        'src' => $vendor_path.'jquery.dataTables.min.js',
        'ver' => '1.10.0',
        'dep' => array('jquery'),
        ),
    'bs-datatables' => array(
        'src' => $vendor_path.'bootstrap.datatables.js',
        'ver' => '1.10.0',
        'dep' => array('bootstrap', 'jq-datatables'),
        ),
    'jq-fineuploader' => array(
        'src' => $vendor_path.'jquery.fineuploader.min.js',
        'ver' => '5.0.3',
        'dep' => array('jquery'),
        ),
    'jq-mousewheel' => array(
        'src' => $vendor_path.'jquery.mousewheel.min.js',
        'ver' => '3.1.12',
        'dep' => array('jquery', 'jqueryui-mouse'),
        ),
    'jqueryui-core' => array(
        'src' => $jqueryui_path.'core.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jquery'),
        ),
    'jqueryui-mouse' => array(
        'src' => $jqueryui_path.'mouse.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-widget' => array(
        'src' => $jqueryui_path.'widget.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-button' => array(
        'src' => $jqueryui_path.'button.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-menu' => array(
        'src' => $jqueryui_path.'menu.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-position' => array(
        'src' => $jqueryui_path.'position.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-mouse'),
        ),
    'jqueryui-draggable' => array(
        'src' => $jqueryui_path.'draggable.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-mouse'),
        ),
    'jqueryui-droppable' => array(
        'src' => $jqueryui_path.'droppable.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-resizable' => array(
        'src' => $jqueryui_path.'resizable.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-selectable' => array(
        'src' => $jqueryui_path.'selectable.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-accordion' => array(
        'src' => $jqueryui_path.'accordion.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-effect'),
        ),
    'jqueryui-autocomplete' => array(
        'src' => $jqueryui_path.'autocomplete.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-menu', 'jqueryui-position'),
        ),
    'jqueryui-datepicker' => array(
        'src' => $jqueryui_path.'datepicker.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-datepicker-id' => array(
        'src' => $jqueryui_path.'datepicker-id.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-datepicker'),
        ),
    'jqueryui-dialog' => array(
        'src' => $jqueryui_path.'dialog.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-button', 'jqueryui-position', 'jqueryui-draggable', 'jqueryui-resizable'),
        ),
    'jqueryui-progressbar' => array(
        'src' => $jqueryui_path.'progressbar.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-slider' => array(
        'src' => $jqueryui_path.'slider.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jq-mousewheel'),
        ),
    'jqueryui-sortable' => array(
        'src' => $jqueryui_path.'sortable.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-spinner' => array(
        'src' => $jqueryui_path.'spinner.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-button', 'jq-mousewheel'),
        ),
    'jqueryui-tabs' => array(
        'src' => $jqueryui_path.'tabs.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-effect'),
        ),
    'jqueryui-tooltip' => array(
        'src' => $jqueryui_path.'tooltip.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-position', 'jqueryui-effect'),
        ),
    'jqueryui-effect' => array(
        'src' => $jqueryui_path.'effect.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-blind' => array(
        'src' => $jqueryui_path.'effect-blind.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-bounce' => array(
        'src' => $jqueryui_path.'effect-bounce.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-clip' => array(
        'src' => $jqueryui_path.'effect-clip.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-drop' => array(
        'src' => $jqueryui_path.'effect-drop.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-explode' => array(
        'src' => $jqueryui_path.'effect-explode.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-fade' => array(
        'src' => $jqueryui_path.'effect-fade.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-fold' => array(
        'src' => $jqueryui_path.'effect-fold.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-highlight' => array(
        'src' => $jqueryui_path.'effect-highlight.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-pulsate' => array(
        'src' => $jqueryui_path.'effect-pulsate.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-scale' => array(
        'src' => $jqueryui_path.'effect-scale.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-shake' => array(
        'src' => $jqueryui_path.'effect-shake.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-slide' => array(
        'src' => $jqueryui_path.'effect-slide.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-transfer' => array(
        'src' => $jqueryui_path.'effect-transfer.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-touchpunch' => array(
        'src' => $vendor_path.'jquery.ui.touch-punch.min.js',
        'ver' => '0.2.3',
        'dep' => array('jqueryui-widget', 'jqueryui-mouse'),
        ),
    'select2' => array(
        'src' => $vendor_path.'select2.min.js',
        'ver' => '3.4.5',
        'dep' => array('jquery'),
        ),
    'select2-id' => array(
        'src' => $vendor_path.'select2.id.js',
        'ver' => '3.4.5',
        'dep' => array('select2'),
        ),
    'bootstrap' => array(
        'src' => $vendor_path.'bootstrap.min.js',
        'ver' => '3.0.0',
        'dep' => array('jquery'),
        ),
    'bs-datepicker' => array(
        'src' => $vendor_path.'bootstrap.datepicker.js',
        'ver' => '1.3.0',
        'dep' => array('jquery', 'bootstrap'),
        ),
    'bs-datepicker-id' => array(
        'src' => $vendor_path.'bootstrap.datepicker.id.js',
        'ver' => '1.3.0',
        'dep' => array('bs-datepicker'),
        ),
    'bs-switch' => array(
        'src' => $vendor_path.'bootstrap.switch.min.js',
        'ver' => '3.0.0',
        'dep' => array('jquery', 'bootstrap', 'jqueryui-touchpunch'),
        ),
    'chartjs' => array(
        'src' => $vendor_path.'chart.min.js',
        'dep' => array('jquery'),
        ),
    'codemirror' => array(
        'src' => $vendor_path.'codemirror.js',
        'dep' => array('jquery'),
        ),
    'codemirror-xml' => array(
        'src' => $vendor_path.'codemirror.mode.xml.js',
        'dep' => array('codemirror'),
        ),
    'summernote' => array(
        'src' => $vendor_path.'summernote.min.js',
        'dep' => array('jquery', 'bootstrap'),
        ),
    'summernote-id' => array(
        'src' => $vendor_path.'summernote.id-ID.js',
        'dep' => array('summernote'),
        ),
    'html5shiv' => array(
        'src' => $vendor_path.'html5shiv.js',
        'ver' => '3.6.2',
        ),
    'respond' => array(
        'src' => $vendor_path.'respond.min.js',
        'ver' => '1.3.0',
        ),
    'bootigniter' => array(
        'src' => 'js/script.js',
        'ver' => Bootigniter::VERSION,
        'dep' => array('jquery', 'bootstrap'),
        ),
    );



/*
|--------------------------------------------------------------------------
| Asset autoloader
|--------------------------------------------------------------------------
*/

$config['biasset_autoload_styles']  = array('bootigniter');
$config['biasset_autoload_scripts'] = array('bootigniter');

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
