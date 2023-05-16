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
$route['default_controller'] = 'Administrator';
$route['dashboard'] = 'administrator/dashboard';

$route['admin_roles'] = 'administrator/admin_roles';
$route['admin_modules'] = 'administrator/admin_modules';
$route['admin_users'] = 'administrator/admin_users';
$route['permissions'] = 'administrator/manage_permissions';

$route['master_transit_partners'] = 'administrator/master_transit_partners';
$route['awb_generation'] = 'administrator/awb_generation';

$route['master_cod_cycle'] = 'administrator/master_cod_cycle';
$route['master_billing_cycle'] = 'administrator/master_billing_cycle';
$route['master_pincodes'] = 'administrator/master_pincodes';
$route['master_pinservices'] = 'administrator/master_pinservices';
$route['master_weightslab'] = 'administrator/master_weightslab';
$route['master_zones'] = 'administrator/master_zones';

$route['users_registration'] = 'administrator/users_registration';
$route['modifyuser'] = 'administrator/users_update';
$route['users'] = 'administrator/users_manage';
$route['complete_registration'] = 'administrator/complete_registration';
$route['users_ratechart'] = 'administrator/users_ratechart';
$route['users_courierpriority'] = 'administrator/users_courierpriority';
$route['users_weightslab'] = 'administrator/users_weightslab';

$route['change_status'] = 'administrator/change_status';
$route['weight_update'] = 'administrator/weight_update';
$route['generate_invoice'] = 'administrator/generate_invoice';
$route['invoice'] = 'administrator/invoice';
$route['view_invoice'] = 'administrator/view_invoice';
$route['add_payment'] = 'administrator/add_payment';
$route['generate_cod'] = 'administrator/generate_cod';
$route['view_cods'] = 'administrator/view_cods';
$route['update_tracking'] = 'administrator/update_tracking';

$route['manage_balance'] = 'administrator/add_balance';
$route['user_addresses'] = 'administrator/view_addresses';
$route['sellers'] = 'administrator/users_seller';
$route['self_registration'] = 'administrator/users_self_registration';

$route['unauthorised'] = 'administrator/unauthorised';

$route['manual_invoice'] = 'administrator/manual_invoice';

$route['user_weight_request'] = 'administrator/update_weight_request';
$route['users_modules'] = 'administrator/users_module';

$route['default_weightslab'] = 'administrator/default_weightslab';
$route['default_ratechart'] = 'administrator/default_ratechart';
$route['default_courier'] = 'administrator/default_courier_priority';

$route['users_agreement'] = 'administrator/users_agreement';
$route['portal'] = 'administrator/portal_settings';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
