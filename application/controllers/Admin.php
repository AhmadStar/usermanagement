<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
/**
 * Class : Admin (AdminController)
 * Admin class to control to authenticate admin credentials and include admin functions.
 * @author : Ahmad Alnajim
 * @version : 1.0
 * @since : 2.10.2019
 */
class Admin extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('employee_model');
        
        
        // Datas -> libraries ->BaseController / This function used load user sessions
        $this->datas();
        // isLoggedIn / Login control function /  This function used login control
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            redirect('login');
        }
        
        else
        {
            // isAdmin / Admin role control function / This function used admin role control
            if(!$this->isAdmin())
            {
                $this->accesslogincontrol();
            }
        }
    }
	
     /**
     * This function is used to load the user list
     */
    function userListing()
    {
        $searchText = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;
        
        $this->load->library('pagination');
        
        $count = $this->user_model->userListingCount($searchText);

        $returns = $this->paginationCompress ( "userListing/", $count, 100 );
        
        $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);

        $data['userBonus'] = $this->user_bonus();

        $this->global['pageTitle'] = 'DAS : User List';
        
        $this->loadViews("admin/users", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        $data['roles'] = $this->user_model->getUserRoles();
        $data['groups'] = $this->user_model->getUserGroups();
        $data['work_type_list'] = $this->work_type_list();
        $this->global['pageTitle'] = 'DAS : Add User';
        $this->loadViews("admin/addNew", $this->global, $data, NULL);
    }

    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {

        // var_dump($this->input->post());die();
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        $this->form_validation->set_rules('role','Role','trim|required|numeric');
        $this->form_validation->set_rules('group','Group','trim|required|numeric');
        $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
        $this->form_validation->set_rules('workType','Work Type','required|numeric');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->addNew();
        }
        else
        {
            $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
            $email = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('password');
            $roleId = $this->input->post('role');
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $workType = $this->input->post('workType');
            
            $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 
                                'roleId'=>$roleId, 'name'=> $name,
                                'mobile'=>$mobile, 'createdBy'=>$this->vendorId,
                                'createdDtm'=>date('Y-m-d H:i:s'), 'workType'=>$workType);

            $result = $this->user_model->addNewUser($userInfo);
            
            if($result > 0)
            {                
                $group = $this->input->post('group');
                $userGroup = array('group_id'=>$group , 'user_id'=> $result );
                $result = $this->user_model->addUserToGroup($userGroup);
                if($result > 0)
                { 
                    $this->session->set_flashdata('success', 'User successfully added');
                }else{
                    $this->session->set_flashdata('error', 'Error With Group');
                }
            }
            else
            {
                $this->session->set_flashdata('error', 'User creation failed');
            }
            
            redirect('userListing');
        }
    }

     /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
        if($userId == null)
        {
            redirect('userListing');
        }
        
        $data['groups'] = $this->user_model->getUserGroups();        
        $data['roles'] = $this->user_model->getUserRoles();        
        $data['userInfo'] = $this->user_model->getUserInfo($userId);
        $data['work_type_list'] = $this->work_type_list();


        $this->global['pageTitle'] = 'DAS : Edit User';
        
        $this->loadViews("admin/editOld", $this->global, $data, NULL);
    }


    /**
     * This function is used to edit the user informations
     */
    function editUser()
    {
        $this->load->library('form_validation');
        
        $userId = $this->input->post('userId');        
        
        $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
        $this->form_validation->set_rules('role','Role','trim|required|numeric');
        $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
        $this->form_validation->set_rules('group','Group','trim|required|numeric');
        $this->form_validation->set_rules('workType','Work Type','required|numeric');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->editOld($userId);
        }
        else
        {
            $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
            $email = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('password');
            $roleId = $this->input->post('role');
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $group = $this->input->post('group');
            $workType = $this->input->post('workType');
            $userInfo = array();
            
            if(empty($password))
            {
                $userInfo = array('email'=>$email, 'roleId'=>$roleId, 
                            'name'=>$name,'mobile'=>$mobile, 'status'=>0,
                            'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'),
                            'workType'=> $workType);
            }
            else
            {
                $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId,
                    'name'=>ucwords($name), 'mobile'=>$mobile,'status'=>0, 'updatedBy'=>$this->vendorId, 
                    'updatedDtm'=>date('Y-m-d H:i:s'),'workType'=> $workType);
            }
            
            $result = $this->user_model->editUser($userInfo, $userId);
            
            if($result == true)
            {
                $userGroup = array('group_id'=>$group);
                $result = $this->user_model->editUserGroup($userGroup ,$userId);
                if($result > 0)
                { 
                    $this->session->set_flashdata('success', 'User successfully updated');
                }else{
                    $this->session->set_flashdata('error', 'Error With Group');
                }

            }
            else
            {
                $this->session->set_flashdata('error', 'User update failed');
            }
            
            redirect('userListing');
        }
    }

     /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        $userId = $this->input->post('userId');
        $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
        
        $result = $this->user_model->deleteUser($userId, $userInfo);
        
        if ($result > 0) {
                echo(json_encode(array('status'=>TRUE)));
            }
        else { echo(json_encode(array('status'=>FALSE))); }
    }


     /**
     * This function is used to add Bonus the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function addBonus()
    {
        $userId = $this->input->post('userId');
        $title = $this->input->post('title');
        $desc = $this->input->post('desc');
        $result = $this->user_model->addBonus($userId , $title, $desc);
        
        if ($result > 0) {
            echo(json_encode(array('status'=>TRUE)));
            }
        else {
            echo(json_encode(array('status'=>FALSE)));
        }
    }

    /**
     * This function used to show specific user Bonus
     * @param number $userId : This is user id
     */
    function userBonus($userId = NULL)
    {
        $userId = ($userId == NULL ? $this->session->userdata("userId") : $userId);
        $data["userInfo"] = $this->user_model->getUserInfoById($userId);
        $data['userRecords'] = $this->user_model->userBonus($userId);        

        $this->global['pageTitle'] = 'DAS : User Bonus';
        
        $this->loadViews("user/userBonus", $this->global, $data, NULL);      
    }

    /**
     * This function is used to delete user bonus
     * @return boolean $result : TRUE / FALSE
     */
    function deleteBonus()
    {
        $bonusid = $this->input->post('bonusid');        
        
        $result = $this->user_model->deleteBonus($bonusid);
        
        if ($result > 0) {
                echo(json_encode(array('status'=>TRUE)));
            }
        else { echo(json_encode(array('status'=>FALSE))); }
    }

    /**
     * This function is used to edit user bonus
     * @return boolean $result : TRUE / FALSE
     */
    function editBonus($bonusId = NULL)
    {
        if($this->input->post()){
            $this->load->library('form_validation');
            
            $bonusId = $this->input->post('bonusId');
            
            $title = ucwords(strtolower($this->security->xss_clean($this->input->post('title'))));
            $description = ucwords(strtolower($this->security->xss_clean($this->input->post('description'))));
            
            $bonusInfo = array();
            
            $bonusInfo = array('title'=>$title, 'description'=>$description,'date'=>date('Y-m-d H:i:s'));
            
            // var_dump('come with post');die();

            $result = $this->user_model->editBonus($bonusInfo, $bonusId);
            
            if($result == true)
            {
                $this->session->set_flashdata('success', 'Bonus successfully updated');
            }
            else
            {
                $this->session->set_flashdata('error', 'Bonus update failed');
            }
                
                redirect('editBonus/'.$bonusId);            
        }

        // var_dump('come withot post ');die();
                
        $data['bonusInfo'] = $this->user_model->getBonusInfo($bonusId);

        // var_dump($data['bonusInfo']);die();

        $this->global['pageTitle'] = 'DAS : Edit Bonus';
        
        $this->loadViews("admin/editBonus", $this->global, $data, NULL);
    }
    

    /**
     * This function used to show specific user log history
     * @param number $userId : This is user id
     */
    function logHistorysingle($userId = NULL)
    {
        $userId = ($userId == NULL ? $this->session->userdata("userId") : $userId);
        $data["userInfo"] = $this->user_model->getUserInfoById($userId);
        $data['userRecords'] = $this->user_model->logHistory($userId);        

        $this->global['pageTitle'] = 'DAS : User Login History';
        
        $this->loadViews("admin/logHistorysingle", $this->global, $data, NULL);      
    }

    /**
     * This function used to show users log history     
     */
    function maintainUsersLogs()
    {
        $data['user_list']=$this->_user_list();        
        $data['userRecords'] = '';
        $this->global['pageTitle'] = 'DAS : User Login History';        
        $this->loadViews("admin/maintainUsersLogs", $this->global, $data, NULL);
    }

    // get data for users logs 
    public function usersLogs()
    {
        $list = $this->employee_model->get_users_datatables();
        $data = array();
        $no = $_POST['start'];        
        foreach ($list as $employee){
            $no++;
            $actions = '';
            $row = array();      
            $row[] = $no;      
            $row[] = $employee->userName;       
            $row[] = $employee->userId;
            $row[] = $employee->process;
            $row[] = $employee->createdDtm;        
            $row[] = date('l', strtotime($employee->createdDtm));            
            $actions .= '<span class="glyphicon glyphicon-remove deleteLog" title="Delete Log" data-logid='.$employee->id.'></span>';                   
            $row[] = $actions;

            $data[] = $row;
        }
  
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee_model->count_all(),
            "recordsFiltered" => $this->employee_model->count_users_logs_filtered(),
            "data" => $data,
        );
          //output to json format
          echo json_encode($output);
    }

    /**
     * This function is used to add new user to the system
     */
    function addUserLog()
    {
        $data['users'] = $this->_user_list();
        if($this->input->post()){            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_id', 'user name', 'required');
            $this->form_validation->set_rules('createdDtm', 'date is required', 'required');            
            
            if($this->form_validation->run() == FALSE)
            {
                redirect('addUserLog');
            }
            else
            {
                $user_id = $this->input->post('user_id');
                $createdDtm = $this->input->post('createdDtm');
                $process = $this->input->post('process');                
                $logInfo = array('userId'=>$user_id,'userName'=>$data['users'][$user_id],
                    'process'=>$process,'createdDtm'=>$createdDtm);
                
                $this->load->model('login_model');
                $result = $this->login_model->loginsert($logInfo);
                                

                if($result > 0)
                {                
                    $this->session->set_flashdata('success', 'log successfully added');
                }
                else
                {
                    $this->session->set_flashdata('error', 'log creation failed');
                }
                
                redirect('addUserLog');
            }
        }
        
        $this->global['pageTitle'] = 'DAS : Add User';
        $this->loadViews("admin/addUserLog", $this->global, $data, NULL);
    }

    /**
     * This function is used to delete log record
     * @return boolean $result : TRUE / FALSE
     */
    function deleteLogRecord()
    {
        $logid = $this->input->post('logid');        
        
        $result = $this->user_model->deleteLogRecord($logid);
        
        if ($result > 0){
            echo(json_encode(array('status'=>$result)));
        }
        else{
            echo(json_encode(array('status'=>$result)));
        }
    }
    
    /**
     * This function used to backup and delete log table
     */
    function backupLogTable()
    {
        $this->load->dbutil();
        $prefs = array(
            'tables'=>array('tbl_log')
        );
        $backup=$this->dbutil->backup($prefs) ;        
        $date = date('d-m-Y H-i');
        $filename = './backup/'.$date.'.sql.gz';
        $this->load->helper('file');
        write_file($filename,$backup);

        $this->user_model->clearlogtbl();

        if($backup)
        {
            $this->session->set_flashdata('success', 'Successful backup and table cleanup');
            redirect('log-history');
        }
        else
        {
            $this->session->set_flashdata('error', 'Backup and Table Cleanup Fails');
            redirect('log-history');
        }
    }

    /**
     * This function used to open the logHistoryBackup page
     */
    function logHistoryBackup()
    {
        $data['dbinfo'] = $this->user_model->gettablemb('tbl_log_backup','monitor');
        if(isset($data['dbinfo']->total_size))
        {
        if(($data['dbinfo']->total_size)>1000){
            // $this->backupLogTable();
        }
        }
        $data['userRecords'] = $this->user_model->logHistoryBackup();

        $this->global['pageTitle'] = 'DAS : User Backup Entry History';
        
        $this->loadViews("admin/logHistoryBackup", $this->global, $data, NULL);
    }

    /**
     * This function used to delete backup_log table
     */
    function backupLogTableDelete()
    {
        $backup=$this->user_model->clearlogBackuptbl();

        if($backup)
        {
            $this->session->set_flashdata('success', 'Table cleanup successful');
            redirect('log-history-backup');
        }
        else
        {
            $this->session->set_flashdata('error', 'Table cleanup fails');
            redirect('log-history-backup');
        }
    }

    /**
     * This function used to open the logHistoryUpload page
     */
    function logHistoryUpload()
    {
            $this->load->helper('directory');
            $map = directory_map('./backup/', FALSE, TRUE);
        
            $data['backups']=$map;

            $this->global['pageTitle'] = 'DAS : User Log Download';
            
            $this->loadViews("admin/logHistoryUpload", $this->global, $data, NULL);      
    }

    /**
     * This function used to upload backup for backup_log table
     */
    function logHistoryUploadFile()
    {
        $optioninput = $this->input->post('optionfilebackup');

        if ($optioninput == '0' && $_FILES['filebackup']['name'] != '')
        {
            $config = array(
            'upload_path' => "./uploads/",
            'allowed_types' => "gz|sql|gzip",
            'overwrite' => TRUE,
            'max_size' => "20048000", // Can be set to particular file size , here it is 20 MB(20048 Kb)
            );

            $this->load->library('upload', $config);
            $upload= $this->upload->do_upload('filebackup');
                $data = $this->upload->data();
                $filepath = $data['full_path'];
                $path_parts = pathinfo($filepath);
                $filetype = $path_parts['extension'];
                if ($filetype == 'gz')
                {
                    // Read entire gz file
                    $lines = gzfile($filepath);
                    $lines = str_replace('tbl_log','tbl_log_backup', $lines);
                }
                else
                {
                    // Read in entire file
                    $lines = file($filepath);
                    $lines = str_replace('tbl_log','tbl_log_backup', $lines);
                }
        }

        else if ($optioninput != '0' && $_FILES['filebackup']['name'] == '')
        {
            $filepath = './backup/'.$optioninput;
            $path_parts = pathinfo($filepath);
            $filetype = $path_parts['extension'];
            if ($filetype == 'gz')
            {
                // Read entire gz file
                $lines = gzfile($filepath);
                $lines = str_replace('tbl_log','tbl_log_backup', $lines);
            }
            else
            {
                // Read in entire file
                $lines = file($filepath);
                $lines = str_replace('tbl_log','tbl_log_backup', $lines);
            }
        }
                // Set line to collect lines that wrap
                $templine = '';
                
                // Loop through each line
                foreach ($lines as $line)
                {
                    // Skip it if it's a comment
                    if (substr($line, 0, 2) == '--' || $line == '')
                    continue;
                    // Add this line to the current templine we are creating
                    $templine .= $line;

                    // If it has a semicolon at the end, it's the end of the query so can process this templine
                    if (substr(trim($line), -1, 1) == ';')
                    {
                        // Perform the query
                        $this->db->query($templine);

                        // Reset temp variable to empty
                        $templine = '';
                    }
                }
            if (empty($lines) || !isset($lines))
            {
                $this->session->set_flashdata('error', 'Backup installation failed');
                redirect('log-history-upload');
            }
            else
            {
                $this->session->set_flashdata('success', 'Backup installation successful');
                redirect('log-history-upload');
            }
    }

    /**
     * This function used to show log history
     * @param number $userId : This is user id
     */
    function getBrowseData()
    {
        $data = $this->user_model->get_browse_data();
        
        //output to json format
            echo json_encode($data);
    }    

    /**
     * This function used to show log history every day     
     */
    function dailylogs()
    {
        $data['dbinfo'] = $this->user_model->gettablemb('tbl_log','monitor');
        if(isset($data['dbinfo']->total_size))
        {
            if(($data['dbinfo']->total_size)>1000){
                $this->backupLogTable();
            }
        }        

        $this->global['pageTitle'] = 'DAS : Daily Login History';
        
        $this->loadViews("admin/dailylogHistory", $this->global, $data, NULL);
    }

    /**
   * user_bonus()
   * returns a list of all users bonus .
   */
    public function user_bonus()
    {
        $bonuses = $this->user_model->get_bonus();    
        $bonus_list[] = '';
        foreach ($bonuses as $bonus) 
        {
            $bonus_list[$bonus->user_id]=  html_escape($bonus->stars);
        }
        return $bonus_list;
    }

    /**
     * _user_list()
     * returns a list of users.
     */
    public function _user_list()
    {
        $users = $this->user_model->get_all_users();
        $user_list[''] ='Choose Employee';        
        foreach ($users as $user) {
            $user_list[$user->userId] =  html_escape($user->name);
        }
        return $user_list;
    }

    /**
     * work_type_list()
     * returns a list of work type.
     */
    public function work_type_list()
    {
        $worktype_list[''] ='Choose Work Type';
        $worktype_list['1'] ='Office Work';
        $worktype_list['2'] ='Remote';
        return $worktype_list;
    }
}

