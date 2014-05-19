<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * DON'T BE A DICK PUBLIC LICENSE <http://dbad-license.org>
 * 
 * Version 0.1.4, May 2014
 * Copyright (C) 2014 Fery Wardiyanto <ferywardiyanto@gmail.com>
 *  
 * Everyone is permitted to copy and distribute verbatim or modified copies of
 * this license document, and changing it is allowed as long as the name is
 * changed.
 * 
 * DON'T BE A DICK PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 * 
 * 1. Do whatever you like with the original work, just don't be a dick.
 * 
 *    Being a dick includes - but is not limited to - the following instances:
 * 
 *    1a. Outright copyright infringement - Don't just copy this and change the name.  
 *    1b. Selling the unmodified original with no work done what-so-ever,
 *        that's REALLY being a dick.  
 *    1c. Modifying the original work to contain hidden harmful content.
 *        That would make you a PROPER dick.  
 * 
 * 2. If you become rich through modifications, related works/services, or
 *    supporting the original work, share the love. Only a dick would make loads
 *    off this work and not buy the original work's creator(s) a pint.
 * 
 * 3. Code is provided with no warranty. Using somebody else's code and bitching
 *    when it goes wrong makes you a DONKEY dick. Fix the problem yourself.
 *    A non-dick would submit the fix back.
 *
 * @package     CodeIgniter Baka Pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @version     Version 0.1.4
 * @since       Version 0.1.0
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Theme Class
 *
 * @subpackage  Libraries
 * @category    Theme
 */
class Themee
{
    /**
     * Codeigniter superobject
     *
     * @var  mixed
     */
    protected static $_ci;

    protected $page_title    = '';

    protected $site_title    = '';

    protected $body_attr     = '';

    protected $navbar        = '';

    protected $authenticated = '';

    /**
     * Default class constructor
     */
    public function __construct()
    {
        self::$_ci =& get_instance();

        self::$_ci->load->library('user_agent');
        self::$_ci->load->library('baka_pack/asssets');
        self::$_ci->load->helper('baka_pack/asssets');
        self::$_ci->load->helper('baka_pack/themee');
        self::$_ci->load->helper('baka_pack/twbs');

        // Setup body classes & id
        $this->set_body_attr('id', self::$_ci->router->fetch_class() );
        $this->set_title(get_conf('app_name'));

        $this->authenticated = !self::verify_browser() AND self::$_ci->authr->is_logged_in();

        log_message('debug', "#Baka_pack: Themee Class Initialized");
    }

    // -------------------------------------------------------------------------

    /**
     * Never let your users use before century web browsers :P
     *
     * @return  bool
     */
    public static function verify_browser()
    {
        $min_browser     = get_conf('app_min_browser');
        $current_browser = self::$_ci->agent->browser();
        $current_version = explode('.', self::$_ci->agent->version());

        if (isset($min_browser[$current_browser]))
        {
            return ( $current_version[0] <= $min_browser[$current_browser] ? TRUE : FALSE  );
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Set Page Title
     *
     * @param   string  $page_title  Page Title
     * @return  string
     */
    public function set_title($page_title)
    {
        // Setup page title
        $this->page_title = $page_title;

        // setup site title
        if (strlen($this->site_title) > 0)
        {
            $this->site_title .= ' - '.$page_title;
        }
        else
        {
            $this->site_title = $page_title;
        }

        // setup body classes and ids
        $this->set_body_attr('class', url_title($page_title, '-', TRUE) );

        return $page_title;
    }

    // -------------------------------------------------------------------------

    /**
     * Set Body Class and ID
     *
     * @param   string  $key  Attribute key (id|class)
     * @param   string  $val  Attribute Value
     * @return  mixed
     */
    private function set_body_attr($key, $val)
    {
        if (!in_array($key, array('id', 'class')))
        {
            log_message('error', 'Asssets lib: '.$key.' body attribute is not supported.');
            return FALSE;
        }

        $attrs = array();

        if ($key == 'id')
        {
            $this->body_attr['id']    = 'page-'.$val;
            $this->body_attr['class'] = 'page '.$val;
        }
        else if ($key == 'class')
        {
            $this->body_attr['class'] .= ' '.$val;
        }
    }

    // -------------------------------------------------------------------------

    public function add_navbar( $id, $class = '', $position = 'top' )
    {
        $class .= ' nav';

        $this->navbar[$position][$id] = array( 'class' => $class );
    }

    // -------------------------------------------------------------------------

    public function add_navmenu( $parent_id, $menu_id, $type = 'link', $url = '', $label = '', $attr = array(), $position = 'top' )
    {
        if (is_array($menu_id))
        {
            foreach ($menu_id as $key => $value)
            {
                $this->add_navmenu($parent_id, $key, $value['url'], $value['label'], $value['type'], $value['attr'], $value['position']);
            }
        }
        else
        {
            $url = ($url === '') ? current_url().'#' : $url;

            $id = $parent_id.'-'.$menu_id;

            switch ($type) {
                case 'header':
                    $menus = array(
                        'type'  => $type,
                        'label' => $label,
                        );
                    break;
                
                case 'devider':
                    $menus = array(
                        'type'  => $type,
                        );
                    break;
                
                case 'link':
                    $menus = array(
                        'name'  => $menu_id,
                        'type'  => $type,
                        'url'   => $url,
                        'label' => $label,
                        'attr'  => $attr,
                        );
                    break;
            }

            if (!array_key_exists($parent_id, $this->navbar[$position]))
            {
                $parent = explode('-', $parent_id);
                $sub_menu = array(
                    'class' => 'dropdown-menu',
                    'items' => array(
                        $id => $menus
                        ),
                    );

                $this->navbar[$position][${'parent'}[0]]['items'][$parent_id]['child'][$parent_id.'_sub'] = $sub_menu;
            }
            else
            {
                $this->navbar[$position][$parent_id]['items'][$id] = $menus;
            }
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Get themee properties
     *
     * @param   string  $property  This class properties
     * @return  mixed
     */
    public function get($property)
    {
        if (!isset($this->$property))
        {
            log_message('error', "#Baka_pack: Themee->get property ".$property." doesn't exists.");
            return FALSE;
        }

        return $this->$property;
    }
}

/* End of file Themee.php */
/* Location: ./application/libraries/baka_pack/Themee.php */