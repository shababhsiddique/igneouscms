<?php

/**
 * Description of product_manager_model
 *
 * @author Shabab Haider Siddique
 */
class Content_Manager_Model extends CI_Model {

    /**
     * Common 
     */
    public function deleteTableRowById($table, $pk, $id) {
        $this->db->where("$table.$pk", $id);
        $this->db->delete($table);
    }

    /**
     * Datatables Source Function
     * @param type $dataGridConfig
     * @return json DataTable Object
     */
    public function jsonDtObject($dataGridConfig) {


        $buttons = "";
        $dashboard_url = "admin/dashboard";

        if (isset($dataGridConfig["dashboard"]) && ($dataGridConfig["dashboard"] != "")) {
            $dashboard_url = $dataGridConfig["dashboard"];
        }


        if (isset($dataGridConfig["actions"]["approve"])) {
            $approveFunction = site_url("$dashboard_url/" . $dataGridConfig["actions"]["approve"]);
            $approveButton = '<a href="' . $approveFunction . '/$1"><i class="icon-ok" title="' . $this->lang->line("Publish") . '" ></i></a>';

            $buttons .= "&nbsp;&nbsp;$approveButton";
        }


        if (isset($dataGridConfig["actions"]["deny"])) {
            $denyFunction = site_url("$dashboard_url/" . $dataGridConfig["actions"]["deny"]);
            $denyButton = '<a href="' . $denyFunction . '/$1"><i class="icon-warning-sign" title="' . $this->lang->line("Unpublish") . '" ></i></a>';

            $buttons .= "&nbsp;&nbsp;$denyButton";
        }

        if (isset($dataGridConfig["actions"]["edit"])) {
            $editFunction = site_url("$dashboard_url/" . $dataGridConfig["actions"]["edit"]);
            $editButton = '<a href="' . $editFunction . '/$1"><i class="glyphicon glyphicon-pencil" title="' . $this->lang->line("Edit") . '" ></i></a>';

            $buttons.= "&nbsp;&nbsp;$editButton";
        }

        if (isset($dataGridConfig["actions"]["delete"])) {
            $deleteFunction = site_url("$dashboard_url/" . $dataGridConfig["actions"]["delete"]);
            $deleteButton = '<a href="' . $deleteFunction . '/$1"><i class="glyphicon glyphicon-remove" title="' . $this->lang->line("Delete") . '" onclick="return confirmDelete()"></i></a>';

            $buttons .= "&nbsp;&nbsp;$deleteButton";
        }

        /**
         * SELECT $_* FROM  $_*
         */
        $selectColumns = array();
        foreach ($dataGridConfig["select"] as $column => $prop) {
            if (strstr($prop, "image") || strstr($prop, "text")) {
                
            } else {
                $selectColumns[] = $column;
            }
        }

        $select = implode(",", $selectColumns);
        $this->datatables
                ->select($select)
                ->from($dataGridConfig['from']);

        /**
         *  JOIN $_* ON $_* 
         */
        if (isset($dataGridConfig["join"])) {

            foreach ($dataGridConfig["join"] as $joinTable => $joinCodition) {
                $this->datatables->join($joinTable, $joinCodition);
            }
        }

        $this->datatables->add_column('action', $buttons, $dataGridConfig['action_key']);
        return $this->datatables->generate();
    }

    /**
     * Finalize admin changes
     * 
     *       refresh cache folder, delete temp files
     */
    public function finalizeAdminChanges() {

        //Delete backup temp
        if (file_exists('backup.zip')) {
            unlink('backup.zip');
        }
        //Delete backup sql temp
        if (file_exists('bdb_cms_sql.txt')) {
            unlink("db_cms_sql.txt");
        }

        $this->clearSiteCache();
    }

    /**
     * Delete all site cache
     */
    public function clearSiteCache() {
        //Delete site cache
        $cache_path = APPPATH . 'cache/';

        $cachefiles = glob("$cache_path*"); // get all file names
        foreach ($cachefiles as $aCache) { // iterate files
            if (is_file($aCache) && ($aCache != "application/cache/index.html"))
                unlink($aCache); // delete file
        }
    }

    public function selectAll($table) {
        return $this->db->select("*")
                        ->from($table)
                        ->get()
                        ->result_array();
    }

    public function saveRow($table, $pk, $submit_data) {

        unset($submit_data["action"]);

        if ($submit_data["$pk"] == 0 || $submit_data["$pk"] == "") {
            //Do insert            
            $this->db->insert("$table", $submit_data);
        } else {
            //Do update
            $this->db->where("$table.$pk", $submit_data["$pk"]);
            $this->db->update("$table", $submit_data);
        }


        return $this->db->affected_rows();
    }

    public function deleteRowById($table, $pk, $anId) {
        $this->db->where("$table.$pk", $anId);
        $this->db->delete($table);

        return $this->db->affected_rows();
    }

    public function deleteImage($imgFile, $tbl, $col) {


        $rows = $this->db
                ->select("*")
                ->from("$tbl")
                ->get()
                ->result_array();

        foreach ($rows as $row) {
            //Image was in use
            if (strstr($row[$col], $imgFile)) {

                $newImgs = str_replace($imgFile, "", $row[$col]);
                $newImgs = trim(str_replace(",,", ",", $newImgs), ", ");


                $first_value = reset($row);
                $pk = key($row);

                $data = array(
                    "$col" => $newImgs
                );
                $this->db->where("$pk", $row[$pk]);
                $this->db->update($tbl, $data);
            }
        }


        $imgFile = "./content/image/$imgFile";
        unlink($imgFile);
        if (file_exists($imgFile)) {
            echo "not deleted";
        } else {
            echo "ok";
        }
    }

    public function handleTreeChange() {


        $status = $this->input->get('state');
        $publish_id = $this->input->get('stateId');
        $renameId = $this->input->get('renameId');
        $newName = $this->input->get('newName');
        $deleteIds = $this->input->get('deleteIds');
        $saveString = $this->input->get('saveString');


        if (($publish_id != "") && ($status != "")) {

            $updateData = array(
                "menu_id" => $publish_id,
                "status_id" => $status
            );

            $this->saveRow("tbl_menu", "menu_id", $updateData);
            echo "OK";
            exit;
        } elseif (($renameId != "") && ($newName != "")) {

            $updateData = array(
                "menu_id" => $renameId,
                "menu_display_link" => $newName
            );

            $this->saveRow("tbl_menu", "menu_id", $updateData);
            echo "OK";
            exit;
        } else if (($deleteIds != "")) { // Format of $_GET['deleteIds'] : A comma separated list of ids to delete, example: 1,2,3,4,5,6,7
            $ids = explode(",", $deleteIds);

            foreach ($ids as $anId)
                $this->deleteRowById("tbl_menu", "menu_id", $anId);

            echo "OK";
            exit;
        } else if (($saveString != "")) { //the order of the nodes in the tree in the format id-parentID,id-parentID,id-parentID            
            $nodes = explode(",", $saveString);
            $tree_weight = 1;

            foreach ($nodes as $aNode) {

                $data = explode("-", $aNode);

                $updateData = array(
                    "menu_id" => $data[0],
                    "menu_weight" => $tree_weight,
                    "menu_parent_id" => $data[1]
                );

                $this->saveRow("tbl_menu", "menu_id", $updateData);

                $tree_weight++;
            }

            echo "OK";
            exit;
        }

        echo "NOT OK";
    }

    public function handleLiveChange($postData) {


        $update_data = array(
            $postData["update_column"] => $postData["update"]
        );

        $this->db->where($postData["primary_key"], $postData["id"]);
        $this->db->update($postData["table"], $update_data);

        $update_status = $this->db->affected_rows();

        if ($update_status != 0) {
            echo "update success";
        }
    }

}