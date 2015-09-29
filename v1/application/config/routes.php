<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// 
// Estas rutas se agregaron para la API REST por EVJ
// 

$route["viajes"]["get"] = "viajes/index";
$route["viajes/(:num)"]["get"] = "viajes/find/$1";
$route["viajes"]["post"] = "viajes/index";
$route["viajes/(:num)"]["put"] = "viajes/index/$1";
$route["viajes/(:num)"]["delete"] = "viajes/index/$1";

$route["taxistas"]["get"] = "taxistas/index";
$route["taxistas/(:num)"]["get"] = "taxistas/find/$1";
$route["taxistas/(:any)/(:any)/(:any)"]["get"] = "taxistas/find/$1/$2/$3";
$route["taxistas/(:any)/(:any)/(:any)/(:any)"]["get"] = "taxistas/find/$1/$2/$3/$4";
$route["taxistas"]["post"] = "taxistas/index";
$route["taxistas/(:num)"]["put"] = "taxistas/index/$1";
$route["taxistas/(:num)"]["delete"] = "taxistas/index/$1";

//-----Rutas para la API de evaluaciones por CHV------//
$route["comentarios"]["get"] = "comentarios/index";
$route["comentarios/(:num)"]["get"] = "comentarios/find/$1";
$route["comentarios"]["post"] = "comentarios/index";
$route["comentarios/(:num)"]["put"] = "comentarios/index/$1";
$route["comentarios/(:num)"]["delete"] = "comentarios/index/$1";

//-----Rutas para la API de evaluaciones por GAA------//
$route["evaluaciones"]["get"] = "evaluaciones/index";
$route["evaluaciones/(:any)"]["get"] = "evaluaciones/find/$1";
$route["evaluaciones/(:any)/(:any)"]["get"] = "evaluaciones/find/$1/$2";
$route["evaluaciones/(:any)/(:any)/(:any)"]["get"] = "evaluaciones/find/$1/$2/$3";
$route["evaluaciones"]["post"] = "evaluaciones/index";
$route["evaluaciones/(:num)"]["put"] = "evaluaciones/index/$1";
$route["evaluaciones/(:num)"]["delete"] = "evaluaciones/index/$1";