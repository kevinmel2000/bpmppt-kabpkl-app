<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
 * @subpackage  Common
 * @category    Helper
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

function _x($lang_line, $replacement = '')
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

function return_bytes($val)
{
    if (!is_string($val))
        return FALSE;

    $val    = trim($val);
    $last   = strtolower($val[strlen($val)-1]);

    switch ($last)
    {
        case 'g': $val *= 1024;
        case 'm': $val *= 1024;
        case 'k': $val *= 1024;
    }

    return $val;
}

// -----------------------------------------------------------------------------

function format_size($size)
{
    $sizes  = Array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');
    $y      = $sizes[0];

    for ($i = 1; (($i < count($sizes)) && ($size >= 1024)); $i++)
    {
        $size   = $size / 1024;
        $y      = $sizes[$i];
    }

    return round($size, 2).' <span class="muted">'.$y.'</span>';
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
// Date and Time helper
// -----------------------------------------------------------------------------

function format_date($string = '')
{
    return bdate(Setting::get('app_date_format'), $string);
}

// -----------------------------------------------------------------------------

function format_datetime($string = '')
{
    return bdate(Setting::get('app_datetime_format'), $string);
}

// -----------------------------------------------------------------------------

function format_time($string = '')
{
    return bdate('H:i:s', $string);
}

// -----------------------------------------------------------------------------

function string_to_date($string = '')
{
    return bdate('Y-m-d', $string);
}

// -----------------------------------------------------------------------------

function string_to_datetime($string = '')
{
    return bdate('Y-m-d H:i:s', $string);
}

// -----------------------------------------------------------------------------

function bdate($format = '', $strdate = '')
{
    setlocale(LC_ALL, 'id');

    $strdate = strlen($strdate) > 0 ? strtotime($strdate) : time();
    $format || $format = 'Y-m-d H:i:s';

    $CI =& get_instance();

    if (!in_array('calendar_lang.php', $CI->lang->is_loaded, TRUE))
    {
        $CI->lang->load('calendar');
    }

    $ret = date($format, $strdate);

    if ($lang = _x('cal_'.strtolower($ret)))
    {
        $ret = $lang;
    }
    else if (strpos($ret, ' ') !== FALSE)
    {
        $langs = array();

        foreach (explode(' ', $ret) as $ted)
        {
            if ($lang = _x('cal_'.strtolower($ted)))
            {
                $langs[] = $lang;
            }
            else
            {
                $langs[] = $ted;;
            }
        }

        $ret = implode(' ', $langs);
    }

    return $ret;
}

// -----------------------------------------------------------------------------

function baka_get_umur($lahir, $sampai = '')
{
    $tgllahir = strtotime($lahir);
    $sekarang = ($sampai == '') ? time() : strtotime($sampai) ;

    $umur = ($tgllahir < 0) ? ($sekarang + ($tgllahir * -1)) : $sekarang - $tgllahir; 

    $tahun = 60 * 60 * 24 * 365;

    $tahunlahir = $umur / $tahun;

    return floor($tahunlahir);
}

// -----------------------------------------------------------------------------

function second_to_day($second)
{
    return $second / 60 / 60 / 24;
}

// -----------------------------------------------------------------------------

function get_month_assoc()
{
    $CI =& get_instance();

    if (!in_array('calendar_lang.php', $CI->lang->is_loaded, TRUE))
    {
        $CI->lang->load('calendar');
    }
    
    $output = array();

    for ($i=1; $i<=12; $i++)
    {
        $month = date('F', mktime(0, 0, 0, $i, 1));
        $output[$i] = _x('cal_'.strtolower($month));
    }

    return $output;
}

// -----------------------------------------------------------------------------

function get_year_assoc($interfal = 10)
{
    $output = array();

    for ($i=0; $i<=$interfal; $i++)
    {
        $year = $i === 0 ? date('Y') : date('Y', mktime(0, 0, 0, $i, 1, date('Y')-$i));
        $output[$year] = $year;
    }

    return $output;
}

// -----------------------------------------------------------------------------

/**
 * Conver Numeric into Roman characters
 * @link    http://nerdspace.co/131
 *
 * @param   int     $num  Numeric Caracter
 *
 * @return  string
 */
function format_roman($num)
{
    $n = intval($num);
    $res = '';
  
    // roman_numerals array
    $romans = array(
        'M'  => 1000,
        'CM' => 900,
        'D'  => 500,
        'CD' => 400,
        'C'  => 100,
        'XC' => 90,
        'L'  => 50,
        'XL' => 40,
        'X'  => 10,
        'IX' => 9,
        'V'  => 5,
        'IV' => 4,
        'I'  => 1);
  
    foreach ($romans as $roman => $number)
    {
        // divide to get  matches
        $matches = intval($n / $number);
  
        // assign the roman char * $matches
        $res .= str_repeat($roman, $matches);
  
        // substract from the number
        $n = $n % $number;
    }
  
    // return the res
    return $res;
}

// -----------------------------------------------------------------------------

function make_tag($texts, $limit = 10)
{
    $out = '';
    $i   = 0;

    foreach (explode(',', trim($texts)) as $text)
    {
        $out .= twb_label(trim($text), 'info').' ';

        if (++$i == $limit) break;
    }

    return $out;
}

// -----------------------------------------------------------------------------

/**
 * CI default get spesific config item with 'baka_' prefix
 *
 * @param   string  $name  Config name
 *
 * @return  mixed
 */
function get_conf($name)
{
    return config_item('baka_'.$name);
}

// -----------------------------------------------------------------------------

/**
 * Get file extension from path
 *
 * @param   string  $path  Full file path
 * @return  string
 */
function get_ext($path)
{
    return pathinfo($path, PATHINFO_EXTENSION);
}


if (!function_exists('is_cli'))
{
    function is_cli()
    {
        return php_sapi_name() === 'cli' OR defined('STDIN');
    }
}

/* End of file common_helper.php */
/* Location: ./application/helpers/baka_pack/common_helper.php */