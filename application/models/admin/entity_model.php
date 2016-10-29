<?php

/**
 * Description of entity_model
 *
 * @author Shabab Haider Siddique
 */

class Entity_Model extends CI_Model {
   
    
    /*
     * Entity general structure     
    
    public function ENTITY_NAME() {

         $entity = array(
            "select" => array(
                "table.column" => "datatype#Default Value#Field Readable Name#Help Text#validation Rules",
                 ............
                "tbl_config.config_key" => "varchar#YOUR_UNIQUE_KEY#the unique keyword##min_length[6]|required|alpha_dash",
                "tbl_config.config_rich" => "richtext#YOUR_UNIQUE_KEY#the unique keyword##min_length[6]|required|alpha_dash",
                "tbl_config.config_img" => "image####required",
            ),
            "from" => 'from_table',
            "join" => array(
                "joined_table" => "joined_table.joined_table_column = from_table.from_table_column"
                 ...........
            ),
            "action_key" => 'table.primary_key',
            "actions" => array(
                "edit" => "ENTITYNAME_auth",
                "delete" => "quickdelete/table/primary_key"
            )
        );

        return $entity;
    }
    
    */
    

    public function config() {

        $entity = array(
            "select" => array(
                "tbl_config.config_id" => "number####",
                "tbl_config.config_key" => "varchar#YOUR_UNIQUE_KEY#the unique keyword##min_length[6]|required|alpha_dash|is_unique[tbl_config.config_key]",
                "tbl_config.config_value" => "varchar####required"  //"data type#prefil value#help text#field label#validation rules"
            ),
            "from" => 'tbl_config',
            "action_key" => 'tbl_config.config_id',
            "actions" => array(
                "edit" => "config_auth",
                "delete" => "quickdelete/tbl_config/config_id"
            )
        );

        return $entity;
    }

    
    public function email() {
        
        $entity = array(
            "select" => array(
                "tbl_emails.email_id" => "number####",
                "tbl_emails.email" => "varchar####required|email"
            ),
            "from" => 'tbl_emails',
            "action_key" => 'tbl_emails.email_id',
            "actions" => array(
                "delete" => "quickdelete/tbl_emails/email_id"
            )
        );

        return $entity;
    }
    
    
    
    public function menu() {
        
        $entity = array(
            "select" => array(
                "tbl_menu.menu_id" => "number####",
                "tbl_menu.menu_parent_id" => "number####required|belongs_to[tbl_menu.menu_id]",
                "tbl_menu.menu_weight" => "number####",
                "tbl_menu.menu_display_link" => "varchar####required",
                "tbl_menu.menu_site_url" => "varchar####required",
                "lookup_status.status" => "select####required"
            ),
            "from" => 'tbl_menu',
            "join" => array(
                "lookup_status" => "tbl_menu.status_id = lookup_status.status_id"
            ),
            "action_key" => 'tbl_menu.menu_id',
            "actions" => array(
                "edit" => "menu_auth",
                "delete" => "quickdelete/tbl_menu/menu_id"
            )
        );

        return $entity;
    }
    
    

    public function admin() {

        $tbl = "tbl_admin";
        $pk = "admin_id";

        $entity = array(
            "select" => array(
                "$tbl.$pk" => "number####",
                "$tbl.admin_name" => "varchar####required|alpha_space",
                "$tbl.admin_email_address" => "varchar####required|email|is_unique[$tbl.admin_email_address]",
                "$tbl.admin_password" => "varchar####required|md5",
                "lookup_roles.role" => "select####required|integer|greater_than[0]"
            ),
            "from" => "$tbl",
            "join" => array(
                "lookup_roles" => "$tbl.role_id = lookup_roles.role_id"
            ),
            "action_key" => "$tbl.$pk",
            "actions" => array(
                "edit" => "admin_auth",
                "delete" => "quickdelete/$tbl/$pk"
            )
        );

        return $entity;
    }
    
     public function role() {

        $tbl = "lookup_roles";
        $pk = "role_id";
        
        $id = $this->session->userdata("admin_user_id");

        $entity = array(
            "select" => array(
                "$tbl.$pk" => "number####",
                "$tbl.role" => "varchar####required|alpha_space",
                "$tbl.permissions" => "varchar##Specify the permitted entities. The available entities to give permissions are - (page,article,block,menu,slider,email,admin,backup,config). Shorthands (all)##required|regex_match[/^[a-z0-9,]+$/]",
            ),
            "from" => "$tbl",
            "where" => array(
                "admin_id !=" => $id
            ),
            "action_key" => "$tbl.$pk",
            "actions" => array(
                "edit" => "role_auth",
                "delete" => "quickdelete/$tbl/$pk"
            )
        );
        

        return $entity;
    }

    
    public function article() {

        $tbl = "tbl_articles";
        $pk = "article_id";

        $entity = array(
            "select" => array(
                "$tbl.$pk" => "number####",
                "$tbl.article_title" => "varchar####required",
                "$tbl.article_img" => "image####",
                "$tbl.article_author" => "varchar####required",
                "$tbl.article_body" => "richtext####required",
                "$tbl.article_category" => "varchar####required",
                "lookup_status.status" => "select####required"
            ),
            "from" => "$tbl",
            "join" => array(
                "lookup_status" => "tbl_articles.status_id = lookup_status.status_id"
            ),
            "action_key" => "$tbl.$pk",
            "actions" => array(
                "edit" => "article_auth",
                "delete" => "quickdelete/$tbl/$pk"
            )
        );

        return $entity;
    }
    
    
    
    public function page() {

        $tbl = "tbl_pages";
        $pk = "page_id";

        $entity = array(
            "select" => array(
                "$tbl.$pk" => "number####",
                "$tbl.page_title" => "varchar####required",
                "$tbl.page_body" => "richtext####required",
                "lookup_status.status" => "select####required"
            ),
            "from" => "$tbl",
            "join" => array(
                "lookup_status" => "$tbl.status_id = lookup_status.status_id"
            ),
            "action_key" => "$tbl.$pk",
            "actions" => array(
                "edit" => "page_auth",
                "live" => "live",
                "delete" => "quickdelete/$tbl/$pk"
            )
        );

        return $entity;
    }
    
    
    public function block() {

        $entity = array(
            "select" => array(
                "tbl_blocks.block_id" => "number####",
                "tbl_blocks.block_title" => "varchar#YOUR_UNIQUE_KEY###min_length[6]|required|alpha_dash|is_unique[tbl_blocks.block_title]",
                "tbl_blocks.block_html" => "richtext####required"  //"data type#prefil value#help text#field label#validation rules"
            ),
            "from" => 'tbl_blocks',
            "action_key" => 'tbl_blocks.block_id',
            "actions" => array(
                "edit" => "block_auth",
                "live" => "live/0",
                "delete" => "quickdelete/tbl_blocks/block_id"
            )
        );

        return $entity;
    }
    
    
    public function status() {

        $entity = array(
            "select" => array(
                "lookup_status.status_id" => "number####",
                "lookup_status.status" => "varchar####min_length[6]|required|alpha_space"
            ),
            "from" => 'lookup_status',
            "action_key" => 'lookup_status.status_id',
            "actions" => array(
                "edit" => "status_auth",
                "delete" => "quickdelete/lookup_status/status_id"
            )
        );

        return $entity;
    }

}

