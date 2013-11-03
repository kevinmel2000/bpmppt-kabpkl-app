<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller']	= "data/utama/stat";

// Overiding 404 page not found
$route['404_override']	= 'error/notice/404';

// Dashboard route
$route['dashboard']		= "data/utama/stat";
// login route
$route['login']			= "auth/login";
// logout route
$route['logout']		= "auth/logout";
// register route
$route['register']		= "auth/register";
// resend route
$route['resend']		= "auth/resend";
// activate route
$route['activate']		= "auth/activate";
// forgot route
$route['forgot']		= "auth/forgot";
// notice route
$route['notice/(:any)']	= "error/notice/$1";
// Profile route
$route['profile']		= "admin/pengguna/profile";


/* End of file routes.php */
/* Location: ./application/config/routes.php */