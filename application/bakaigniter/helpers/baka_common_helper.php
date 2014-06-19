<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package     Baka Igniter Pack
 * @subpackage  Common
 * @category    Helper
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

function _x( $lang_line, $replacement = '' )
{
    $CI_lang =& get_instance()->lang;

    $lang_line = $CI_lang->line($lang_line);

    if (is_array($replacement) and count($replacement) > 0)
    {
        return vsprintf($lang_line, $replacement);
    }
    else if (is_string($replacement) and strlen($replacement) > 0)
    {
        return sprintf($lang_line, $replacement);
    }
    else
    {
        return $lang_line;
    }
}

// -----------------------------------------------------------------------------

function redirect( $uri = '', $method = 'location', $http_response_code = 302 )
{
    if ( IS_CLI )
    {
        if ( !defined('PROJECT_DIR') )
        {
            echo "Redirecting: $uri\n";
            exit;            
        }
        else
        {
            return;
        }
    }

    if ( ! preg_match('#^https?://#i', $uri))
    {
        $uri = site_url($uri);
    }

    switch($method)
    {
        case 'refresh'  : header("Refresh:0;url=".$uri);
            break;

        default         : header("Location: ".$uri, TRUE, $http_response_code);
            break;
    }
    exit;
}

// -----------------------------------------------------------------------------

/**
 * URL Validation
 *
 * @param   string  $url  URL that want tobe validated
 * @return  bool
 */
function is_valid_url( $url )
{
    $url_pattern = "/^(http(s?):\/\/|(\/\/?))/";

    return preg_match($url_pattern, $url);
}

// -----------------------------------------------------------------------------

/**
 * Email Validation
 *
 * @param   string  $EMAIL  Email that want tobe validated
 * @return  bool
 */
function is_valid_email( $email )
{
    $email_pattern = "/([a-zA-Z0-9_\.\-\+]+)@([a-zA-Z0-9\-]+)\.([a-zA-Z0-9\-\.]*)/i";

    return preg_match($email_pattern, $email);
}

// -----------------------------------------------------------------------------

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

// -----------------------------------------------------------------------------

/**
 * Get default application setting
 *
 * @param   string  $name  Setting name
 * @return  mixed
 */
function get_setting( $name )
{
    $bakaigniter =& Bakaigniter::get_instance();

    return $bakaigniter->get_setting( $name );
}

// -----------------------------------------------------------------------------

/**
 * Get application message(s)
 *
 * @param   string  $level  Message level
 * @return  mixed
 */
function get_message( $level = FALSE )
{
    $bakaigniter =& Bakaigniter::get_instance();

    return $bakaigniter->get_message( $level );
}

// -----------------------------------------------------------------------------

/**
 * Set application message(s)
 *
 * @param   mixed   $level     Message level
 * @param   string  $msg_item  Message Item
 * @return  mixed
 */
function set_message( $level, $msg_item )
{
    $bakaigniter =& Bakaigniter::get_instance();

    return $bakaigniter->set_message( $level, $msg_item );
}

// -----------------------------------------------------------------------------

/**
 * Get file extension from path
 *
 * @param   string  $path  Full file path
 * @return  string
 */
function get_ext( $path )
{
    return pathinfo( $path, PATHINFO_EXTENSION );
}

// -----------------------------------------------------------------------------

/**
 * Convert Boolean to String
 *
 * @param   bool    $bool  Variable that you want to convert
 * @param   bool    $uc    Are you want return it uppercased
 *
 * @return  string
 */
function bool_to_str( $bool, $uc = FALSE )
{
    $bool = (bool) $bool;
    $ret = $bool ? 'ya' : 'tidak';

    return $uc ? strtoupper( $ret ) : $ret;
}

// -----------------------------------------------------------------------------

/**
 * Convert Boolean to Integer
 *
 * @param   bool    $bool  Variable that you want to convert
 *
 * @return  string
 */
function bool_to_int( $bool )
{
    return $bool ? 1 : 0;
}

// -----------------------------------------------------------------------------

function baka_echo($anu)
{
    if (is_array($anu) OR is_object($anu))
    {
        var_dump($anu);
    }
    else
    {
        echo $anu;
    }
}

// -----------------------------------------------------------------------------

function print_pre($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

/* End of file common_helper.php */
/* Location: ./application/third_party/bakaigniter/helpers/common_helper.php */