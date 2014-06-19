<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package     Baka Igniter Pack
 * @subpackage  Array
 * @category    Helper
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. <ferywardiyanto@gmail.com>
 * @license     http://dbad-license.org
 * @since       Version 0.1.3
 */

// -----------------------------------------------------------------------------

/**
 * Converting an array into object
 * 
 * @param  array  $array array source
 * @return object
 */
function array_to_object( array $array )
{
    $obj = new stdClass;

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
                {
                    return array($current_key);
                }
                
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
    {
        return FALSE;
    }

    foreach ($array as $id => $item)
    {
        $result[$id] = $item;

        if ($id === $after_key)
        {
            $result[$index] = $value;
        }
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
/* Location: ./application/third_party/bakaigniter/helpers/assets_helper.php */