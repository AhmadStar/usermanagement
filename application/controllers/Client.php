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
        // isManagerOrAdmin / Admin or manager role control function / This function used admin or manager role control
        if(!$this->isClient())
        {
            $this->accesslogincontrol();
        }
    }

    /**
     * This function used to show tasks
     * @param {int} $status : 3 bending , 2 finished , 1 opened
     */
    function clientBendingTasks()
    {
        $data['taskRecords'] = $this->user_model->getClientTasks($this->session->userdata('userId') , 3);
        $data['user_list']=$this->employee_list();
        $data['group_list']=$this->group_list();

        $this->global['pageTitle'] = 'DAS : Client Bending Tasks';
        
        $this->loadViews("bendingTasks", $this->global, $data, NULL);
    }

    /**
     * This function used to show tasks
     */
    function clientOpenedTasks()
    {
        $data['taskRecords'] = $this->user_model->getClientTasks($this->session->userdata('userId') , 1);
        $data['user_list']=$this->employee_list();
        $data['group_list']=$this->group_list();

        $this->global['pageTitle'] = 'DAS : Client Opened Tasks';
        
        $this->loadViews("tasks", $this->global, $data, NULL);
    }

    /**
     * This function used to show tasks
     */
    function clientFinishedTasks()
    {
        $data['taskRecords'] = $this->user_model->getClientTasks($this->session->userdata('userId') , 2);
        $data['user_list']=$this->employee_list();        
        $data['group_list']=$this->group_list();

        $this->global['pageTitle'] = 'DAS : Client Finished Tasks';
        
        $this->loadViews("finishedTasks", $this->global, $data, NULL);
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
   * _employee_list()
   * returns a list of employee.
   */ 
  public function employee_list()
  {
    $employees = $this->employee_model->get_employees();
    $employee_list[] = '';
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

}

?>