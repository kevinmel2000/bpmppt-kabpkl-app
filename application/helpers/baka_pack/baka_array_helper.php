<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function print_pre($array)
{
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

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
			$array[$key] = $array2[$key];
	}

	return $array;
}

// Some array helper
function baka_get_value_from_key( $value , $array )
{
	if ( isset( $array[$value] ) ) { return $array[$value]; }
}

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

function array_insert_after_node( $array, $after_key, $index, $value)
{
	$result	= array();
	$keys	= array_keys($array);

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