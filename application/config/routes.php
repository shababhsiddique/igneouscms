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

$route['default_controller'] = "home"; 
$route[''] = "home/index"; 
$route['admin'] = "admin/dashboard"; 

/**
 * Admin routes 
 */

/**
 * Common DataTable View Control 
 */
$route['admin/dashboard/(:any)_view'] = "admin/dashboard/entity_view/$1"; 
$route['admin/dashboard/(:any)_view/(:any)'] = "admin/dashboard/entity_view/$1/$2"; 

/**
 * Common formFactory view control 
 */
$route['admin/dashboard/(:any)_auth'] = "admin/dashboard/entity_auth/$1"; 
$route['admin/dashboard/(:any)_auth/(:any)'] = "admin/dashboard/entity_auth/$1/$2"; 




/**
 * Prettify URL
 */
$route['subscribe'] = "home/subscribe"; 
$route['blog'] = "home/blog"; 
$route['blog/(:any)'] = "home/blog/$1"; 
$route['contact'] = "home/contact"; 
$route['gallery'] = "home/gallery"; 
$route['portfolio'] = 'home/portfolio';
$route['portfolio/(:any)'] = 'home/portfolio/$1';
$route['index'] = "home/index"; 
$route['page/(:any)'] = 'home/page/$1';
$route['article/(:any)'] = 'home/article/$1';
$route['articles/(:any)'] = 'home/articles/$1';


/**
 * Remove unnecessary "index" from url
 */

$route['404_override'] = 'page/err'; 


/* End of file routes.php */
/* Location: ./application/config/routes.php */