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
$route['default_controller'] = 'home/index';
$route['404_override'] = 'notfound';
$route['translate_uri_dashes'] = FALSE;

$route['publisher_user/login'] = 'publisheruser/login';
$route['publisher_user/register'] = 'publisheruser/register';
$route['publisher_user/get_user_list'] = 'publisheruser/getUserList';
$route['publisher_user/get_user'] = 'publisheruser/getUser';
$route['publisher_job/publish'] = 'publisherjob/publish';
$route['publisher_job/get_job_list'] = 'publisherjob/getList';
$route['publisher_flow/get_list'] = 'publisherflow/getList';

$route['admin/get_admin_job_config'] = 'adminjobconfig/getAdminJobConfig';
$route['admin/set_admin_job_config'] = 'adminjobconfig/setAdminJobConfig';
$route['admin/get_admin_user_list'] = 'adminuser/getAdminUserList';
$route['admin/get_publisher_user_list'] = 'adminuser/getPublisherUserList';
$route['admin/get_brusher_user_list'] = 'adminuser/getBrusherUserList';
$route['admin/get_publisher_job_list'] = 'adminjob/getPublisherJobList';
$route['admin/get_brusher_job_list'] = 'adminjob/getBrusherJobList';
$route['admin/login'] = 'adminuser/login';
$route['admin/register'] = 'adminuser/register';

$route['brusher_user/login'] = 'brusheruser/login';
$route['brusher_user/register'] = 'brusheruser/register';
$route['brusher_user/get_user_list'] = 'brusheruser/getUserList';
$route['brusher_user/set_pay_acount'] = 'brusheruser/setPayAcount';
$route['brusher_user/get_pay_acount'] = 'brusheruser/getPayAcount';
$route['brusher_user/get_user'] = 'brusheruser/getUser';
$route['brusher_job/get_list'] = 'brusherjob/getList';
$route['brusher_job/get_recive_list'] = 'brusherjob/getReciveList';
$route['brusher_job/recive'] = 'brusherjob/recive';