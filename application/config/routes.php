<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = "login";
$route['404_override'] = 'login/error';


/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';

/*********** ADMIN CONTROLLER ROUTES *******************/
$route['noaccess'] = 'login/noaccess';
$route['userListing'] = 'admin/userListing';
$route['userListing/(:num)'] = "admin/userListing/$1";
$route['addNew'] = "admin/addNew";
$route['addNewUser'] = "admin/addNewUser";
$route['editOld'] = "admin/editOld";
$route['editOld/(:num)'] = "admin/editOld/$1";
$route['editUser'] = "admin/editUser";
$route['deleteUser'] = "admin/deleteUser";
$route['addbonus'] = "admin/addBonus";
$route['deleteBonus'] = "admin/deleteBonus";
$route['editBonus/(:num)'] = "admin/editBonus/$1";
$route['editBonus'] = "admin/editBonus";
$route['log-history-backup'] = "admin/logHistoryBackup";
$route['log-history/(:num)'] = "admin/logHistorysingle/$1";
$route['log-history/(:num)/(:num)'] = "admin/logHistorysingle/$1/$2";
$route['user-bonus/(:num)'] = "admin/userBonus/$1";
$route['backupLogTable'] = "admin/backupLogTable";
$route['backupLogTableDelete'] = "admin/backupLogTableDelete";
$route['log-history-upload'] = "admin/logHistoryUpload";
$route['logHistoryUploadFile'] = "admin/logHistoryUploadFile";
$route['getBrowseData'] = "admin/getBrowseData";
$route['dailylogs'] = "admin/dailylogs";

/*********** MANAGER CONTROLLER ROUTES *******************/
$route['addNewTask'] = "manager/addNewTask";
$route['addNewTasks'] = "manager/addNewTasks";
$route['editOldTask/(:num)'] = "manager/editOldTask/$1";
$route['editTask'] = "manager/editTask";
$route['deleteTask/(:num)'] = "manager/deleteTask/$1";
$route['deleteFile'] = "manager/deleteFile";
$route['Bendingtasks'] = "manager/Bendingtasks";

/*********** CLIENT CONTROLLER ROUTES *******************/
$route['addClientTask'] = "Client/addClientTask";

/*********** USER CONTROLLER ROUTES *******************/
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['checkUsernameExists'] = "user/checkUsernameExists";
$route['endTask/(:num)'] = "user/endTask/$1";
$route['showTask/(:num)'] = "user/showTask/$1";
$route['tasks'] = "user/tasks";
$route['groupTasks/(:any)'] = "user/grouptasks/$1";
$route['finishedtasks'] = "user/finishedtasks";
$route['userStars'] = "user/userStars";
$route['showBonus/(:num)'] = "user/showBonus/$1";
$route['userEdit'] = "user/loadUserEdit";
$route['updateUser'] = "user/updateUser";


$route['log-history'] = "user/logHistory";
$route['general'] = "user/general";
$route['logs'] = "user/logs";
$route['total'] = "user/total";
$route['employee_list'] = "user/employee_list";
$route['getMonthHours'] = "user/getMonthHours";

/*********** LOGIN CONTROLLER ROUTES *******************/
$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";

/* End of file routes.php */
/* Location: ./application/config/routes.php */