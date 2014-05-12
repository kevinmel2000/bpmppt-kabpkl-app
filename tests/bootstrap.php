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
	throw new PHPUnit_Framework_Exception('CI Error: '.$message, 500);
}

function show_404($page = '', $log_error = TRUE)
{
	throw new PHPUnit_Framework_Exception('CI Error: 404', 500);
}

function _exception_handler($severity, $message, $filepath, $line)
{
	$filepath = str_replace(PROJECT_DIR, '', $filepath);

	throw new PHPUnit_Framework_Exception('CI Exception: '.$message.' | '.$filepath.' | '.$line, 500);
}

function log_message($level, $message)
{
	return TRUE;
}

function set_status_header($code = 200, $text = '')
{
	return TRUE;
}
/*
 *---------------------------------------------------------------
 * BOOTSTRAP
 *---------------------------------------------------------------
 *
 * Bootstrap CodeIgniter from index.php as usual
 */

if (file_exists($dir.'vendor/autoload.php'))
{
	require_once $dir.'vendor/autoload.php';
}
 
require_once $dir.'index.php';
