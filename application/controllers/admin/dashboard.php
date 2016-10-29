<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//session_save_path("tmp"); 
session_start();

/**
 * Description of dashboard
 *
 * @author shabab
 */
class Dashboard extends CI_Controller {

    /**
     * Constructor
     * @author Shabab Haider Siddique
     */
    private $layout;
    private $ajax;
    private $theme_file;

    public function __construct() {
        parent::__construct();
        $this->_prepareLayout();

        $this->theme_file = "admin/theme/main";

        // Check whether admin is logged in
        $admin_logged_in = $this->session->userdata('admin_logged_in');
        if (!isset($admin_logged_in) || $admin_logged_in == false) {
            redirect('admin/login');
        } else {
            $this->layout['admin_name'] = $this->session->userdata('admin_name');
        }

        $this->ajax = $this->input->get("ajax");

        if ($this->ajax == "y") {

            $this->theme_file = "admin/components/blank";
        }


        
        $_SESSION['KCFINDER']['uploadURL'] = "../../../../../content/image";
        $_SESSION['KCFINDER']['uploadDir'] = "../../../../../content/image";

        // Initialize helpers and models
        $this->load->library('datatables');
        $this->load->library('formfactory');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="err-block">', '</span>');

        $this->load->model('app/content_model', 'content');
        $this->load->model('admin/entity_model', 'entity');
        $this->load->model('admin/content_manager_model', 'content_manager');
    }

    /**
     * Populate common display items 
     */
    private function _prepareLayout() {

        $this->layout = array();
        $this->layout['content'] = null;
    }

    /**
     * landing page for  dashboard
     */
    public function index() {

        $this->layout['contents'] = $this->load->view('admin/components/frame', array('url' => site_url("page/1")), true);
        $this->load->view($this->theme_file, $this->layout);
    }

    /**
     * landing page for  dashboard
     */
    public function live($pg = 0) {

        if ($pg == 0)
            $this->layout['contents'] = $this->load->view('admin/components/frame', array('url' => site_url("")), true);
        else
            $this->layout['contents'] = $this->load->view('admin/components/frame', array('url' => site_url("page/$pg")), true);
        $this->load->view($this->theme_file, $this->layout);
    }

    /**
     * Universal entity view datatable
     * @param type $entity
     * @param type $json 
     */
    public function entity_view($entity, $json = false) {

        $entity = $this->entity->$entity();

        if ($json) {
            echo $this->content_manager->jsonDtObject($entity);
        } else {


            $this->layout['contents'] = $this->load->view('admin/components/datatable', $entity, true);
            $this->load->view($this->theme_file, $this->layout);
        }
    }

    /**
     * Universal Entity Edit/Authoring Form
     * @param type $entity
     * @param type $item_id 
     */
    public function entity_auth($entityTitle, $item_id = 0) {

        //Get the entity
        $entity = $this->entity->$entityTitle();
        $action = $this->input->post("action");
        $formData = array(
            "entity" => $entity,
            "oldEntityData" => false
        );

        $formData["item_id"] = $item_id;

        //ID found on URL, its an edit
        if ($item_id != 0)
            $formData["oldEntityData"] = $this->formfactory->selectEntityRowById($entity, $item_id);


        //Form Submitted
        if ($action == "submit") {


            //Apply validation 
            $rules = $this->formfactory->generateRules($entity, $item_id);

            $this->form_validation->set_rules($rules);

            if ($this->form_validation->run() == FALSE) {

                //Error found, show correction form
                $this->layout["contents"] = $this->load->view("admin/components/formview", $formData, true);
                $this->load->view($this->theme_file, $this->layout);
            } else {

                //Save entity
                $affected = $this->formfactory->saveEntity($entity, $this->input->post(NULL, TRUE));

                if ($affected != 0) {
                    $sessionData = setmessage("Saved", "$affected $entityTitle Saved ", "success");
                    $this->session->set_userdata($sessionData);
                } else {
                    $sessionData = setmessage("Sorry", "$affected $entityTitle where saved ", "warning");
                    $this->session->set_userdata($sessionData);
                }

                //Redirect to entity grid view
                redirect("admin/dashboard/" . $entityTitle . "_view");
            }
        } else {
            //View blank form
            $this->layout["contents"] = $this->load->view("admin/components/formview", $formData, true);
            $this->load->view($this->theme_file, $this->layout);
        }
    }

    /**
     * Browse slider images
     */
    public function slider() {

        $_SESSION['KCFINDER']['uploadURL'] = "../../../../../content/slides";
        $_SESSION['KCFINDER']['uploadDir'] = "../../../../../content/slides";

        $this->layout['contents'] = $this->load->view('admin/components/frame', array('url' => base_url() . "resources/admin/js/plugins/kcfinder/browse.php?type=image"), true);
        $this->load->view($this->theme_file, $this->layout);
    }

    /**
     * Browse slider images
     */
    public function menu() {

        $menu_data = array(
            "menu" => $this->content_manager->selectAll("tbl_menu")
        );


        if ($this->ajax == "y") {
            $this->layout['contents'] = $this->load->view('admin/components/menutree', $menu_data);
        } else {
            $this->layout['contents'] = $this->load->view('admin/components/menutree', $menu_data, true);
            $this->load->view($this->theme_file, $this->layout);
        }
    }

    /**
     * Ajax Handlers 
     * ****************************************************************** */
    public function ajaxTreeHandler() {
        $this->content_manager->handleTreeChange();
    }

    public function ajaxWysiwygHandler() {
        $this->content_manager->handleLiveChange($this->input->post());
    }

    public function ajaxDelImg($imgFile,$tbl,$col) {
        $this->content_manager->deleteImage($imgFile,$tbl,$col);
    }

    /**
     * COMMON FUNCTIONS START HERE 
     * **************************************************************** */

    /**
     * Entity manipulation API Calls
     * @param type $table
     * @param type $pk
     * @param type $id 
     */
    public function quickdelete($table, $pk, $id) {

        $affected = $this->content_manager->deleteTableRowById($table, $pk, $id);

        $tbl = explode("_", $pk);

        $sessionData = setmessage("Deleted", "", "info");
        $this->session->set_userdata($sessionData);

        redirect("admin/dashboard/$tbl[0]" . "_view");
    }

    public function quickupdate($table, $targetColumn, $targetValue, $pk, $id) {
        
    }

    /**
     * Log out and Remove Session values
     * @author Shabab Haider Siddique
     * @param --- none
     * @return --- none
     * date --- 10/11/2012 (mm/dd/yyyy  )
     */
    public function logout() {

        $this->content_manager->finalizeAdminChanges();

        $this->session->sess_destroy();
        $this->session->unset_userdata('admin_user_name');
        $this->session->unset_userdata('admin_logged_in');
        $this->session->unset_userdata('admin_name');
        $this->session->unset_userdata('admin_privilage_level');
        $this->session->unset_userdata('admin_user_id');

        $sessionData = setmessage("Logged Out", "from admin ", "info");
        $this->session->set_userdata($sessionData);

        session_destroy();

        redirect('admin', 'refresh');
    }

    /**
     * backup the site and database
     * 
     */
    public function backup() {

        $this->load->library('zip');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->dbutil();
        $prefs = array(
            'format' => 'txt'
        );

        $backup = & $this->dbutil->backup($prefs);
        write_file('db_cms_sql.txt', $backup);

        $this->zip->read_dir("./application/");
        $this->zip->read_dir("./content/");
        $this->zip->read_dir("./css/");
        $this->zip->read_dir("./help/");
        $this->zip->read_dir("./js/");
        $this->zip->read_dir("./system/");
        $this->zip->read_dir("./theme/");

        $this->zip->read_file("./index.php", TRUE);
        $this->zip->read_file("./.htaccess", TRUE);
        $this->zip->read_file("./business-icon.png", TRUE);
        $this->zip->read_file("./readme.txt", TRUE);
        $this->zip->read_file("./db_cms_sql.txt", TRUE);


        $this->zip->archive("backup.zip");
        $this->zip->download();


        redirect("admin/dashboard");
    }

    /**
     * Backup End
     */
    /*     * ***********
     * COMMON END 
     */
}