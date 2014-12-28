<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.5 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2014 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  Biasset
 * @category    Configurations
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

$vendor_path = 'js/lib/';
$bower_path = 'vendor/';
$jqueryui_version = '1.11.1';
$jqueryui_css_path = $bower_path.'jquery-ui/themes/base/';
$jqueryui_js_path = $bower_path.'jquery-ui/ui/minified/';

$config['biasset_register_styles'] = array(
    'gfonts' => array(
        'src' => '//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700,400,600,300',
        ),
    'fontawesome' => array(
        'src' => $bower_path.'fontawesome/css/font-awesome.min.css',
        'ver' => '4.2.0',
        'dep' => array('bootstrap'),
        ),
    'bootstrap' => array(
        'src' => $bower_path.'bootstrap/dist/css/bootstrap.min.css',
        'ver' => '3.2.0',
        ),
    'bs-datepicker' => array(
        'src' => $bower_path.'bootstrap-datepicker/css/datepicker3.css',
        'ver' => '1.3.0',
        'dep' => array('bootstrap'),
        ),
    'bs-switch' => array(
        'src' => $bower_path.'bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
        'ver' => '3.0.2',
        'dep' => array('bootstrap'),
        ),
    'jqueryui-core' => array(
        'src' => $jqueryui_css_path.'core.css',
        'ver' => $jqueryui_version,
        ),
    'jqueryui-accordion' => array(
        'src' => $jqueryui_css_path.'accordion.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-autocomplete' => array(
        'src' => $jqueryui_css_path.'autocomplete.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-button' => array(
        'src' => $jqueryui_css_path.'button.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-datepicker' => array(
        'src' => $jqueryui_css_path.'datepicker.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-dialog' => array(
        'src' => $jqueryui_css_path.'dialog.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-draggable' => array(
        'src' => $jqueryui_css_path.'draggable.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-menu' => array(
        'src' => $jqueryui_css_path.'menu.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-progressbar' => array(
        'src' => $jqueryui_css_path.'progressbar.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-resizable' => array(
        'src' => $jqueryui_css_path.'resizable.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-selectable' => array(
        'src' => $jqueryui_css_path.'selectable.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-selectmenu' => array(
        'src' => $jqueryui_css_path.'selectmenu.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-sortable' => array(
        'src' => $jqueryui_css_path.'sortable.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-slider' => array(
        'src' => $jqueryui_css_path.'slider.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-spinner' => array(
        'src' => $jqueryui_css_path.'spinner.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-tabs' => array(
        'src' => $jqueryui_css_path.'tabs.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-tooltip' => array(
        'src' => $jqueryui_css_path.'tooltip.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jq-datatables' => array(
        'src' => $bower_path.'datatables/media/css/jquery.dataTables.min.css',
        'ver' => '1.10.2',
        ),
    'jq-fineuploader' => array(
        'src' => $bower_path.'fineuploader-dist/dist/jquery.fineuploader.min.css',
        'ver' => '5.0.7',
        ),
    'morrisjs' => array(
        'src' => $bower_path.'morrisjs/morris.css',
        'ver' => '0.5.0',
        ),
    'select2' => array(
        'src' => $bower_path.'select2/select2.css',
        'ver' => '3.4.5',
        ),
    'summernote' => array(
        'src' => $bower_path.'summernote/dist/summernote.css',
        'dep' => array('bootstrap', 'fontawesome'),
        'ver' => '0.5.9',
        ),
    );

$config['biasset_register_scripts'] = array(
    'jquery' => array(
        'src' => $bower_path.'jquery/dist/jquery.min.js',
        'ver' => '2.0.3',
        ),
    'jq-autosize' => array(
        'src' => $bower_path.'jquery-autosize/jquery.autosize.min.js',
        'ver' => '1.18.12',
        'dep' => array('jquery'),
        ),
    'jq-datatables' => array(
        'src' => $bower_path.'datatables/media/js/jquery.dataTables.min.js',
        'ver' => '1.10.2',
        'dep' => array('jquery'),
        ),
    'jq-fineuploader' => array(
        'src' => $bower_path.'fineuploader-dist/dist/jquery.fineuploader.min.js',
        'ver' => '5.0.7',
        'dep' => array('jquery'),
        ),
    'jq-mousewheel' => array(
        'src' => $bower_path.'jquery-mousewheel/jquery.mousewheel.min.js',
        'ver' => '3.1.12',
        'dep' => array('jquery', 'jqueryui-mouse'),
        ),
    'jqueryui-core' => array(
        'src' => $jqueryui_js_path.'core.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jquery'),
        ),
    'jqueryui-mouse' => array(
        'src' => $jqueryui_js_path.'mouse.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-widget' => array(
        'src' => $jqueryui_js_path.'widget.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-button' => array(
        'src' => $jqueryui_js_path.'button.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-menu' => array(
        'src' => $jqueryui_js_path.'menu.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-position' => array(
        'src' => $jqueryui_js_path.'position.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-mouse'),
        ),
    'jqueryui-draggable' => array(
        'src' => $jqueryui_js_path.'draggable.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-mouse'),
        ),
    'jqueryui-droppable' => array(
        'src' => $jqueryui_js_path.'droppable.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-resizable' => array(
        'src' => $jqueryui_js_path.'resizable.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-selectable' => array(
        'src' => $jqueryui_js_path.'selectable.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-accordion' => array(
        'src' => $jqueryui_js_path.'accordion.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-effect'),
        ),
    'jqueryui-autocomplete' => array(
        'src' => $jqueryui_js_path.'autocomplete.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-menu', 'jqueryui-position'),
        ),
    'jqueryui-datepicker' => array(
        'src' => $jqueryui_js_path.'datepicker.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-datepicker-id' => array(
        'src' => $jqueryui_js_path.'i18n/datepicker-id.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-datepicker'),
        ),
    'jqueryui-dialog' => array(
        'src' => $jqueryui_js_path.'dialog.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-button', 'jqueryui-position', 'jqueryui-draggable', 'jqueryui-resizable'),
        ),
    'jqueryui-progressbar' => array(
        'src' => $jqueryui_js_path.'progressbar.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-slider' => array(
        'src' => $jqueryui_js_path.'slider.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jq-mousewheel'),
        ),
    'jqueryui-sortable' => array(
        'src' => $jqueryui_js_path.'sortable.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-spinner' => array(
        'src' => $jqueryui_js_path.'spinner.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-button', 'jq-mousewheel'),
        ),
    'jqueryui-tabs' => array(
        'src' => $jqueryui_js_path.'tabs.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-effect'),
        ),
    'jqueryui-tooltip' => array(
        'src' => $jqueryui_js_path.'tooltip.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-position', 'jqueryui-effect'),
        ),
    'jqueryui-effect' => array(
        'src' => $jqueryui_js_path.'effect.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-blind' => array(
        'src' => $jqueryui_js_path.'effect-blind.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-bounce' => array(
        'src' => $jqueryui_js_path.'effect-bounce.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-clip' => array(
        'src' => $jqueryui_js_path.'effect-clip.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-drop' => array(
        'src' => $jqueryui_js_path.'effect-drop.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-explode' => array(
        'src' => $jqueryui_js_path.'effect-explode.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-fade' => array(
        'src' => $jqueryui_js_path.'effect-fade.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-fold' => array(
        'src' => $jqueryui_js_path.'effect-fold.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-highlight' => array(
        'src' => $jqueryui_js_path.'effect-highlight.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-pulsate' => array(
        'src' => $jqueryui_js_path.'effect-pulsate.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-scale' => array(
        'src' => $jqueryui_js_path.'effect-scale.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-shake' => array(
        'src' => $jqueryui_js_path.'effect-shake.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-slide' => array(
        'src' => $jqueryui_js_path.'effect-slide.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-transfer' => array(
        'src' => $jqueryui_js_path.'effect-transfer.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-touchpunch' => array(
        'src' => $bower_path.'jquery-ui-touch-punch/jquery.ui.touch-punch.min.js',
        'ver' => '0.2.3',
        'dep' => array('jqueryui-widget', 'jqueryui-mouse'),
        ),
    'bootstrap' => array(
        'src' => $bower_path.'bootstrap/dist/js/bootstrap.min.js',
        'ver' => '3.2.0',
        'dep' => array('jquery'),
        ),
    'bs-datatables' => array(
        'src' => $bower_path.'datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js',
        'ver' => '1.10.0',
        'dep' => array('bootstrap', 'jq-datatables'),
        ),
    'bs-datepicker' => array(
        'src' => $bower_path.'bootstrap-datepicker/js/bootstrap-datepicker.js',
        'ver' => '1.3.0',
        'dep' => array('jquery', 'bootstrap'),
        ),
    'bs-datepicker-id' => array(
        'src' => $bower_path.'bootstrap-datepicker/js/locales/bootstrap-datepicker.id.js',
        'ver' => '1.3.0',
        'dep' => array('bs-datepicker'),
        ),
    'bs-switch' => array(
        'src' => $bower_path.'bootstrap-switch/dist/js/bootstrap-switch.min.js',
        'ver' => '3.0.2',
        'dep' => array('jquery', 'bootstrap', 'jqueryui-touchpunch'),
        ),
    'select2' => array(
        'src' => $bower_path.'select2/select2.min.js',
        'ver' => '3.5.1',
        'dep' => array('jquery'),
        ),
    'select2-id' => array(
        'src' => $bower_path.'select2/select2_locale_id.js',
        'ver' => '3.5.1',
        'dep' => array('select2'),
        ),
    'codemirror' => array(
        'src' => $bower_path.'codemirror/lib/codemirror.js',
        'dep' => array('jquery'),
        'ver' => '4.6.0',
        ),
    'codemirror-xml' => array(
        'src' => $bower_path.'codemirror/lib/mode/xml/xml.js',
        'dep' => array('codemirror'),
        'ver' => '4.6.0',
        ),
    'summernote' => array(
        'src' => $bower_path.'summernote/dist/summernote.min.js',
        'dep' => array('jquery', 'bootstrap'),
        'ver' => '0.5.9',
        ),
    'summernote-id' => array(
        'src' => $bower_path.'summernote/lang/summernote-id-ID.js',
        'dep' => array('summernote'),
        'ver' => '0.5.9',
        ),
    'morris' => array(
        'src' => $bower_path.'morrisjs/morris.js',
        'dep' => array('jquery', 'raphael'),
        'ver' => '0.5.0',
        ),
    'chart' => array(
        'src' => $vendor_path.'chart.min.js',
        'dep' => array('jquery'),
        ),
    'raphael' => array(
        'src' => $bower_path.'raphael/raphael.js',
        // 'dep' => array('jquery', 'raphael'),
        'ver' => '2.1.1',
        ),
    'html5shiv' => array(
        'src' => $vendor_path.'html5shiv.js',
        'ver' => '3.6.2',
        ),
    'respond' => array(
        'src' => $vendor_path.'respond.min.js',
        'ver' => '1.3.0',
        ),
    );



/*
|--------------------------------------------------------------------------
| Asset autoloader
|--------------------------------------------------------------------------
*/

$config['biasset_autoload_styles']  = array('gfonts', 'fontawesome');
$config['biasset_autoload_scripts'] = array('bootstrap');


/* End of file biasset.php */
/* Location: ./bootigniter/config/biasset.php */
