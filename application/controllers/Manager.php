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
            if($this->isManagerOrAdmin() == TRUE)
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
        $this->global['pageTitle'] = 'DAS : Add Task';

        $this->loadViews("addNewTask", $this->global, $data, NULL);
    }

     /**
     * This function is used to add new task to the system
     */
    function addNewTasks()
    {
        $this->load->library('form_validation');
        
        // var_dump($this->input->post());die();

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
            
            $statusId = 1;
            $permalink = sef($title);
            
            $taskInfo = array('title'=>$title, 'comment'=>$comment, 'priorityId'=>$priorityId, 'statusId'=> $statusId,
                                'permalink'=>$permalink, 'createdBy'=>$this->vendorId,
                                'employee_id' => $employee_id , 'group_id' => $group);
                                
            $result = $this->user_model->addNewTasks($taskInfo);
            
            if($result > 0)
            {
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
        // var_dump($data['taskInfo']);die();
        $data['tasks_prioritys'] = $this->user_model->getTasksPrioritys();
        $data['tasks_situations'] = $this->user_model->getTasksSituations();
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
            $permalink = sef($title);
            
            $taskInfo = array('title'=>$title, 'comment'=>$comment, 'priorityId'=>$priorityId, 'statusId'=> $statusId,
                                'permalink'=>$permalink, 'createdBy'=>$this->vendorId,
                                'employee_id' => $employee_id , 'group_id' => $group);
                                
            $result = $this->user_model->editTask($taskInfo,$taskId);
            
            if($result > 0)
            {                
                $this->session->set_flashdata('success', 'Task editing successful');
            }
            else
            {
                $this->session->set_flashdata('error', 'Task editing failed');
            }
            redirect('tasks');
        }
    }

    /**
     * This function is used to delete tasks
     */
    function deleteTask($taskId = NULL)
    {
        if($taskId == null)
        {
            redirect('tasks');
        }

        $result = $this->user_model->deleteTask($taskId);
        
        if ($result == TRUE) {
            $this->session->set_flashdata('success', 'Task deleted successful');
        }
        else
        {
            $this->session->set_flashdata('error', 'Task deletion failed');
        }
        redirect('tasks');
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
    foreach ($users as $user) 
    {
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

}