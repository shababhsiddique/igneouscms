<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//    
//session_save_path("tmp"); 
session_start();


/**
 * Admin Landing Controller
 *
 * @author Shabab Haider Siddique
 */
class Login extends CI_Controller {

    /**
     * Constructor
     * @author Shabab Haider Siddique
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('admin/admin_login_model', 'login');
    }

    public $admin_name;

    /**
     * Landing Page containing admin login form
     * @author Shabab Haider Siddique
     * @param --- none
     * @return --- none
     * date --- 21/11/2012 (mm/dd/yyyy  )
     */
    public function index() {

        $admin_logged_in = $this->session->userdata('admin_logged_in');
        if (isset($admin_logged_in) && $admin_logged_in == true) {
            redirect('admin/dashboard');
        } else {
            $this->admin_name = $this->session->userdata('admin_name');
        }
        $this->load->view('admin/login');
    }

    /**
     * Login action 
     * @author Shabab Haider Siddique
     * @param --- none
     * @return --- none
     * date --- 21/11/2012 (mm/dd/yyyy  )
     */
    public function authenticate() {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $result = $this->login->checkCredentials($username, $password);

        if (!$result) {
            $data = array();

            $sessionData = setmessage("Invalid", "Invalid Username / password ", "error");
            $this->session->set_userdata($sessionData);
        } else {

            
            $this->load->model("admin/content_manager_model","content_manager");
            $this->content_manager->clearSiteCache();
            
            $sessionData = setmessage("Welcome", "You have successfully logged in as admin ", "success");
            $sessionData['admin_name'] = $result['admin_name'];
            $sessionData['admin_user_name'] = $username;
            $sessionData['admin_user_id'] = $result['admin_id'];
            $sessionData['admin_privilage_level'] = $result['privilage_level'];
            $sessionData['admin_logged_in'] = TRUE;

            $this->session->set_userdata($sessionData);
            
        redirect('admin');
        }


        redirect('admin', 'refresh');
    }

}

/* End of file admin/login.php */
/* Location: ./application/controllers/admin/login.php */