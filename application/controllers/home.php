<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_save_path("tmp");
session_start();

/**
 * Description of home
 *
 * @author shabab
 */
class Home extends CI_Controller {

    /**
     * Constructor
     * @author Shabab Haider Siddique
     */
    private $layout;
    private $homepageId;

    
    public function __construct() {
        parent::__construct();

        // Initialize helpers and models
        $this->load->model('app/content_model', 'content');
        $this->homepageId = $this->content->config('home_page');

        //Cache site content
        $this->output->cache($this->content->config('cache_duration'));

        //Initialize layout
        $this->layout = array();
        $this->_prepareLayout();
    }

    /**
     * Populate common display items 
     */
    private function _prepareLayout() {


        $this->layout = array(
            'title' => $this->content->config('site_title'),
            'base_url' => base_url(),
            'contents' => null
        );
    }

    
    /**
     * landing page 
     */
    public function index() {
     
        $this->load->view('app/theme/main', $this->layout);
    }    
    
    
    public function page($page_id,$page_title=""){
        
        $this->layout["content"] = $this->content->page($page_id);
        $this->load->view('app/theme/main', $this->layout);
    }
    
    public function testmail(){
        
        
        
         $email_config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => '465',
            'smtp_user' => 'esonance.registration@iut-dhaka.edu',
            'smtp_pass' => 'esonance@IUT',
            'mailtype' => 'html',
            'starttls' => true,
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );
         
        $email_config = Array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => '465',
            'smtp_user' => 'shabab.h.siddique@gmail.com',
            'smtp_pass' => '101onefive980',
            'mailtype'  => 'html',
            'starttls'  => true,
            'newline'   => "\r\n"
        );

        $this->load->library('email', $email_config);

        $this->email->from('shabab.h.siddique@gmail.com', 'Shabab');
        $this->email->to('shuvo0904@gmail.com');
        $this->email->subject('Invoice');
        $this->email->message('Testing localhost email');

        $this->email->send();
        
        echo "Test";
    }
    
}