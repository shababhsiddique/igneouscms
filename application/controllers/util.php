<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

session_save_path("tmp");
session_start();

/**
 * Description of util
 *
 * @author shabab
 */
class Util extends CI_Controller {

    /**
     * Constructor
     * @author Shabab Haider Siddique
     */
    private $layout;

    public function __construct() {
        parent::__construct();
        $this->layout = array();

        // Initialize helpers and models
    }

    /**
     * Populate common display items 
     */
    private function _prepareLayout() {

        $this->layout = array();
    }

    /**
     * landing page for  util
     */
    public function index() {
        
    }

    public function get_captcha() {
        $captcha_context = randString("12");
       
        $sessionData = array(
            "captcha_context" => $captcha_context
        );
        $this->session->set_userdata($sessionData);

        print_r($this->simple_captcha->draw_captcha($captcha_context));
    }

}