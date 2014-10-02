<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package     BootIgniter Pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     https://github.com/feryardiant/bootigniter/blob/master/license.md
 * @since       Version 0.1.5
 */

// -----------------------------------------------------------------------------

/**
 * BootIgniter Biasset Class
 *
 * @subpackage  Libraries
 * @category    Assets
 */
class Biasset
{
    /**
     * Codeigniter superobject
     * @var  resource
     */
    protected $_ci;

    /**
     * Registered Scripts and Styles
     * @var  array
     */
    protected $_registered = array(
        'scripts' => array(),
        'styles' => array(),
        );

    /**
     * Registered Scripts and Styles
     * @var  array
     */
    protected $_loaded = array(
        'scripts' => array(),
        'styles' => array(),
        );

    /**
     * Class Constructor
     */
    public function __construct()
    {
        // Get instanciation of CI Super Object
        $this->_ci =& get_instance();
        // Load This Lib Configuration
        $this->_ci->config->load('biasset');
        $this->_ci->load->helper('biasset');

        $this->initialize();

        log_message('debug', "#BootIgniter: Biasset Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Registering all assets (Scripts and Styles)
     *
     * @return  void
     */
    protected function initialize()
    {
        foreach ($this->_registered as $type => $asset)
        {
            foreach (config_item('biasset_register_'.$type) as $id => $meta)
            {
                $meta = array_set_defaults($meta, array(
                    'src' => '',
                    'ver' => '',
                    'dep' => array(),
                    ));

                $asset[$id] = $meta;
            }

            $this->_registered[$type] = $asset;

            foreach (config_item('biasset_autoload_'.$type) as $asset_id)
            {
                $this->load($type, $asset_id);
            }
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Loading required Scripts or Styles
     *
     * @return  void
     */
    protected function load($type, $id, $src = '', $ver = '', $dep = array())
    {
        if (!isset($this->_registered[$type]))
        {
            return;
        }

        if (!empty($src))
        {
            $this->_registered[$type][$id] = array(
                'src' => $src,
                'ver' => !empty($ver) ? $ver : config_item('application_version'),
                'dep' => !is_array($dep) ? array($dep) : $dep,
                );
        }

        $asset = $this->_registered[$type][$id];

        if (!empty($asset['dep']))
        {
            foreach ($asset['dep'] as $dep_id)
            {
                if (isset($this->_registered[$type][$dep_id]))
                {
                    $this->load($type, $dep_id);
                }
            }

        }

        if (file_exists(config_item('biasset_path_prefix').$asset['src']))
        {
            $asset['src'] = base_url(config_item('biasset_path_prefix').$asset['src']);
        }

        // if (preg_match("/^(http(s?):\/\/|(\/\/?)|(www.?))/i", $asset['src']))
        if (is_valid_url($asset['src']))
        {
            // $attrs['src'] = $asset['src'].$ver;
            $asset['url'] = $asset['src'];
            unset($asset['src']);
        }

        unset($asset['dep']);
        $this->_loaded[$type][$id] = $asset;
    }

    // -------------------------------------------------------------------------

    /**
     * Loading required script
     *
     * @param   string  $id  Script ID
     * @return  void
     */
    public function load_script($id, $src = '', $ver = '', $dep = array())
    {
        $this->load('scripts', $id, $src, $ver, $dep);
    }

    // -------------------------------------------------------------------------

    /**
     * Loading required style
     *
     * @param   string  $id  Style ID
     * @return  void
     */
    public function load_style($id, $src = '', $ver = '', $dep = array())
    {
        $this->load('styles', $id, $src, $ver, $dep);
    }

    // -------------------------------------------------------------------------

    /**
     * Get all scripts you need on the page
     *
     * @return  array
     */
    public function get_loaded($type)
    {
        $load = $this->_loaded;

        if (!isset($load[$type]))
        {
            return;
        }

        if ($compiled = $this->compile($type))
        {
            $load = $compiled;
        }

        $output = '';

        foreach ($load[$type] as $id => $asset)
        {
            $attrs = array(
                'id' => $id,
                'charset' => strtolower(config_item('charset')),
                );

            if (isset($asset['url']))
            {
                $mark = strpos($asset['url'], '?') !== FALSE ? '&' : '?';
                $ver = !empty($asset['ver']) ? $mark.'v='.$asset['ver'] : '';
                $asset['url'] = strpos($asset['url'], 'http://') !== FALSE ? str_replace('http://', '//', $asset['url']) : $asset['url'];
            }

            if ($type == 'scripts')
            {
                $attrs['type'] = 'text/javascript';

                if (isset($asset['url']))
                {
                    $attrs['src'] = $asset['url'].$ver;
                    $output .= '<script '.parse_attrs($attrs).'></script>';
                }
                else
                {
                    $attribute = parse_attrs($attrs);
                    $output .= "<script $attribute>\n$(function() {\n".$asset['src']."\n});\n</script>";
                }

                $output .= "\n";
            }
            elseif ($type == 'styles')
            {
                $attrs['type'] = 'text/css';

                if (isset($asset['url']))
                {
                    $attrs['rel'] = 'stylesheet';
                    $attrs['href'] = $asset['url'].$ver;
                    $output .= '<link '.parse_attrs($attrs).'></link>'."\n";
                }
                else
                {
                    $attribute = parse_attrs($attrs);
                    $output .= "<style $attribute>\n".$asset['src']."\n</style>\n";
                }
            }
        }

        return $output;
    }

    public function compile($type)
    {
        // $file_name = uri_string();
        $file_name = url_title(uri_string(), '-', TRUE);
        $ext = $type == 'scripts' ? '.js' : '.css';

        if (!file_exists(config_item('cache_path').$file_name.$ext))
        {
            $this->_ci->load->helper('file');
            $contents = '';

            foreach ($this->_loaded[$type] as $id => $asset)
            {
                if (isset($asset['url']))
                {
                    $path = str_replace(base_url(), '', $asset['url']);
                    if (strpos($asset['url'], base_url()) !== FALSE and file_exists($path))
                    {
                        // and file_exists($path)
                        $contents .= "\n"
                                  .  '// '.$id."\n"
                                  .  '// ---------------------------'."\n"
                                  .  read_file($path)
                                  .  "\n";
                    }
                }
                elseif (isset($asset['src']))
                {
                    $contents .= "\n"
                              .  '// '.$id."\n"
                              .  '// ---------------------------'."\n"
                              .  $asset['src']
                              .  "\n";
                }
            }

            if (!write_file(config_item('cache_path').$file_name.$ext, $contents))
            {
                log_message('error', 'Unable to compile '.$type);
            }
        }

        $path = str_replace(FCPATH, base_url(), config_item('cache_path'));
        $compiled[$type][$file_name] = array(
            'url' => base_url($path.$file_name.$ext),
            'ver' => Bootigniter::VERSION,
            );

        return $compiled;
    }
}

/* End of file Biasset.php */
/* Location: ./bootigniter/libraries/Biasset.php */
