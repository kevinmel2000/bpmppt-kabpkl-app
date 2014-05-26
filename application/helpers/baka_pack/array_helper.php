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
 * @subpackage  Array
 * @category    Helper
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

class bakaObject extends stdClass {}

// -----------------------------------------------------------------------------

function print_pre($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

// -----------------------------------------------------------------------------

/**
 * Converting an array into object
 * 
 * @param  array  $array array source
 * @return object
 */
function array_to_object( array $array )
{
    $obj = new bakaObject;

    foreach ( $array as $modul => $prop )
    {
        $obj->$modul = ( is_array( $prop ) ? array_to_object( $prop ) : $prop );
    }

    return $obj;
}

// -----------------------------------------------------------------------------

/**
 * Update array value by array key
 * 
 * @param  array
 * @param  array
 * @return array
 */
function array_edit_val( array $array1, array $array2 )
{
    $array = array();

    foreach ( $array1 as $key => $val)
    {
        $array[$key] = $val;

        if ( isset($array2[$key]) AND $array[$key] != $array2[$key] )
        {
            $array[$key] = $array2[$key];
        }
    }

    return $array;
}

// -----------------------------------------------------------------------------

// Some array helper
function baka_get_value_from_key( $value , $array )
{
    if ( isset( $array[$value] ) )
    {
        return $array[$value];
    }
}

// -----------------------------------------------------------------------------

function baka_array_search ( $needle, $haystack )
{
    foreach ( $haystack as $key => $value )
    {
        $current_key = $key;

        if (is_array($value))
        {
            $value = baka_array_search ( $needle, $value );
        }
        else
        {
            if ($needle === $value OR ($value != FALSE AND $value != NULL))
            {
                if ($value == NULL)
                    return array($current_key);
                
                return array_merge(array($current_key), $value);
            }
        }
    }

    return FALSE;
}

// -----------------------------------------------------------------------------

function array_insert_after_node( $array, $after_key, $index, $value)
{
    $result = array();
    $keys   = array_keys($array);

    if (in_array($after_key, $keys) === FALSE)
        return FALSE;

    foreach ($array as $id => $item)
    {
        $result[$id] = $item;

        if ($id === $after_key)
            $result[$index] = $value;
    }

    return $result;
}

// -------------------------------------------------------------------------

/**
 * Set default keys in an array, it's useful to prevent un setup array keys
 * but you'd use that in next code.
 *
 * @param   array  $field       An array that will recieve default key
 * @param   array  $defaults    Array of keys which be default key of $field
 *                              Array must be associative array, which have
 *                              key and value. Key used as default key and
 *                              Value used as default value for $field param
 *
 * @return  array
 */
function array_set_defaults(array $array,array $defaults)
{
    foreach ($defaults as $key => $val)
    {
        if (!array_key_exists($key, $array) AND !isset($array[$key]))
        {
            $array[$key] = $val;
        }
    }

    return $array;
}

/* End of file assets_helper.php */
/* Location: ./application/helpers/baka_pack/assets_helper.php */