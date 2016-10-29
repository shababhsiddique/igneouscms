<?php

/**
 * Description of product_manager_model
 *
 * @author User
 */
class Content_Model extends CI_Model {
    /**
     * Constructor
     * @author Shabab Haider Siddique
     */
    /**
     * Articles 
     */

    /**
     *
     * @param type $pageId
     * @return type 
     */
    public function selectArticleById($articleId) {

        return $this->db->select("*")
                        ->from('tbl_articles')
                        ->where('article_id', $articleId)
                        ->get()->row_array();
    }

    /**
     * Select published article by ID
     * @param type $articleId
     * @return type 
     */
    public function selectPublishedArticleById($articleId) {

        return $this->db->select("*")
                        ->from('tbl_articles')
                        ->where('article_id', $articleId)
                        ->where('status_id', 3)
                        ->get()->row_array();
    }

    /**
     *
     * @param type $limit
     * @param type $offset
     * @return type 
     */
    public function selectAllArticles($limit = 100, $offset = 0) {

        $term = $this->input->get("q");

        $query = $this->db->select("*")
                ->from('tbl_articles');

        if (isset($term)) {
            $this->db->where("(
                    article_title LIKE '%$term%' OR
                    last_edit LIKE '$term%' OR
                    article_author = '$term' OR
                    article_category LIKE '%$term%' 
                )
                AND
                (   
                    status_id = 3 
                )");
        } else {
            $this->db->where('status_id', 3);
        }

        return $this->db->limit($limit, $offset)
                        ->order_by('last_edit', "DESC")
                        ->get()->result_array();
    }

    /**
     * Articles End
     */
    /**
     * Blocks  
     */

    /**
     * Select All Blocks
     * @return result array
     */
    public function selectAllBlocks() {

        return $this->db->select("*")
                        ->from('tbl_blocks')
                        ->get()->result_array();
    }

    /**
     * Select specific block by ID
     * @param type $blockID
     * @return type 
     */
    public function selectBlockById($blockID) {

        return $this->db->select("*")
                        ->from('tbl_blocks')
                        ->where('block_id', $blockID)
                        ->get()->row_array();
    }

    /**
     * Block
     * @param type $config_key
     * @return type 
     */
    public function block($block_title, $data = null) {


        $query = $this->db->select("*")
                ->from('tbl_blocks')
                ->where('block_title', $block_title)
                ->get();

        if ($query->num_rows() == 0) {

            $data = array(
                'block_title' => $block_title,
                'block_html' => base64_decode($data)
            );
            $this->db->insert("tbl_blocks", $data);

            $query = $this->db->select("*")
                    ->from('tbl_blocks')
                    ->where('block_title', $block_title)
                    ->get();
        } else {
            $row = $query->row_array();
        }

        $row['block_html'] = "<div data-tbl='tbl_blocks' data-pk='block_id' data-dc='block_html' data-id='$row[block_id]' id='block_$row[block_id]'>" . $row['block_html'] . "</div>";


        $admin_logged_in = $this->session->userdata('admin_logged_in');

        /**
         * WYSYWYG Wrapper 
         */
        if ($admin_logged_in == true) {
            $row['block_html'] .= "<script type='text/javascript'>
                            //<![CDATA[
                           bkLib.onDomLoaded(function() {
                               myNicEditor.addInstance('block_$row[block_id]');
                           });
                           //]]>
                       </script>";
        }
        
        
        return $row['block_html'];
    }

    /**
     *  Blocks End
     */
    
    
    public function page($page_id) {


        $query = $this->db->select("*")
                ->from('tbl_pages')
                ->where('page_id', $page_id)
                ->get();

        if ($query->num_rows() != 0) {

            $row = $query->row_array();
        }

        $row['page_body'] = "<div data-tbl='tbl_pages' data-pk='page_id' data-dc='page_body' data-id='$row[page_id]' id='page_$row[page_id]'>" . $row['page_body'] . "</div>";


        $admin_logged_in = $this->session->userdata('admin_logged_in');

        /**
         * WYSYWYG Wrapper 
         */
        if ($admin_logged_in == true) {
            $row['page_body'] .= "<script type='text/javascript'>
                            //<![CDATA[
                           bkLib.onDomLoaded(function() {
                               myNicEditor.addInstance('page_$row[page_id]');
                           });
                           //]]>
                       </script>";
        }
        
        
        return $row['page_body'];
    }

    
    /**
     * Config fetcher
     * @param type $config_key
     * @return type 
     */
    public function config($config_key) {
        $row = $this->db->select("*")
                        ->from('tbl_config')
                        ->where('config_key', $config_key)
                        ->get()->row_array();
        return $row['config_value'];
    }

    /**
     * Config fetcher end 
     */
    
    
    /**
     * Select All Menu Entries
     * @return type 
     */
    public function selectAllMenu() {

        return $this->db->select("*")
                        ->from('tbl_menu')
                        ->where('status_id', 3)
                        ->order_by("menu_weight")
                        ->get()->result_array();
    }

    
    
    /**
     * Get list of slider images
     * @return type 
     */
    public function getAvailableSlides() {
        $this->load->helper('directory');
        $map = directory_map('./content/slides/image/');
        return $map;
    }

    
    /**
     * Subscribe mail 
     * @param type $mail
     * @return boolean 
     */
    public function subscribeMail($mail) {

        $this->db
                ->select("*")
                ->from("tbl_emails")
                ->where("email", $mail);

        if ($this->db->get()->num_rows() == 0) {
            $update_data = array(
                "email" => $mail
            );
            $this->db->insert('tbl_emails', $update_data);
            return true;
        } else {
            return false;
        }
    }

   
}