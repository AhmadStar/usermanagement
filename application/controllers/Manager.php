<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
/**
 * Class : Manager (ManagerController)
 * Manager class to control to authenticate manager credentials and include manager functions.
 * @author : Ahmad Alnajim
 * @version : 1.0
 * @since : 2.10.2019
 */
class Manager extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
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
            // isManagerOrAdmin / Admin or manager role control function / This function used admin or manager role control
            if(!$this->isManagerOrAdmin() && !$this->isClient())
            {
                $this->accesslogincontrol();
            }
        }
    }
        
     /**
     * This function used to show tasks
     */
    function tasks()
    {
        $data['taskRecords'] = $this->user_model->getTasks();
        $data['user_list']=$this->employee_list();

        $this->global['pageTitle'] = 'DAS : All Tasks';
        
        $this->loadViews("tasks", $this->global, $data, NULL);
    }

    /**
     * This function used to show tasks
     */
    function Bendingtasks()
    {
        $data['taskRecords'] = $this->user_model->getBendingTasks();
        $data['user_list']=$this->employee_list();

        $this->global['pageTitle'] = 'DAS : All Bending Tasks';
        
        $this->loadViews("bindingTasks", $this->global, $data, NULL);
    }

     /**
     * This function used to show tasks
     */
    function finishedTasks()
    {
        $data['taskRecords'] = $this->user_model->getFinishedTasks();
        $data['user_list']=$this->employee_list();

        $this->global['pageTitle'] = 'DAS : All Finished Tasks';
        
        $this->loadViews("finishedTasks", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the add new task
     */
    function addNewTask()
    {
        $data['tasks_prioritys'] = $this->user_model->getTasksPrioritys();            
        $data['user_list']= $this->_user_list();
        $data['groups'] = $this->user_model->getUserGroups();

        // for first item
        $item = new stdClass();
        $item->id = 4;
        $item->name = 'Not fot Group';
        array_push($data['groups'], $item);        

        $this->global['pageTitle'] = 'DAS : Add Task';

        $this->loadViews("addNewTask", $this->global, $data, NULL);
    }

     /**
     * This function is used to add new task to the system
     */
    function addNewTasks()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('fname','Task Title','required');
        $this->form_validation->set_rules('priority','priority','required');
        $this->form_validation->set_rules('employee_id','employee name','required');
        $this->form_validation->set_rules('group','Group Name','trim|required|numeric');

        if($this->form_validation->run() == FALSE)
        {
            $this->addNewTask();
        }
        else
        {
            $title = $this->input->post('fname');
            $comment = $this->input->post('comment');
            $priorityId = $this->input->post('priority');
            $employee_id = $this->input->post('employee_id');
            $group = $this->input->post('group');
            $links = $this->input->post('links');

            if($this->role === ROLE_CLIENT)                
                $statusId = 3;
            else
                $statusId = 1;
            $permalink = sef($title);
            
            $taskInfo = array('title'=>$title, 'comment'=>$comment, 'priorityId'=>$priorityId, 'statusId'=> $statusId,
                                'permalink'=>$permalink, 'createdBy'=>$this->vendorId,
                                'employee_id' => $employee_id , 'group_id' => $group);
                                
            $result = $this->user_model->addNewTasks($taskInfo);
            
            if($result > 0)
            {
                foreach($links as $link){
                    $taskLink = array('task_id'=>$result , 'name'=> $link);
                    $linkresult = $this->user_model->addTaskLinks($taskLink);
                    if($linkresult < 0){
                        $this->session->set_flashdata('error', 'Task Link creation failed');
                    }
                }

                // Count total files
                $countfiles = count($_FILES['files']['name']);
                // Looping all files
                
                for($i=0;$i<$countfiles;$i++){
            
                    if(!empty($_FILES['files']['name'][$i])){
            
                        // Define new $_FILES array - $_FILES['file']
                        $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                        $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                        // Set preference
                        $config['upload_path']  = './uploads/';
                        $config['allowed_types'] = 'jpg|jpeg|png|gif|txt|pdf';
                        $config['max_size'] = '5000'; // max_size in kb
                        $config['file_name'] = $result.'file'.$i;
                
                        //Load upload library
                        $this->load->library('upload',$config);
            
                        // File upload
                        if($this->upload->do_upload('file')){
                            // Get data about the file
                            $uploadData = $this->upload->data();
                            $filename = $uploadData['file_name'];
                            $taskFile = array('task_id'=>$result , 'name'=> $filename);
                            $linkresult = $this->user_model->addTaskFiles($taskFile);
                        }else{
                            {
                                $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
                                $error = array('error' => $this->upload->display_errors());
                                $this->session->set_flashdata('error',$error['error']);
                                redirect('addNewTask');
                            }
                        }
                    }
                }

                $this->session->set_flashdata('success', 'Task created successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Task creation failed');
            }
            
            redirect('addNewTask');
        }
    }

    /**
     * This function is used to open edit tasks view
     */
    function editOldTask($taskId = NULL)
    {
        if($taskId == null)
        {
            redirect('tasks');
        }
        
        $data['taskInfo'] = $this->user_model->getTaskInfo($taskId);        
        $data['tasks_prioritys'] = $this->user_model->getTasksPrioritys();
        $data['tasks_situations'] = $this->user_model->getTasksSituations();
        $data['tasks_images'] = $this->user_model->getTasksImages($taskId);
        $data['tasks_links'] = $this->user_model->getTasksLinks($taskId);

        $data['groups'] = $this->user_model->getUserGroups();
        
        $data['user_list']=$this->_user_list();
        
        $this->global['pageTitle'] = 'DAS : Edit Task';
        
        $this->loadViews("editOldTask", $this->global, $data, NULL);
    }

    /**
     * This function is used to edit tasks
     */
    function editTask()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('fname','Task Title','required');
        $this->form_validation->set_rules('priority','priority','required');
        $this->form_validation->set_rules('employee_id','employee name','required');
        $this->form_validation->set_rules('group','Group Name','trim|required|numeric');
        
        $taskId = $this->input->post('taskId');

        if($this->form_validation->run() == FALSE)
        {
            $this->editOldTask($taskId);
        }
        else
        {
            // var_dump($this->input->post());die();
            $taskId = $this->input->post('taskId');
            $title = $this->input->post('fname');
            $comment = $this->input->post('comment');
            $priorityId = $this->input->post('priority');
            $statusId = $this->input->post('status');
            $employee_id = $this->input->post('employee_id');
            $group = $this->input->post('group');
            $links = $this->input->post('links');
            $linksOld = $this->input->post('linksOld');
            $permalink = sef($title);            
            
            $taskInfo = array('title'=>$title, 'comment'=>$comment, 'priorityId'=>$priorityId, 
                    'statusId'=> $statusId,'permalink'=>$permalink, 'createdBy'=>$this->vendorId,
                                'employee_id' => $employee_id , 'group_id' => $group);
                                
            $result = $this->user_model->editTask($taskInfo,$taskId);
            
            if($result > 0)
            {
                if($linksOld != NULL){
                    $oldLinks = $this->user_model->getTasksLinks($taskId);
                    foreach($oldLinks as $key=>$link){
                        if (array_key_exists($link->id,$linksOld))
                        {                    
                            $Link = array('name'=> $linksOld[$link->id]);
                            $this->user_model->updateLink( $Link, $link->id);
                        }else{
                            $this->user_model->deleteLink( $link->id );
                        }
                    }
                }else{
                    $this->user_model->deleteAllLink( $taskId );
                }

                if($links != NULL){
                    foreach($links as $link){
                        $taskLink = array('task_id'=>$taskId , 'name'=> $link);
                        if($link != "")
                            $this->user_model->addTaskLinks($taskLink);
                    }
                }                    

                // Count total files
                $countfiles = count($_FILES['files']['name']);
                // Looping all files
                
                for($i=0;$i<$countfiles;$i++){
            
                    if(!empty($_FILES['files']['name'][$i])){
            
                        // Define new $_FILES array - $_FILES['file']
                        $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                        $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                        // Set preference
                        $config['upload_path']  = './uploads/';
                        $config['allowed_types'] = 'jpg|jpeg|png|gif|txt|pdf';
                        $config['max_size'] = '5000'; // max_size in kb
                        $config['file_name'] = $taskId.'file'.$i;
                
                        //Load upload library
                        $this->load->library('upload',$config);
            
                        // File upload
                        if($this->upload->do_upload('file')){
                            // Get data about the file
                            $uploadData = $this->upload->data();
                            $filename = $uploadData['file_name'];
                            $taskFile = array('task_id'=>$taskId , 'name'=> $filename);
                            $linkresult = $this->user_model->addTaskFiles($taskFile);
                        }else{
                            {
                                $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
                                $error = array('error' => $this->upload->display_errors());
                                $this->session->set_flashdata('error',$error['error']);
                                redirect('addNewTask');
                            }
                        }
                    }
                }
                $this->session->set_flashdata('success', 'Task edited successful');
            }
            else
            {
                $this->session->set_flashdata('error', 'Task editing failed');
            }
            if($this->role === ROLE_CLIENT)
                redirect('clientTasks');                
            else
                redirect('tasks');
            
        }
    }

    /**
     * This function is used to delete tasks
     */
    function deleteTask()
    {
        $taskId = $this->input->post('taskId');        
                
        $result = $this->user_model->deleteTask($taskId);
        
        if ($result > 0) {
                echo(json_encode(array('status'=>TRUE)));
            }
        else { echo(json_encode(array('status'=>FALSE))); }        
    }

    /**
     * This function is used to confirm tasks
     */
    function confirmTask()
    {
        $taskId = $this->input->post('taskId');        

        $data = array('statusId'=> 1);
        $result = $this->user_model->confirmTask($taskId , $data);
        
        if ($result > 0) {
                echo(json_encode(array('statusId'=>TRUE)));
            }
        else { echo(json_encode(array('status'=>FALSE))); }        
    }

    /**
   * _user_list()
   * returns a list of employee.
   */
    public function _user_list()
    {
        $users = $this->user_model->get_users();
        $user_list['']= 'Choose Employee';
        $user_list['0']= 'Not For User';
        foreach ($users as $user){
            $user_list[$user->userId]=  html_escape($user->name);
        }
        return $user_list;
    }

 /**
   * employee_list()
   * returns a list of employee.
   */ 
    public function employee_list()
    {
        $users = $this->user_model->get_users();    
        return $users;
    }


  /**
     * This function used to show log history
     * @param number $userId : This is user id
     */
    public function deleteFile()
    {
        $id = $this->input->post('id');    
        
        $data = $this->user_model->delete_file($id);
        
        //output to json format
            echo json_encode($data);
    }

}