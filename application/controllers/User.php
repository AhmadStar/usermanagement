<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Ahmad Alnajim
 * @version : 1.0
 * @since : 2.10.2019
 */
class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('employee_model');
        $this->isLoggedIn();        
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Home page';
        if($this->role === ROLE_EMPLOYEE){
            $data['mytasksCount'] = $this->user_model->tasksCount($this->session->userdata('userId'));
            $data['myfinishedTasksCount'] = $this->user_model->finishedTasksCount($this->session->userdata('userId'));                        
            $data['logsCount'] = $this->user_model->logsCount($this->session->userdata('userId'));            
            $data['latestTask'] = $this->user_model->getLatestTasks($this->session->userdata('userId'));
            $data['myAllTasksCount'] = $this->user_model->myAllTasksCount($this->session->userdata('userId'));            
          }else{
            $data['logsCount'] = $this->user_model->logsCount();            
            $data['connectedUsers'] = $this->user_model->connectedUsers();
            $data['connectedUsersCount'] = $this->user_model->connectedUsersCount();
            $data['latestTask'] = $this->user_model->getLatestTasks();
            $data['usersCount'] = $this->user_model->usersCount();
          }
          $data['AllTasksCount'] = $this->user_model->AllTasksCount();
          $data['finishedTasksCount'] = $this->user_model->finishedTasksCount();          
          $data['tasksCount'] = $this->user_model->tasksCount();
          $data['BendingTasksCount'] = $this->user_model->BendingTasksCount();
          $data['userStars'] = $this->user_model->userStars($this->session->userdata('userId'));
          $data['myWorkHours'] = $this->employee_model->get_month_hours_as_sum($this->session->userdata('userId'));
          $data['AllUserWorkHours'] = $this->employee_model->get_month_hours_as_sum();

          if($this->role === ROLE_CLIENT){
            $data['ClientBendingTasksCount'] = $this->user_model->ClientTasksCount($this->session->userdata('userId') , 3);
            $data['ClientFinishedTasksCount'] = $this->user_model->ClientTasksCount($this->session->userdata('userId') , 2);
            $data['ClientOpenedTasksCount'] = $this->user_model->ClientTasksCount($this->session->userdata('userId') , 1);
          }

        if ($this->getUserStatus() == TRUE)
        {
            $this->session->set_flashdata('error', 'Please change your password first for your security.');
            redirect('changePassword');
        }

        $data['todoList'] = $this->user_model->getTodoList($this->session->userdata('userId'));

        $data['groups'] = $this->user_model->getUserGroups();

        $this->loadViews("user/dashboard", $this->global, $data , NULL);
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }

    /**
     * This function is used to check whether User Name already exist or not
     */
    function checkUsernameExists()
    {
        $userId = $this->input->post("userId");
        $fname = $this->input->post("fname");

        if(empty($userId)){
            $result = $this->user_model->checkUsernameExists($fname);
        } else {
            $result = $this->user_model->checkUsernameExists($fname, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }

    /**
     * This function is used to load edit user view
     */
    function loadUserEdit()
    {
        $this->global['pageTitle'] = 'DAS : Account settings';
        
        $data['userInfo'] = $this->user_model->getUserInfo($this->vendorId);

        $this->loadViews("user/userEdit", $this->global, $data, NULL);
    }

    /**
     * This function is used to update the of the user info
     */
    function updateUser()
    {
        $this->load->library('form_validation');
            
        $userId = $this->input->post('userId');
        
        $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('oldpassword','Old password','max_length[20]');
        $this->form_validation->set_rules('cpassword','Password','matches[cpassword2]|max_length[20]');
        $this->form_validation->set_rules('cpassword2','Confirm Password','matches[cpassword]|max_length[20]');
        $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->loadUserEdit();
        }
        else
        {
            $name = $this->security->xss_clean($this->input->post('fname'));
            $email = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('cpassword');
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $oldPassword = $this->input->post('oldpassword');
            
            $userInfo = array();

            if(empty($password))
            {
                // var_dump('empty passs');die();
                if($_FILES['picture']['tmp_name']){
                    $config['upload_path']  = 'uploads/user_profile/';
                    if(!file_exists($config['upload_path'])){
                        mkdir($config['upload_path'],0777);
                    }
                    $config['file_name']            = $userId.'_profile_picture';
                    $config['allowed_types']        = 'jpeg|jpg|png';
                    $config['overwrite']            = TRUE;                 
                    $config['max_size']             = 500;
                    $config['max_width']            = 1024;
                    $config['max_height']           = 768;
                    $this->load->library('upload', $config);
                    $this->upload->overwrite = true;
                    if ( ! $this->upload->do_upload('picture'))
                    {                            
                        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('error',$error['error']);
                        redirect('userEdit');
                    }
                    else
                    {
                        $data = array('upload_data' => $this->upload->data());
                        $filename = $data['upload_data']['file_name'];
                        
                        //Thumbnail Image Upload - Start                        
                        $source_path = $_SERVER['DOCUMENT_ROOT'].'/monitor/'.$config['upload_path'].$filename;
                        $target_path = $config['upload_path'].'thumbnail/'.$filename;                                                

                        $config_manip = array(
                            'image_library' => 'gd2',
                            'source_image' => $source_path,
                            'new_image' => $target_path,
                            'maintain_ratio' => TRUE,
                            'create_thumb' => TRUE,
                            'overwrite' => TRUE ,
                            'thumb_marker' => '',
                            'width' => 150,
                            'height' => 150,                            
                        );                        
                        
                        //load resize library
                        $this->load->library('image_lib');
                        // Set your config up
                        $this->image_lib->initialize($config_manip);

                        // $this->load->library('image_lib', $config_manip);
                        if ( ! $this->image_lib->resize()) {
                            echo $this->image_lib->display_errors();
                        }

                        $this->image_lib->clear();
                        //Thumbnail Image Upload - End
                        
                        $userInfo = array('email'=>$email,'name'=>$name,
                            'mobile'=>$mobile, 'status'=>1, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s') , 'picture' => $config['upload_path'].'thumbnail/'.$filename);                      
                    }
                }else{
                    $userInfo = array('email'=>$email,'name'=>$name,
                            'mobile'=>$mobile, 'status'=>1, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                }
            }
            else
            {
                $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
                if(empty($resultPas))
                {
                $this->session->set_flashdata('nomatch', 'Your old password is not correct');
                redirect('userEdit');
                }
                else
                {
                //upload picture
                if($_FILES['picture']['tmp_name']){
                    $config['upload_path']  = 'uploads/user_profile/';
                    if(!file_exists($config['upload_path'])){
                        mkdir($config['upload_path'],0777);
                    }
                    $config['file_name']            = $userId.'_profile_picture';
                    $config['allowed_types']        = 'jpeg|jpg|png';
                    $config['overwrite']            =TRUE;
                    $config['max_size']             = 500;
                    $config['max_width']            = 1024;
                    $config['max_height']           = 768;
                    $this->load->library('upload', $config);
                    $this->upload->overwrite = true;
                    if ( ! $this->upload->do_upload('picture'))
                    {                            
                        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('error',$error['error']);
                        redirect('userEdit');
                    }
                    else
                    {
                        $data = array('upload_data' => $this->upload->data());
                        $filename = $data['upload_data']['file_name'];
                        
                        //Thumbnail Image Upload - Start                        
                        $source_path = $_SERVER['DOCUMENT_ROOT'].'/monitor/'.$config['upload_path'].$filename;
                        $target_path = $config['upload_path'].'thumbnail/'.$filename;                                                

                        $config_manip = array(
                            'image_library' => 'gd2',
                            'source_image' => $source_path,
                            'new_image' => $target_path,
                            'maintain_ratio' => TRUE,
                            'create_thumb' => TRUE,
                            'overwrite' => TRUE ,
                            'thumb_marker' => '',
                            'width' => 150,
                            'height' => 150,                            
                        );                        
                        
                        //load resize library
                        $this->load->library('image_lib');
                        // Set your config up
                        $this->image_lib->initialize($config_manip);

                        // $this->load->library('image_lib', $config_manip);
                        if ( ! $this->image_lib->resize()) {
                            echo $this->image_lib->display_errors();
                        }
                        
                        $this->image_lib->clear();
                        //Thumbnail Image Upload - End
                        
                        $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password),
                        'name'=>ucwords($name), 'mobile'=>$mobile,'status'=>1, 'updatedBy'=>$this->vendorId, 
                        'updatedDtm'=>date('Y-m-d H:i:s') , 'picture' => $config['upload_path'].'thumbnail/'.$filename);                        
                    }
                }else{
                    $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password),
                        'name'=>ucwords($name), 'mobile'=>$mobile,'status'=>1, 'updatedBy'=>$this->vendorId, 
                        'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                }
            }
            
            $result = $this->user_model->editUser($userInfo, $userId);
            
            if($result == true)
            {
                $this->session->set_flashdata('success', 'Your Account Settings were updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Failed to update Account Settings');
            }
            
            redirect('userEdit');
        }
    }
    
    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        if($this->input->post())
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
            $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
            $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->changePassword();
            }
            else
            {
                $oldPassword = $this->input->post('oldPassword');
                $newPassword = $this->input->post('newPassword');
                
                $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
                
                if(empty($resultPas))
                {
                    $this->session->set_flashdata('nomatch', 'Your old password is not correct');
                    redirect('changePassword');
                }
                else
                {
                    $usersData = array('password'=>getHashedPassword($newPassword),'status'=>1, 'updatedBy'=>$this->vendorId,
                                    'updatedDtm'=>date('Y-m-d H:i:s'));
                    
                    $result = $this->user_model->changePassword($this->vendorId, $usersData);
                    
                    if($result > 0) {
                        $this->session->set_flashdata('success', 'Password change successful');
                        }
                    else {
                        $this->session->set_flashdata('error', 'Password change failed'); 
                        }
                    
                    redirect('changePassword');
                }
            }
        }

        $this->global['pageTitle'] = 'DAS : Change Password';        
        $this->loadViews("user/changePassword", $this->global, NULL, NULL);
    }

    /**
     * This function is used to open 404 view
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'DAS : 404 - Page Not Found';
        
        $this->loadViews("user/404", $this->global, NULL, NULL);
    }

    /**
     * This function is used to finish tasks.
     */
    function endTask()
    {

        $taskId = $this->input->post('taskId');
        $finishDetail = $this->input->post('finishDetail');

        $taskInfo = array('statusId'=>2,'endDtm'=>date('Y-m-d H:i:s') ,
                    'finish_detail' => $finishDetail , 'finished_by' => $this->session->userdata('userId'));
        
        $result = $this->user_model->endTask($taskId, $taskInfo);
        
        if ($result > 0) {
            echo(json_encode(array('status'=>TRUE)));
            }
        else {
            echo(json_encode(array('status'=>FALSE)));
        }
    }


    /**
     * This function is used to save Stage of tasks.
     */
    function saveStage()
    {
        $taskId = $this->input->post('taskId');
        $stageDetail = $this->input->post('stageDetail');

        $stageInfo = array('description' => $stageDetail ,
                           'user_id' => $this->session->userdata('userId') ,
                           'task_id' => $taskId);
        
        $result = $this->user_model->saveStage($stageInfo);
        
        if($result > 0 ){
            // Count total files
            $countfiles = count($_FILES['files']['name']);
            // Looping all files            
            for ($i = 0; $i < $countfiles; $i++) {

                if (!empty($_FILES['files']['name'][$i])) {

                    // Define new $_FILES array - $_FILES['file']                    
                    $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                    // Set preference
                    $config['upload_path']  = 'uploads/task'.$taskId.'_stage_files/';
                    if(!file_exists($config['upload_path'])){
                        mkdir($config['upload_path'],0777);
                    }
                    $config['allowed_types'] = 'jpg|jpeg|png|gif|txt|pdf';
                    $config['max_size'] = '5000'; // max_size in kb
                    $config['file_name'] = $taskId . 'file' . $i;

                    //Load upload library
                    $this->load->library('upload', $config);
                    // File upload
                    if ($this->upload->do_upload('file')) {
                        // Get data about the file
                        $uploadData = $this->upload->data();                        
                        $stageFile = array('stage_id' => $result, 'name' => $config['upload_path'].$uploadData['file_name']);
                        $this->user_model->addStageFiles($stageFile);
                    } else {
                            // $error = array('error' => $this->upload->display_errors());
                    }
                }
            }
            echo(json_encode(array('status'=>TRUE)));
        }else{
            echo(json_encode(array('status'=>FALSE)));
        }
    }

    /**
     * This function is used to show task
     */
    function showTask($taskId = NULL)
    {
        if($taskId == null)
        {
            redirect('tasks');
        }
        
        $data['taskInfo'] = $this->user_model->getTaskInfo($taskId);
        $data['user_list']=$this->user_list();
        $data['task_images'] = $this->user_model->getTaskImages($taskId);
        $data['task_links'] = $this->user_model->getTaskLinks($taskId);
        $data['task_stages'] = $this->user_model->getTaskStages($taskId);
        
        $this->global['pageTitle'] = 'DAS : Show Task';
        
        $this->loadViews("user/showTask", $this->global, $data, NULL);
    }

    /**
     * This function is used to show Bonus
     */
    function showBonus($bonusId = NULL)
    {
        if($bonusId == null)
        {
            redirect('tasks');
        }
        
        $data['bonusInfo'] = $this->user_model->getBonusInfo($bonusId);        
        
        $this->global['pageTitle'] = 'DAS : Show Bonus';
        
        $this->loadViews("user/showBonus", $this->global, $data, NULL);
    }

    /**
     * This function is used to open the tasks page
     */
    function tasks()
    {
        if($this->role === ROLE_EMPLOYEE){
            $data['taskRecords'] = $this->user_model->getTasks($this->session->userdata('userId'));
        }else{
            $data['taskRecords'] = $this->user_model->getTasks();
        }
        $data['user_list']=$this->user_list();
        $data['group_list']=$this->group_list();
        $this->global['pageTitle'] = 'DAS : All Tasks';
        
        
        $this->loadViews("user/tasks", $this->global, $data, NULL);
    }

    /**
     * This function is used to open the finished tasks
     */
    function finishedtasks()
    {
        if($this->role === ROLE_EMPLOYEE){
            $data['taskRecords'] = $this->user_model->getFinishedTasks($this->session->userdata('userId'));
        }else{
            $data['taskRecords'] = $this->user_model->getFinishedTasks();
        }
        $data['user_list']=$this->user_list();
        $data['group_list']=$this->group_list();

        $this->global['pageTitle'] = 'DAS : All Finished Tasks';        
        
        $this->loadViews("user/finishedTasks", $this->global, $data, NULL);
    }

    /**
     * This function is used to show tasks of group
     */
    function grouptasks($group = NULL)
    {
        $data['taskRecords'] = $this->user_model->getgroupTasks($group);        
        $data['user_list']=$this->user_list();
        $data['group_list']=$this->group_list();

        $this->global['pageTitle'] = 'DAS : Group Tasks';
        
        $this->loadViews("user/tasks", $this->global, $data, NULL);
    }

    /**
     * This function is used to get bonus of user
     */
    function userStars()
    {
        $data['bonusRecords'] = $this->user_model->getUserStars($this->session->userdata('userId'));
        $this->global['pageTitle'] = 'DAS : All User Bonus';
        $this->loadViews("user/userStars", $this->global, $data, NULL);
    }

     /**
     * This function used to show log history
     * @param number $userId : This is user id
     */
    function logHistory($userId = NULL)
    {
        $data['dbinfo'] = $this->user_model->gettablemb('tbl_log','monitor');
        if(isset($data['dbinfo']->total_size))
        {
            if(($data['dbinfo']->total_size)>1000){
                $this->backupLogTable();
            }
        }            

        if($this->role != ROLE_ADMIN){
            $data['employee_list']=$this->user_list($this->session->userdata('userId'));
        }else{
            $data['employee_list']=$this->user_list();
        }        

        $this->global['pageTitle'] = 'DAS : User Login History';
        
        $this->loadViews("user/logHistory", $this->global, $data, NULL);
    }

    /**
     * This function used to show general settings
     *
     */
    function general()
    {
        $data['themes'] = '';
        $this->global['pageTitle'] = 'DAS : General Settings';
        
        $this->loadViews("user/general", $this->global, $data, NULL);
    }

     /**
     * This function used to show log history
     * of user per specific date
     */
    public function logs()
    {
        $date = $this->input->post('date');    
        $id = $this->input->post('id');    
        
        $data = $this->employee_model->get_day_logins($id, $date);
        
        //output to json format
            echo json_encode($data);
    }

    /**
     * This function used to user profile
     */
    public function profile()
    {
        $data['themes'] = '';
        $this->global['pageTitle'] = 'DAS : User Profile';        
        $data['userData'] = $this->user_model->getUserData($this->session->userdata('userId'));
        $data['user_skills'] = $this->user_model->getUserSkills($this->session->userdata('userId'));        
        
        $this->loadViews("user/profile", $this->global, $data, NULL);
    }

    /**
     * This function used to show user to do items.
     */
    public function todo()
    {
        $page = '';        
        $links = '';
        $todo_data = '';
        if(isset($_POST["page"])){
            $page = $_POST["page"];
        }else{
            $page = 1;
        }

        $data['data'] = $this->user_model->getUserTodo($this->session->userdata('userId') , $page);
                
        $todo_data .= "";
        $label = array('danger','success','info','warning','primary');
        $status = array('times','check');
        $status_text = array('Not finished yet','finished');


        foreach ($data['data'] as $item){
            $since = strtotime(date("H:i:s")) - strtotime($item->date);
            $days = floor($since / 86400);
            $hours = floor($since / 3600);
            if($hours > 24 )
                $hours = $hours % 24;
            $minutes = floor(($since / 60) % 60);
            $since = '';
            if($days != 0)
                $since .= $days.' days ';
            else{
            if($hours != 0) $since .=  $hours.':';
            if($hours == 0)
                $since .= $minutes.' mins ';
            else $since .=  $minutes.' hours';
            }
                $todo_data .= '<li>
                <span class="handle ui-sortable-handle">
                <i class="fa fa-ellipsis-v"></i>
                <i class="fa fa-ellipsis-v"></i>
                </span> 
                    <span class="text">'.$item->name.'
                    </span>
                    <small class="label label-'.$label[rand(0,4)].'"><i class="fa fa-clock-o"></i> '.$since.'</small>
                    <small class="label label-'.$label[$item->status].'"><i class="fa fa-'.$status[$item->status].'"></i> '.$status_text[$item->status].'</small>
                    <div class="tools">
                    <i class="fa fa-flag-checkered finishTodo" data-todoid='.$item->id.'></i>
                    <i class="fa fa-edit editTodo" data-todoid='.$item->id.'></i>
                    <i class="fa fa-trash-o deleteTodo" data-todoid='.$item->id.'></i>
                    </div>
                </li>';
        }

        $data['total_pages'] = $this->user_model->todoPages($this->session->userdata('userId'));
        
        for($i=1; $i<=$data['total_pages']; $i++)
        {
            $links .= '<li><a>'.$i.'</a></li>';
        }

        $output = array(
            "todo_data" => $todo_data,
            "links" => $links,
        );

        echo json_encode($output);
    }

    /**
     * This function is used to user todo item.
     */
    function addTodo()
    {
        $text = $this->input->post('text');

        $todoInfo = array( 'name' => $text ,
                           'user_id' => $this->session->userdata('userId'));
        
        $result = $this->user_model->saveTodo($todoInfo);
        
        if($result > 0 ){            
            echo(json_encode(array('status'=>TRUE)));
        }else{
            echo(json_encode(array('status'=>FALSE)));
        }
    }

    /**
     * This function is used to edit Todo
     * @return boolean $result : TRUE / FALSE
     */
    function editTodo()
    {
        $todoid = $this->input->post('todoid');
        $text = $this->input->post('text');
        $todoinfo = array('name'=>$text);
        $result = $this->user_model->editTodo($todoinfo , $todoid);
        
        if ($result == true) {
            echo(json_encode(array('status'=>TRUE)));
            }
        else {
            echo(json_encode(array('status'=>FALSE)));
        }
    }

    /**
     * This function is used to delete user todo item
     * @return boolean $result : TRUE / FALSE
     */
    function deleteTodo()
    {
        $todoid = $this->input->post('todoid');        
        
        $result = $this->user_model->deleteTodo($todoid);
        
        if ($result > 0) {
                echo(json_encode(array('status'=>TRUE)));
            }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    /**
     * This function is used to finish user todo item
     * @return boolean $result : TRUE / FALSE
     */
    function finishTodo()
    {
        $todoid = $this->input->post('todoid');        
        $todoinfo = array('status'=>1);
        $result = $this->user_model->editTodo($todoinfo , $todoid);
        
        if ($result == true) {
            echo(json_encode(array('status'=>TRUE)));
            }
        else {
            echo(json_encode(array('status'=>FALSE)));
        }
    }

    /**
     * This function is used to edit user profile
     */
    function editProfile()
    {
        $userId = $this->input->post('userId');
        $education = $this->input->post('education');        
        $location = $this->input->post('location');
        $experience = $this->input->post('experience');
        $notes = $this->input->post('notes');
        $skills = $this->input->post('skills');
        $oldSkills = $this->input->post('oldSkills');        

        
        $userProfile = array('education'=>$education, 'location'=>$location, 'experience'=>$experience, 
                'notes'=> $notes , 'user_id' => $this->session->userdata('userId'));
                            
        $result = $this->user_model->editProfile($userProfile,$this->session->userdata('userId'));
        
        if($result > 0)
        {
            if($oldSkills != NULL){
                $previuosSkills = $this->user_model->getUserSkills($this->session->userdata('userId'));                
                foreach($previuosSkills as $key=>$skill){
                    if (array_key_exists($skill->id,$oldSkills))
                    {                                                  
                        $editedSkill = array('text'=> $oldSkills[$skill->id]);
                        $this->user_model->updateSkill( $editedSkill, $skill->id);                        
                    }else{
                        $this->user_model->deleteSkill( $skill->id );
                    }
                }                
            }else{
                $this->user_model->deleteUserSkills( $this->session->userdata('userId') );
            }

            if($skills != NULL){
                foreach($skills as $skill){
                    $userSkill = array('user_id'=>$this->session->userdata('userId') , 'text'=> $skill);
                    if($skill != "")
                        $this->user_model->addUserSkill($userSkill);
                }
            }
                        
            $this->session->set_flashdata('success', 'Profile Edited Successfully');
        }
        else
        {
            $this->session->set_flashdata('error', 'Profile editing failed');
        }
            redirect('profile');
    }

    /**
     * 
     * get total work hours of user filter
     * 
     */
    public function total()
    {
        $userId = $this->input->post('userId');    
        $month = $this->input->post('month');
        $year = $this->input->post('year');    
        
        $data = $this->employee_model->get_total($userId, $month , $year);
        
        //output to json format
            echo json_encode($data);
    }

    // get data for logs 
    public function UserslogHistory()
    {
        $list = $this->employee_model->get_datatables();
        $data = array();
        $no = $_POST['start'];        
        foreach ($list as $user){
            $no++;
        $actions = '';
        $row = array();      
        $row[] = $no;      
        $row[] = $user->userName;       
        $row[] = $user->userId;
        $row[] = $user->createdDtm;        
        $row[] = date('l', strtotime($user->createdDtm));
        $row[] = $user->total;
              $data[] = $row;
          }
  
          $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee_model->count_all(),
            "recordsFiltered" => $this->employee_model->count_filtered(),
            "data" => $data,
        );
          //output to json format
          echo json_encode($output);
    }

    /**
    * user_list()
    * returns a list of users.
    */ 
    public function user_list($employee_id='')
    {
        $employees = $this->user_model->get_users($employee_id);
        if($employee_id == '')
            $employee_list['']= 'Choose Employee';
        foreach ($employees as $employee) 
        {
        $employee_list[$employee->userId]=  html_escape($employee->name);
        }
        return $employee_list;
    }


    /**
    * group_list()
    * returns a list of group.
    */ 
    public function group_list()
    {
        $groups = $this->user_model->get_groups();
        $group_list[] = '';
        foreach ($groups as $group) 
        {
        $group_list[$group->id]=  html_escape($group->name);
        }
        return $group_list;
    }

    /**
    * 
    * MOnth Hours for chart
    */
    public function getMonthHours()
    {
        if($this->role === ROLE_ADMIN){            
            $data = $this->employee_model->get_month_hours();
        }else{
            $data = $this->employee_model->get_month_hours($this->session->userdata('userId'));
        }        
        
        //output to json format
            echo json_encode($data);
    }

    /**
     * 
     * Month Hours for chart
     */
    public function getUserMonthHours()
    {
        $data = $this->employee_model->get_month_hours($this->input->post('userId'));       
        
        //output to json format
            echo json_encode($data);
    }

}

?>