<?php

/*
 *---------------------------------------------------------------
 * OVERRIDE FUNCTIONS
 *---------------------------------------------------------------
 *
 * This will "override" later functions meant to be defined
 * in core\Common.php, so they throw erros instead of output strings
 */

$dir = realpath(dirname(__FILE__).'/../').'/';

define('PROJECT_DIR', $dir);
 
function show_error($message, $status_code = 500, $heading = 'An Error Was Encountereds')
{
	throw new PHPUnit_Framework_Exception('CI Error: '.$heading.' -> '.$message, $status_code);
}

function show_404($page = '', $log_error = TRUE)
{
	throw new PHPUnit_Framework_Exception('CI Error: 404 Page '.$page.' not found.', 500);
}

function log_message($level, $message)
{
	return TRUE;
}

function set_status_header($code = 200, $text = '')
{
	return TRUE;
}

function redirect($uri = '', $method = 'location', $http_response_code = 302)
{
	if ( ! preg_match('#^https?://#i', $uri))
	{
		$uri = site_url($uri);
	}

	echo "Redirected to $uri\n";
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP
 *---------------------------------------------------------------
 *
 * Bootstrap CodeIgniter from index.php as usual
 */
 
require_once $dir.'index.php';
