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
$route['addUserLog'] = "admin/addUserLog";
$route['maintainUsersLogs'] = "admin/maintainUsersLogs";
$route['usersLogs'] = "admin/usersLogs";
$route['deleteLogRecord'] = "admin/deleteLogRecord";

/*********** MANAGER CONTROLLER ROUTES *******************/
$route['addNewTask'] = "manager/addNewTask";
$route['addNewTasks'] = "manager/addNewTasks";
$route['editOldTask/(:num)'] = "manager/editOldTask/$1";
$route['editTask'] = "manager/editTask";
$route['deleteFile'] = "manager/deleteFile";
$route['Bendingtasks'] = "manager/Bendingtasks";
$route['deleteTask'] = "manager/deleteTask";
$route['confirmTask'] = "manager/confirmTask";

/*********** CLIENT CONTROLLER ROUTES *******************/
$route['clientBendingTasks'] = "Client/clientBendingTasks";
$route['clientOpenedTasks'] = "Client/clientOpenedTasks";
$route['clientFinishedTasks'] = "Client/clientFinishedTasks";

/*********** USER CONTROLLER ROUTES *******************/
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['checkUsernameExists'] = "user/checkUsernameExists";
$route['endTask'] = "user/endTask";
$route['saveStage'] = "user/saveStage";
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
$route['todo'] = "user/todo";
$route['editTodo'] = "user/editTodo";
$route['addTodo'] = "user/addTodo";
$route['finishTodo'] = "user/finishTodo";
$route['deleteTodo'] = "user/deleteTodo";
$route['UserslogHistory'] = "user/UserslogHistory";
$route['logs'] = "user/logs";
$route['total'] = "user/total";
$route['getMonthHours'] = "user/getMonthHours";
$route['getUserMonthHours'] = "user/getUserMonthHours";
$route['profile'] = "user/profile";
$route['editProfile'] = "user/editProfile";

/*********** LOGIN CONTROLLER ROUTES *******************/
$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";

/* End of file routes.php */
/* Location: ./application/config/routes.php */