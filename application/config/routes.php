<?php

defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
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

// $route['default_controller'] = 'Pages';
// $route['404_override'] = 'Pages/error404';
// $route['translate_uri_dashes'] = FALSE;

// // Authentikasi
// $route['auth/verifylogin'] = 'Auth/verifyLogin';
// $route['auth/verifylogout'] = 'Auth/verifyLogout';

// //
// $route['status/uptime'] = 'CheckStatus/uptime';
// $route['status/health'] = 'CheckStatus/health';
// $route['profile/reset'] = 'Profile/resetPassword';
// $route['profile/update'] = 'Profile/updatePasswordUser';

// // 
// $route['home'] = 'Home';
// $route['about'] = 'Home/about';

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Public routes
$route['home'] = 'home/index';
$route['about'] = 'home/about';

// Auth routes
$route['auth'] = 'AuthController/login';
$route['login'] = 'AuthController/login';
$route['auth/login'] = 'AuthController/login';
$route['auth/do-login'] = 'AuthController/do_login';
$route['auth/logout'] = 'AuthController/logout';
$route['auth/register'] = 'AuthController/register';
$route['auth/do-register'] = 'AuthController/do_register';
$route['auth/forgot-password'] = 'AuthController/forgot_password';
$route['auth/change-password'] = 'AuthController/change_password';
$route['auth/do-change-password'] = 'AuthController/do_change_password';

// Dashboard routes
$route['dashboard'] = 'DashboardController/index';
$route['dashboard/analytics'] = 'DashboardController/analytics';
$route['dashboard/system-info'] = 'DashboardController/system_info';

// User management routes
$route['users'] = 'UserController/index';
$route['users/view/(:num)'] = 'UserController/view/$1';
$route['users/create'] = 'UserController/create';
$route['users/store'] = 'UserController/create';
$route['users/edit/(:num)'] = 'UserController/edit/$1';
$route['users/update/(:num)'] = 'UserController/edit/$1';
$route['users/delete/(:num)'] = 'UserController/delete/$1';
$route['users/toggle-lock/(:num)'] = 'UserController/toggle_lock/$1';

// Page management routes
$route['pages'] = 'PageController/index';
$route['pages/view/(:num)'] = 'PageController/view/$1';
$route['pages/create'] = 'PageController/create';
$route['pages/store'] = 'PageController/create';
$route['pages/edit/(:num)'] = 'PageController/edit/$1';
$route['pages/update/(:num)'] = 'PageController/edit/$1';
$route['pages/delete/(:num)'] = 'PageController/delete/$1';
$route['pages/publish/(:num)'] = 'PageController/publish/$1';
$route['pages/unpublish/(:num)'] = 'PageController/unpublish/$1';
$route['pages/builder/(:num)'] = 'PageController/builder/$1';
$route['pages/preview/(:num)'] = 'PageController/preview/$1';

// Page Builder AJAX routes
$route['pages/add-section/(:num)'] = 'PageController/add_section/$1';
$route['pages/save-section/(:num)'] = 'PageController/save_section/$1';
$route['pages/delete-section/(:num)'] = 'PageController/delete_section/$1';
$route['pages/reorder-sections/(:num)'] = 'PageController/reorder_sections/$1';
$route['pages/get-section-form/(:num)'] = 'PageController/get_section_form/$1';

// Media management routes
$route['media'] = 'MediaController/index';
$route['media/upload'] = 'MediaController/upload';
$route['media/delete/(:num)'] = 'MediaController/delete/$1';
$route['media/get/(:num)'] = 'MediaController/get/$1';

// Role management routes
$route['roles'] = 'RoleController/index';
$route['roles/create'] = 'RoleController/create';
$route['roles/store'] = 'RoleController/store';
$route['roles/edit/(:num)'] = 'RoleController/edit/$1';
$route['roles/update/(:num)'] = 'RoleController/update/$1';
$route['roles/delete/(:num)'] = 'RoleController/delete/$1';
$route['roles/permissions/(:num)'] = 'RoleController/permissions/$1';
$route['roles/update-permissions/(:num)'] = 'RoleController/update_permissions/$1';

// Permission management routes
$route['permissions'] = 'PermissionController/index';
$route['permissions/create'] = 'PermissionController/create';
$route['permissions/store'] = 'PermissionController/store';
$route['permissions/edit/(:num)'] = 'PermissionController/edit/$1';
$route['permissions/update/(:num)'] = 'PermissionController/update/$1';
$route['permissions/delete/(:num)'] = 'PermissionController/delete/$1';

// Menu management routes
$route['menus'] = 'MenuController/index';
$route['menus/create'] = 'MenuController/create';
$route['menus/store'] = 'MenuController/store';
$route['menus/edit/(:num)'] = 'MenuController/edit/$1';
$route['menus/update/(:num)'] = 'MenuController/update/$1';
$route['menus/delete/(:num)'] = 'MenuController/delete/$1';
$route['menus/items/(:num)'] = 'MenuController/items/$1';
$route['menus/add-item/(:num)'] = 'MenuController/add_item/$1';
$route['menus/store-item/(:num)'] = 'MenuController/store_item/$1';
$route['menus/delete-item/(:num)/(:num)'] = 'MenuController/delete_item/$1/$2';
$route['menus/preview/(:num)'] = 'MenuController/preview/$1';

// Log routes
$route['logs'] = 'LogController/index';

// Settings routes
$route['settings'] = 'SettingController/index';
$route['settings/update'] = 'SettingController/update';

// Public page routes (must be at the end)
$route['page/(:any)'] = 'Home/page/$1';


