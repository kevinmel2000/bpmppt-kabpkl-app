<?php

/*
 *---------------------------------------------------------------
 * OVERRIDE FUNCTIONS
 *---------------------------------------------------------------
 *
 * This will "override" later functions meant to be defined
 * in core\Common.php, so they throw erros instead of output strings
 */
 
function show_error($message, $status_code = 500, $heading = 'An Error Was Encountereds')
{
	throw new PHPUnit_Framework_Exception($message, $status_code);
}

function show_404($page = '', $log_error = TRUE)
{
	throw new PHPUnit_Framework_Exception($page, 404);
}

function log_message($level = 'debug', $message, $php_error = FALSE)
{
	$status_code = 200;

	if ($level == 'error')
		$status_code = 500;

	throw new PHPUnit_Framework_Exception($message, $status_code);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP
 *---------------------------------------------------------------
 *
 * Bootstrap CodeIgniter from index.php as usual
 */
 
require_once dirname(__FILE__) . '/../index.php';