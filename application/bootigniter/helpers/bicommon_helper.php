<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://feryardiant.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/feryardiant/bpmppt/blob/master/LICENSE)
 * @subpackage  Bicommons
 * @category    Common Helpers
 */

// -----------------------------------------------------------------------------

function _x( $line, $reps = '' )
{
    $CI_lang =& get_instance()->lang;
    $line = $CI_lang->line($line);

    if (!empty($reps))
    {
        if (!is_array($reps))
        {
            $reps = array($reps);
        }

        return vsprintf($line, $reps);
    }

    return $line;
}

// -----------------------------------------------------------------------------

function redirect( $uri = '', $method = 'location', $http_response_code = 302 )
{
    if ( IS_CLI )
    {
        if ( !defined('PHPUNIT_TEST') )
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
    $url_pattern = "/^(http(s?):\/\/|(\/\/?)|(www.?))/i";
    // $url_pattern = "#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#i";

    return (bool) preg_match($url_pattern, $url);
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

    return (bool) preg_match($email_pattern, $email);
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
    $bootigniter =& get_instance()->bootigniter;

    return $bootigniter->get_message( $level );
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
    $bootigniter =& get_instance()->bootigniter;

    return $bootigniter->set_message( $level, $msg_item );
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

function bi_echo( $text )
{
    if ( is_array( $text ) OR is_object( $text ) )
    {
        print_pre( $text );
    }
    else
    {
        echo $text;
    }
}

// -----------------------------------------------------------------------------

/**
 * Debuging purposes
 *
 * @param   resource  $debug  Object or array
 * @return  string
 */
function print_pre( $debug = null )
{
    if ( !empty( $debug ) )
    {
        echo '<pre>'.print_r( $debug, TRUE ).'</pre>';
    }
}

/* End of file common_helper.php */
/* Location: ./bootigniter/helpers/common_helper.php */
