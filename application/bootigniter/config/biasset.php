<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BootIgniter Pack
 * @subpackage  Biasset
 * @category    Configurations
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://github.com/feryardiant/bootigniter/blob/master/LICENSE
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

$vendor_path = 'js/lib/';
$bower_path = ENVIRONMENT == 'development' ? 'bower/' : 'vendor/';
$jqueryui_version = '1.11.1';

$config['biasset_register_styles'] = array(
    'gfonts' => array(
        'src' => '//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700,400,600,300',
        ),
    'fontawesome' => array(
        'src' => $bower_path.'fontawesome/css/font-awesome.css',
        'min' => $bower_path.'fontawesome/css/font-awesome.min.css',
        'ver' => '4.2.0',
        'dep' => array('bootstrap'),
        ),
    'bootstrap' => array(
        'src' => $bower_path.'bootstrap/dist/css/bootstrap.css',
        'min' => $bower_path.'bootstrap/dist/css/bootstrap.min.css',
        'ver' => '3.2.0',
        ),
    'bs-datepicker' => array(
        'src' => $bower_path.'bootstrap-datepicker/css/datepicker3.css',
        'ver' => '1.3.0',
        'dep' => array('bootstrap'),
        ),
    'bs-switch' => array(
        'src' => $bower_path.'bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css',
        'min' => $bower_path.'bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
        'ver' => '3.0.2',
        'dep' => array('bootstrap'),
        ),
    'jqueryui-core' => array(
        'src' => $bower_path.'jqueryui/themes/base/core.css',
        'ver' => $jqueryui_version,
        ),
    'jqueryui-accordion' => array(
        'src' => $bower_path.'jqueryui/themes/base/accordion.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-autocomplete' => array(
        'src' => $bower_path.'jqueryui/themes/base/autocomplete.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-button' => array(
        'src' => $bower_path.'jqueryui/themes/base/button.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-datepicker' => array(
        'src' => $bower_path.'jqueryui/themes/base/datepicker.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-dialog' => array(
        'src' => $bower_path.'jqueryui/themes/base/dialog.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-draggable' => array(
        'src' => $bower_path.'jqueryui/themes/base/draggable.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-menu' => array(
        'src' => $bower_path.'jqueryui/themes/base/menu.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-progressbar' => array(
        'src' => $bower_path.'jqueryui/themes/base/progressbar.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-resizable' => array(
        'src' => $bower_path.'jqueryui/themes/base/resizable.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-selectable' => array(
        'src' => $bower_path.'jqueryui/themes/base/selectable.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-selectmenu' => array(
        'src' => $bower_path.'jqueryui/themes/base/selectmenu.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-sortable' => array(
        'src' => $bower_path.'jqueryui/themes/base/sortable.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-slider' => array(
        'src' => $bower_path.'jqueryui/themes/base/slider.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-spinner' => array(
        'src' => $bower_path.'jqueryui/themes/base/spinner.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-tabs' => array(
        'src' => $bower_path.'jqueryui/themes/base/tabs.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-tooltip' => array(
        'src' => $bower_path.'jqueryui/themes/base/tooltip.css',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jq-datatables' => array(
        'src' => $bower_path.'datatables/media/css/jquery.dataTables.css',
        'min' => $bower_path.'datatables/media/css/jquery.dataTables.min.css',
        'ver' => '1.10.2',
        ),
    'jq-fineuploader' => array(
        'src' => $bower_path.'fineuploader-dist/dist/jquery.fineuploader.css',
        'min' => $bower_path.'fineuploader-dist/dist/jquery.fineuploader.min.css',
        'ver' => '5.0.7',
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
        'src' => $bower_path.'jquery/dist/jquery.js',
        'min' => $bower_path.'jquery/dist/jquery.min.js',
        'ver' => '2.0.3',
        ),
    'jq-autosize' => array(
        'src' => $bower_path.'jquery-autosize/jquery.autosize.js',
        'min' => $bower_path.'jquery-autosize/jquery.autosize.min.js',
        'ver' => '1.18.12',
        'dep' => array('jquery'),
        ),
    'jq-datatables' => array(
        'src' => $bower_path.'datatables/media/js/jquery.dataTables.js',
        'min' => $bower_path.'datatables/media/js/jquery.dataTables.min.js',
        'ver' => '1.10.2',
        'dep' => array('jquery'),
        ),
    'jq-fineuploader' => array(
        'src' => $bower_path.'fineuploader-dist/dist/jquery.fineuploader.js',
        'min' => $bower_path.'fineuploader-dist/dist/jquery.fineuploader.min.js',
        'ver' => '5.0.7',
        'dep' => array('jquery'),
        ),
    'jq-mousewheel' => array(
        'src' => $bower_path.'jquery-mousewheel/jquery.mousewheel.js',
        'min' => $bower_path.'jquery-mousewheel/jquery.mousewheel.min.js',
        'ver' => '3.1.12',
        'dep' => array('jquery', 'jqueryui-mouse'),
        ),
    'jqueryui-core' => array(
        'src' => $bower_path.'jqueryui/ui/core.js',
        'min' => $bower_path.'jqueryui/ui/minified/core.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jquery'),
        ),
    'jqueryui-mouse' => array(
        'src' => $bower_path.'jqueryui/ui/mouse.js',
        'min' => $bower_path.'jqueryui/ui/minified/mouse.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-widget' => array(
        'src' => $bower_path.'jqueryui/ui/widget.js',
        'min' => $bower_path.'jqueryui/ui/minified/widget.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-button' => array(
        'src' => $bower_path.'jqueryui/ui/button.js',
        'min' => $bower_path.'jqueryui/ui/minified/button.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-menu' => array(
        'src' => $bower_path.'jqueryui/ui/menu.js',
        'min' => $bower_path.'jqueryui/ui/minified/menu.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-position' => array(
        'src' => $bower_path.'jqueryui/ui/position.js',
        'min' => $bower_path.'jqueryui/ui/minified/position.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-mouse'),
        ),
    'jqueryui-draggable' => array(
        'src' => $bower_path.'jqueryui/ui/draggable.js',
        'min' => $bower_path.'jqueryui/ui/minified/draggable.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-mouse'),
        ),
    'jqueryui-droppable' => array(
        'src' => $bower_path.'jqueryui/ui/droppable.js',
        'min' => $bower_path.'jqueryui/ui/minified/droppable.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-resizable' => array(
        'src' => $bower_path.'jqueryui/ui/resizable.js',
        'min' => $bower_path.'jqueryui/ui/minified/resizable.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-selectable' => array(
        'src' => $bower_path.'jqueryui/ui/selectable.js',
        'min' => $bower_path.'jqueryui/ui/minified/selectable.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-accordion' => array(
        'src' => $bower_path.'jqueryui/ui/accordion.js',
        'min' => $bower_path.'jqueryui/ui/minified/accordion.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-effect'),
        ),
    'jqueryui-autocomplete' => array(
        'src' => $bower_path.'jqueryui/ui/autocomplete.js',
        'min' => $bower_path.'jqueryui/ui/minified/autocomplete.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-menu', 'jqueryui-position'),
        ),
    'jqueryui-datepicker' => array(
        'src' => $bower_path.'jqueryui/ui/datepicker.js',
        'min' => $bower_path.'jqueryui/ui/minified/datepicker.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-datepicker-id' => array(
        'src' => $bower_path.'jqueryui/ui/i18n/datepicker-id.js',
        'min' => $bower_path.'jqueryui/ui/minified/i18n/datepicker-id.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-datepicker'),
        ),
    'jqueryui-dialog' => array(
        'src' => $bower_path.'jqueryui/ui/dialog.js',
        'min' => $bower_path.'jqueryui/ui/minified/dialog.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-button', 'jqueryui-position', 'jqueryui-draggable', 'jqueryui-resizable'),
        ),
    'jqueryui-progressbar' => array(
        'src' => $bower_path.'jqueryui/ui/progressbar.js',
        'min' => $bower_path.'jqueryui/ui/minified/progressbar.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-slider' => array(
        'src' => $bower_path.'jqueryui/ui/slider.js',
        'min' => $bower_path.'jqueryui/ui/minified/slider.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jq-mousewheel'),
        ),
    'jqueryui-sortable' => array(
        'src' => $bower_path.'jqueryui/ui/sortable.js',
        'min' => $bower_path.'jqueryui/ui/minified/sortable.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget'),
        ),
    'jqueryui-spinner' => array(
        'src' => $bower_path.'jqueryui/ui/spinner.js',
        'min' => $bower_path.'jqueryui/ui/minified/spinner.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-button', 'jq-mousewheel'),
        ),
    'jqueryui-tabs' => array(
        'src' => $bower_path.'jqueryui/ui/tabs.js',
        'min' => $bower_path.'jqueryui/ui/minified/tabs.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-effect'),
        ),
    'jqueryui-tooltip' => array(
        'src' => $bower_path.'jqueryui/ui/tooltip.js',
        'min' => $bower_path.'jqueryui/ui/minified/tooltip.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-widget', 'jqueryui-position', 'jqueryui-effect'),
        ),
    'jqueryui-effect' => array(
        'src' => $bower_path.'jqueryui/ui/effect.js',
        'min' => $bower_path.'jqueryui/ui/minified/effect.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-blind' => array(
        'src' => $bower_path.'jqueryui/ui/effect-blind.js',
        'min' => $bower_path.'jqueryui/ui/minified/effect-blind.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-bounce' => array(
        'src' => $bower_path.'jqueryui/ui/effect-bounce.js',
        'min' => $bower_path.'jqueryui/ui/minified/effect-bounce.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-clip' => array(
        'src' => $bower_path.'jqueryui/ui/effect-clip.js',
        'min' => $bower_path.'jqueryui/ui/minified/effect-clip.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-drop' => array(
        'src' => $bower_path.'jqueryui/ui/effect-drop.js',
        'min' => $bower_path.'jqueryui/ui/minified/effect-drop.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-explode' => array(
        'src' => $bower_path.'jqueryui/ui/effect-explode.js',
        'min' => $bower_path.'jqueryui/ui/minified/effect-explode.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-fade' => array(
        'src' => $bower_path.'jqueryui/ui/effect-fade.js',
        'min' => $bower_path.'jqueryui/ui/minified/effect-fade.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-fold' => array(
        'src' => $bower_path.'jqueryui/ui/effect-fold.js',
        'min' => $bower_path.'jqueryui/ui/minified/effect-fold.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-highlight' => array(
        'src' => $bower_path.'jqueryui/ui/effect-highlight.js',
        'min' => $bower_path.'jqueryui/ui/minified/effect-highlight.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-pulsate' => array(
        'src' => $bower_path.'jqueryui/ui/effect-pulsate.js',
        'min' => $bower_path.'jqueryui/ui/minified/effect-pulsate.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-scale' => array(
        'src' => $bower_path.'jqueryui/ui/effect-scale.js',
        'min' => $bower_path.'jqueryui/ui/minified/effect-scale.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-shake' => array(
        'src' => $bower_path.'jqueryui/ui/effect-shake.js',
        'min' => $bower_path.'jqueryui/ui/minified/effect-shake.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-slide' => array(
        'src' => $bower_path.'jqueryui/ui/effect-slide.js',
        'min' => $bower_path.'jqueryui/ui/minified/effect-slide.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-effect-transfer' => array(
        'src' => $bower_path.'jqueryui/ui/effect-transfer.js',
        'min' => $bower_path.'jqueryui/ui/minified/effect-transfer.min.js',
        'ver' => $jqueryui_version,
        'dep' => array('jqueryui-core'),
        ),
    'jqueryui-touchpunch' => array(
        'src' => $bower_path.'jqueryui-touch-punch/jquery.ui.touch-punch.js',
        'min' => $bower_path.'jqueryui-touch-punch/jquery.ui.touch-punch.min.js',
        'ver' => '0.2.3',
        'dep' => array('jqueryui-widget', 'jqueryui-mouse'),
        ),
    'bootstrap' => array(
        'src' => $bower_path.'bootstrap/dist/js/bootstrap.js',
        'min' => $bower_path.'bootstrap/dist/js/bootstrap.min.js',
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
        'src' => $bower_path.'bootstrap-switch/dist/js/bootstrap-switch.js',
        'min' => $bower_path.'bootstrap-switch/dist/js/bootstrap-switch.min.js',
        'ver' => '3.0.2',
        'dep' => array('jquery', 'bootstrap', 'jqueryui-touchpunch'),
        ),
    'select2' => array(
        'src' => $bower_path.'select2/select2.js',
        'min' => $bower_path.'select2/select2.min.js',
        'ver' => '3.5.1',
        'dep' => array('jquery'),
        ),
    'select2-id' => array(
        'src' => $bower_path.'select2/select2_locale_id.js',
        'ver' => '3.5.1',
        'dep' => array('select2'),
        ),
    'chartjs' => array(
        'src' => $vendor_path.'chart.min.js',
        'dep' => array('jquery'),
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
        'src' => $bower_path.'summernote/dist/summernote.js',
        'min' => $bower_path.'summernote/dist/summernote.min.js',
        'dep' => array('jquery', 'bootstrap'),
        'ver' => '0.5.9',
        ),
    'summernote-id' => array(
        'src' => $bower_path.'summernote/lang/summernote-id-ID.js',
        'dep' => array('summernote'),
        'ver' => '0.5.9',
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

$config['biasset_autoload_styles']  = array('gfonts', 'bootstrap', 'fontawesome');
$config['biasset_autoload_scripts'] = array('jquery', 'bootstrap');


/* End of file biasset.php */
/* Location: ./bootigniter/config/biasset.php */
