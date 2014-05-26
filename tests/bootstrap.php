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
	throw new PHPUnit_Framework_Exception('CI Error: '.$heading.' -> '.$message, $status_code);
}

function show_404($page = '', $log_error = TRUE)
{
	throw new PHPUnit_Framework_Exception('CI Error: 404 Page '.$page.' not found.', 500);
}

function log_message($level, $message)
{
	return;
}

function set_status_header($code = 200, $text = '')
{
	return;
}

/**
 * -----------------------------------------------------------------------------
 * Just simplify your path declaration
 * -----------------------------------------------------------------------------
 */
$dir = realpath(dirname(__FILE__).'/../').'/';

/**
 * -----------------------------------------------------------------------------
 * Somehow you'll need to use this constant instead of using phpunit constant.
 * Just remove or comment it if you didn't. ;)
 * -----------------------------------------------------------------------------
 */
define('PROJECT_DIR', $dir);

/**
 * -----------------------------------------------------------------------------
 * In case you have some issues with CI Uri Helper and maybe your own Core
 * Controller. Maybe You have and authentication library that called from your
 * Core Controller and it will redirecting to your Login page when you're not
 * logged in yet, or some thing. So, you'll need to override this too.
 * 
 * @link  https://travis-ci.org/feryardiant/codeigniter-phpunit/builds/25091919#L69
 * 
 * So, You need to override this function too and see:
 *
 * @link  https://travis-ci.org/feryardiant/codeigniter-phpunit/builds/25093192#L69
 * -----------------------------------------------------------------------------
 */
function redirect($uri = '', $method = 'location', $http_response_code = 302)
{
	return;
}

/**
 * -----------------------------------------------------------------------------
 * I assumed you use composer as your dependency manager, so you need to load
 * this file too.
 * -----------------------------------------------------------------------------
 */
if (file_exists(PROJECT_DIR . 'vendor/autoload.php'))
{
	require_once PROJECT_DIR . 'vendor/autoload.php';
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP
 *---------------------------------------------------------------
 *
 * Bootstrap CodeIgniter from index.php as usual
 */
 
require_once $dir.'index.php';
