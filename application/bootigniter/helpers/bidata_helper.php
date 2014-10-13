<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package     @PACKAGE
 * @author      @AUTHOR
 * @copyright   Copyright (c) @COPYRIGHT
 * @license     @LICENSE
 * @subpackage  Bidata
 * @category    Data Helpers
 */

// -----------------------------------------------------------------------------

function return_bytes( $val )
{
    if (!is_string($val))
    {
        return FALSE;
    }

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

function format_size( $size )
{
    $sizes = Array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');
    $y     = $sizes[0];

    for ($i = 1; (($i < count($sizes)) && ($size >= 1024)); $i++)
    {
        $size = $size / 1024;
        $y    = $sizes[$i];
    }

    return round($size, 2).' <span class="muted">'.$y.'</span>';
}

// -----------------------------------------------------------------------------

/**
 * Conver Numeric into Roman characters
 * @link    http://nerdspace.co/131
 *
 * @param   int     $num  Numeric Caracter
 * @return  string
 */
function format_roman( $num )
{
    $n   = intval( $num );
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
        'I'  => 1
        );

    foreach ( $romans as $roman => $number )
    {
        // divide to get  matches
        $matches = intval( $n / $number );
        // assign the roman char * $matches
        $res .= str_repeat( $roman, $matches );
        // substract from the number
        $n = $n % $number;
    }

    // return the res
    return $res;
}

// -----------------------------------------------------------------------------
// Date and Time helper
// -----------------------------------------------------------------------------

function format_date( $string = '' )
{
    return bdate(Bootigniter::get_setting('app_date_format'), $string);
}

// -----------------------------------------------------------------------------

function format_datetime( $string = '' )
{
    return bdate(Bootigniter::get_setting('app_datetime_format'), $string);
}

// -----------------------------------------------------------------------------

function format_time( $string = '' )
{
    return bdate('%H:%i:%s', $string);
}

// -----------------------------------------------------------------------------

function string_to_date( $string = '' )
{
    return bdate('%Y-%m-%d', $string);
}

// -----------------------------------------------------------------------------

function string_to_datetime( $string = '' )
{
    return bdate('%Y-%m-%d %H:%i:%s', $string);
}

// -----------------------------------------------------------------------------

function bdate( $format = '', $strdate = '' )
{
    if ( in_array( $strdate, array( '0000-00-00 00:00:00', '0000-00-00' ) ) )
    {
        return '-';
    }

    $format || $format = '%Y-%m-%d %H:%i:%s';
    $strdate = !empty($strdate) ? strtotime($strdate) : '';
    $formats = preg_split('/(%\w+|\s+)/i', $format, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    $localizes = array( '%D', '%l', '%F', '%M' );
    $dates = array();
    $CI =& get_instance();

    if ( !in_array( 'calendar_lang.php', $CI->lang->is_loaded, TRUE ) )
    {
        $CI->lang->load('calendar');
    }

    foreach ( $formats as $d_code )
    {
        if ( strpos( $d_code, '%' ) === 0 )
        {
            if ( in_array( $d_code, $localizes ) )
            {
                $dates[] = _x( 'cal_'.strtolower( mdate( $d_code, $strdate ) ) );
            }
            else
            {
                $dates[] = mdate( $d_code, $strdate );
            }
        }
        else
        {
            $dates[] = $d_code;
        }
    }

    return implode( '', $dates );
}

// -----------------------------------------------------------------------------

function get_date_interval( $from, $until = '' )
{
    $tgllahir = strtotime($from);
    $sekarang = ($until == '') ? time() : strtotime($until) ;

    $umur = ($tgllahir < 0) ? ($sekarang + ($tgllahir * -1)) : $sekarang - $tgllahir;

    $tahun = 60 * 60 * 24 * 365;

    $tahunlahir = $umur / $tahun;

    return floor($tahunlahir);
}

// -----------------------------------------------------------------------------

/**
 * Convert second to day
 *
 * @param   int  $second  Second value
 * @return  int
 */
function second_to_day( $second )
{
    return $second / 60 / 60 / 24;
}

// -----------------------------------------------------------------------------

/**
 * Get months list in associative array
 *
 * @return  array
 */
function get_month_assoc()
{
    $CI =& get_instance();

    if (!in_array('calendar_lang.php', $CI->lang->is_loaded, TRUE))
    {
        $CI->lang->load('calendar');
    }

    $output = array();

    for ( $i = 1; $i <= 12; $i++)
    {
        $month = date('F', mktime(0, 0, 0, $i, 1));
        $output[$i] = _x('cal_'.strtolower($month));
    }

    return $output;
}

// -----------------------------------------------------------------------------

/**
 * Get year list in associative array
 *
 * @param   int     $interfal  Year interval from now
 * @return  array
 */
function get_year_assoc( $interfal = 10 )
{
    $output = array();

    for ( $i = 0; $i <= $interfal; $i++)
    {
        $year = $i === 0 ? date('Y') : date('Y', mktime(0, 0, 0, $i, 1, date('Y')-$i));
        $output[$year] = $year;
    }

    return $output;
}

/* End of file bidata_helper.php */
/* Location: ./bootigniter/helpers/bidata_helper.php */
