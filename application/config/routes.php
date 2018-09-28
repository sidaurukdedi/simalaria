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
|	https://codeigniter.com/user_guide/general/routing.html
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
//$route['default_controller'] = 'welcome';
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


// Employee Paging
$route['employee/pages'] = "employee/index";
$route['employee/pages/(:num)'] = "employee/index/$1";

// Department Paging
$route['department/pages'] = "department/index";
$route['department/pages/(:num)'] = "department/index/$1";

// Education Paging
$route['education/pages'] = "education/index";
$route['education/pages/(:num)'] = "education/index/$1";

// Employement Paging
$route['employment/pages'] = "employment/index";
$route['employment/pages/(:num)'] = "employment/index/$1";

// User_management Paging
$route['user_management/pages'] = "user_management/index";
$route['user_management/pages/(:num)'] = "user_management/index/$1";

// Pasien Paging
$route['pasien/pages'] = "pasien/index";
$route['pasien/pages/(:num)'] = "pasien/index/$1";

// Pasienklas Paging
$route['pasienklas/pages'] = "pasienklas/index";
$route['pasienklas/pages/(:num)'] = "pasienklas/index/$1";

// Kegiatan Paging
$route['kegiatan/pages'] = "kegiatan/index";
$route['kegiatan/pages/(:num)'] = "kegiatan/index/$1";

// Obat Paging
$route['obat/pages'] = "obat/index";
$route['obat/pages/(:num)'] = "obat/index/$1";

// Vektor Paging
$route['vektor/pages'] = "vektor/index";
$route['vektor/pages/(:num)'] = "vektor/index/$1";

// Vektor Paging
$route['pemetaan/pages'] = "pemetaan/index";
$route['pemetaan/pages/(:num)'] = "pemetaan/index/$1";




$route['logout'] = "login/logout";
// Absen Paging
$route['absen/halaman'] = "absen/index";
$route['absen/halaman/(:num)'] = "absen/index/$1";