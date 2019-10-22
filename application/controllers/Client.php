<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * Client Class to control all Client related operations.
 * @author : Ahmad Alnajim
 * @version : 1.0
 * @since : 22.10.2019
 */
class Client extends BaseController
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
     * This function is used to load the add new task for Client
     */
    function addClientTask()
    {
        if($this->input->post()){

            // var_dump('send task');die();
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

                $statusId = 3;
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
                
                redirect('addClientTask');
            }
        }


        $data['tasks_prioritys'] = $this->user_model->getTasksPrioritys();            
        $data['user_list']= $this->_user_list();
        $data['groups'] = $this->user_model->getUserGroups();

        // for first item
        $item = new stdClass();
        $item->id = 4;
        $item->name = 'Not fot Group';
        array_push($data['groups'], $item);        

        $this->global['pageTitle'] = 'DAS : Add Task';

        $this->loadViews("addClientTask", $this->global, $data, NULL);
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
}

?>