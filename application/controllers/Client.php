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
     * This function used to show tasks
     */
    function clientTasks()
    {
        $data['taskRecords'] = $this->user_model->getClientTasks($this->session->userdata('userId'));
        $data['user_list']=$this->employee_list();

        $this->global['pageTitle'] = 'DAS : Our Tasks';
        
        $this->loadViews("clientTasks", $this->global, $data, NULL);
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
}

?>