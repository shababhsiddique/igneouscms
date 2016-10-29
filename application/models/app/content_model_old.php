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
     * Pages 
     */

    /**
     *
     * @param type $pageId
     * @return type 
     */
    public function selectPageById($pageId) {

        //$this->db->query("SELECT * FROM tbl_pages ");

        return $this->db
                        ->select("
                            tbl_pages.page_id,
                            tbl_pages.page_title,
                            tbl_pages.page_structure
                            ")
                        ->from('tbl_pages')
                        ->where('page_id', $pageId)
                        ->get()->row_array();
    }

    /**
     *
     * @return type 
     */
    public function selectAllPages() {
        return $this->db->select("*")
                        ->from('tbl_pages')
                        ->where('status_id', 3)
                        ->get()->result_array();
    }

    /**
     * Select page excluding list
     * @param type $page_ids
     * @return type 
     */
    public function selectAllPagesExcluding($page_ids) {
        return $this->db->select("*")
                        ->from('tbl_pages')
                        ->where_not_in('page_id', array($page_ids))
                        ->where('status_id', 3)
                        ->get()->result_array();
    }

    /**
     * Pages End
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
     * @return type 
     */
    public function selectLatestArticles() {
        $rslt = $this->db->select("*")
                        ->from('tbl_articles')
                        ->where('status_id', 3)
                        ->limit(7, 0)
                        ->order_by('last_edit', "DESC")
                        ->get()->result_array();

        $return = array();

        foreach ($rslt as $anItem) {
            $return[] = anchor("home/article/$anItem[article_title]/$anItem[article_id]", $anItem["article_title"]);
        }

        return $return;
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
     * Select all article categories
     * @return type 
     */
    public function selectAllArticleCategories() {
        $rw = $this->db
                        ->select("article_category")
                        ->distinct("article_category")
                        ->from('tbl_articles')
                        ->get()->result_array();

        $return = array();

        foreach ($rw as $anItem) {
            $return[] = anchor("blog/?q=$anItem[article_category]", $anItem["article_category"]);
        }

        return $return;
    }

    /**
     * Select all article months
     * @return type 
     */
    public function selectAllArticleMonths() {
        $query = "SELECT DISTINCT(EXTRACT(YEAR_MONTH from last_edit)) FROM tbl_articles";
        $query = $this->db->query($query);

        $return = array();

        foreach ($query->result_array() as $anItem) {
            $return[] = anchor("blog/?q=" . $anItem["(EXTRACT(YEAR_MONTH from last_edit))"], $anItem["(EXTRACT(YEAR_MONTH from last_edit))"]);
        }

        return $return;
    }

    /**
     * Articles End
     */
    /**
     * Comments 
     */

    /**
     * Save comment to database
     * @param type $commentData 
     */
    public function saveNewComment($commentData) {
        $this->db->insert("tbl_comments", $commentData);

        return $this->db->affected_rows();
    }

    /**
     * Comments End 
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
     *  Blocks End
     */

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

    /**
     * Universal plugin functions 
     */

    /**
     * Select All Items (table supplied by paramater)
     * @param type $from
     * @return type 
     */
    public function selectAllItems($from) {
        return $this->db->select("*")
                        ->from($from)
                        ->get()->result_array();
    }

    /**
     * Select Item by id (table provided by paramater)
     * @param type $conf
     * @param type $itmID
     * @return type 
     */
    public function selectItemById($conf, $itmID) {
        return $this->db->select($conf['select'])
                        ->from($conf['from'])
                        ->where($conf['action_key'], $itmID)
                        ->get()->row_array();
    }

    public function selectItemByIdAll($item_id) {

        return $this->db
                        ->select("
                            tbl_plugin_portfolio.portfolio_item_id,
                            tbl_plugin_portfolio.portfolio_item_title,
                            tbl_plugin_portfolio.portfolio_item_gallery,
                            tbl_plugin_portfolio.portfolio_item_detail,
                            tbl_plugin_portfolio.portfolio_item_subdetail,
                            tbl_plugin_portfolio.portfolio_item_date,
                            tbl_plugin_portfolio.portfolio_item_tag,
                            tbl_plugin_portfolio.portfolio_item_client,
                            tbl_plugin_portfolio.portfolio_item_link,                                    
                            ")
                        ->from('tbl_plugin_portfolio')
                        ->where('portfolio_item_id', $item_id)
                        ->get()->row_array();
    }

    public function selectAllimages($item_id) {
        return $this->db->select("
             tbl_plugin_portfolio.portfolio_item_gallery,
")
                        ->from(" tbl_plugin_portfolio")
                        ->Where('portfolio_item_id', $item_id)
                        ->get()->result_array();
    }

    public function selectimageId() {

        return $this->db->select("*")
                        ->from("tbl_plugin_portfolio")
                        ->order_by("portfolio_item_id", "desc")
                        ->limit(3,0)
                        ->get()->result_array();
    }

    /**
     * Get portfolio folder directory map
     * @param type $folder
     * @return type 
     */
    public function getAllPortfolioImages($folder = "") {
        $this->load->helper('directory');
        $map = directory_map('./content/plugins/portfolio/' . $folder);
        return $map;
    }

    /**
     * Get gallery folder map
     * @return type 
     */
    public function getAvailableImages($show_hidden = false) {
        $this->load->helper('directory');
        $map = directory_map('./content/plugins/gallery/image/', FALSE, $show_hidden);
        return $map;
    }

    /**
     * Plugins end 
     */

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

        $row['block_html'] = "<div id='block_$row[block_id]'>" . $row['block_html'] . "</div>";


        $admin_logged_in = $this->session->userdata('admin_logged_in');

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

}