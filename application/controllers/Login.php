<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
/**
 * Class : Login (LoginController)
 * Admin class to control to authenticate admin credentials and include admin functions.
 * @author : Ahmad Alnajim
 * @version : 1.0
 * @since : 2.10.2019
 */
class Login extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('user_model');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
    }

    /**
     * This function is used to open error /404 not found page
     */
    public function error()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('user/login');
        }
        else
        {            
            redirect('pageNotFound');
        }
    }

    /**
     * This function is used to access denied page
     */
    public function noaccess() {
        
        $this->global['pageTitle'] = 'Access Denied';
        $this->datas();

        $this->load->view ( 'includes/header', $this->global );
		$this->load->view ( 'user/access' );
		$this->load->view ( 'includes/footer' );
    }

    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('user/login');
        }
        else
        {
            redirect('/dashboard');
        }
    }
    
    
    /**
     * This function used to logged in user
     */
    public function loginMe()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $email = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('password');
            
            $result = $this->login_model->loginMe($email, $password);                        

            if(count($result) > 0)
            {
                foreach ($result as $res)
                {
                    $lastLogin = $this->login_model->lastLoginInfo($res->userId);
                    $ipList = $this->login_model->ipAddresses($res->userId);
                    $ipValues = array();
                    foreach($ipList as $record)
                        array_push($ipValues , $record['ip']);
                    $process = 'Login';
                    $processFunction = 'Login/loginMe';

                    // if work type == 1 check if it login from the office                     
                    if($res->workType == OFFICE_WORK && in_array($_SERVER['REMOTE_ADDR'] , $ipValues)){
                        $this->session->set_flashdata('error', 'you should login from office only');
                        redirect('/login');
                    }

                    if(!($token = $this->input->cookie('site_theme')))
                    {
                        $session_id = sha1(mt_rand(0, PHP_INT_MAX).time());
                        // set cookie 
                        $cookie = array(
                            'name'   => 'theme',
                            'value' => 'skin-blue'."\n".$session_id,
                            'expire' => time()+86500,
                            'domain' => 'localhost',
                            'path'   => '/',
                            'prefix' => 'site_',
                            );

                        $this->input->set_cookie($cookie);
                    }

                    $sessionArray = array('userId'=>$res->userId,                    
                                            'role'=>$res->roleId,
                                            'roleText'=>$res->role,
                                            'group_id'=>$res->groups_id,
                                            'group_name'=>$res->group_name,
                                            'name'=>$res->name,
                                            'picture'=>$res->picture,
                                            'lastLogin'=> isset($lastLogin) ? $lastLogin->createdDtm : 'first ',
                                            'status'=> $res->status,
                                            'isLoggedIn' => TRUE
                                    );

                    $this->session->set_userdata($sessionArray);

                    unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
                    
                    $this->logrecord($process,$processFunction);

                    $userInfo = array('is_logged'=>1 , 'last_login' =>date('Y-m-d H:i:s'));
        
                    $this->user_model->editUser($userInfo, $res->userId);

                    redirect('/dashboard');
                }
            }
            else
            {
                $this->session->set_flashdata('error', 'Email address or password is incorrect');
                
                redirect('/login');
            }
        }
    }

    /**
     * This function used to load forgot password view
     */
    public function forgotPassword()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('user/forgotPassword');
        }
        else
        {
            redirect('/dashboard');
        }
    }
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser()
    {
        $status = '';
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email');
                
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $email = $this->security->xss_clean($this->input->post('login_email'));
            
            if($this->login_model->checkEmailExist($email))
            {
                $encoded_email = urlencode($email);
                
                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['createdDtm'] = date('Y-m-d H:i:s');
                $data['agent'] = getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();
                $data['expire'] = date("Y-m-d H:i:s", strtotime('+2 hours'));
                
                $save = $this->login_model->resetPasswordUser($data);                
                
                if($save)
                {
                    $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $data1["name"] = $userInfo[0]->name;
                        $data1["email"] = $userInfo[0]->email;
                        $data1["message"] = "Reset Your Password";
                    }

                    $sendStatus = resetPasswordEmail($data1);

                    if($sendStatus){
                        $status = "send";
                        setFlashData($status, "Your password reset link has been sent successfully, please check your mail.");
                    } else {
                        $status = "notsend";
                        setFlashData($status, "Email sending failed, try again.");
                    }
                }
                else
                {
                    $status = 'unable';
                    setFlashData($status, "There was an error sending your information, try again.");
                }
            }
            else
            {
                $status = 'invalid';
                setFlashData($status, "Your email address is not registered in the system.");
            }
            redirect('/forgotPassword');
        }
    }

    /**
     * This function used to reset the password 
     * @param string $activation_id : This is unique id
     * @param string $email : This is user email
     */
    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);
        
        // Check activation id in database
        $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
        
        
        $data['email'] = $email;
        $data['activation_code'] = $activation_id;
        
        if ($is_correct == 1)
        {   
            // Check activation id in database
            $not_expired = $this->login_model->checkActivationDetailsExpire($email, $activation_id);
            if ($not_expired == 1)
            {   
                $this->load->view('user/newPassword', $data);
            }else{
                $status = 'error';
                setFlashData($status, "your reset password link has expired.");
                redirect('/login');                
            }
        }
        else
        {
            redirect('/login');
        }
    }
    
    /**
     * This function used to create new password for user
     */
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = $this->input->post("email");
        $activation_id = $this->input->post("activation_code");
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        }
        else
        {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');
            
            // Check activation id in database
            $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
            
            if($is_correct == 1)
            {               
                $this->login_model->createPasswordUser($email, $password);                                

                $status = 'success';
                $message = 'Password changed successfully';
            }
            else
            {
                $status = 'error';
                $message = 'Failed to change password';
            }
            
            setFlashData($status, $message);

            redirect("/login");
        }
    }
}

?>