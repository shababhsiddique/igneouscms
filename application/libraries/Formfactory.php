<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Form Factory Library
 * 
 * version beta testing
 * 
 * 
 * @author  : Shabab Haider Siddiqe
 * 
 * 9-6-2014
 */
class Formfactory {

    //put your code here


    private $CI;
    private $formViewHtml;
    private $fieldWrapper;
    private $inputTemplates;
    private $linkTemplate;
    private $currentEntity;
    private $base_url;

    public function __construct() {


        $this->CI = & get_instance();
        $this->CI->load->database();

        $this->base_url = "admin/dashboard";


        $this->inputTemplates = array(
            "hidden" => '<input name="##name##" type="hidden" value="##default##">',
            "varchar" => '<input name="##name##" type="text" placeholder="##default##" value="##default##"  class="form-control">',
            "number" => '<input name="##name##" type="number"  placeholder="##default##" value="##default##"  class="form-control">',
            "password" => '<input name="##name##" type="password" placeholder="##default##" value="##default##"    class="form-control">',
            "text" => '<textarea class="form-control" name="##name##">##default##</textarea>',
            "richtext" => '<textarea class="form-control rich-textarea" name="##name##">##default##</textarea>',
            "file" => '<input name="##name##" class="input-file" type="file">',
            "image" => '<input name="##name##" class="input-file" type="file" accept="image/x-png, image/jpg, image/jpeg">',
            "images" => '<input name="##name##[]" class="input-file" type="file" accept="image/x-png, image/jpg, image/jpeg" multiple>',
            "select" => '<select name="##name##" class="form-control-select col-sm-10 prefilled_select" data-value="##default##" >##OPTIONS##</select> <a href="##LOOKUPNEW##" target="_blank" class="btn btn-info"><i class="fa fa-plus"></i></a>'
        );


        $this->fieldWrapper = '
                <div class="form-group">
                    <label class="col-md-4 control-label">##LABEL##</label>
                    <div class="col-md-8">
                        ##INPUT##                                            
                        <span class="help-block">##HELP##</span>  
                    </div>
                </div>';


        $this->buttonStripWrapper = '
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-8">
                        <button name="action" class="btn btn-primary" value="submit" type="submit"><i class="glyphicon glyphicon-floppy-save"></i>&nbsp;&nbsp;Submit</button>
                        ##EXTRABTNS##
                    </div>
                </div>';


        $this->linkTemplate = '<a class="btn btn-##CLASS##" href="##HREF##" ##ATR##>##TEXT##</a>';

        $this->thumbTemplate = "<image width='30%' class='img-thumbnail' src='" . base_url() . "content/image/il_570xN.438777963_9lrj_.jpg' />";
    }

    /**
     * Get previous image thumb for delete
     * @param type $id
     * @return string 
     */
    public function getFieldPreviousImages($id, $fieldName) {

        $html = "";

        $rslt = $this->CI->db->select("*")
                ->from($this->currentEntity["from"])
                ->where($this->currentEntity["action_key"], $id)
                ->get()
                ->row_array();

        $img = $rslt[$fieldName];
        
        if ($img != "") {
            
            $images = explode(",", $img);
            $html = "<div class='images-thumb-grid col-lg-12'>";
            foreach ($images as $key => $anImage) {
                $html .= "<div class='col-xs-4' id='i_$key'>";
                $html .= "<button type='button' onclick='deleteImage(" . '"' . $anImage . '","' . $key . '","' . $this->currentEntity["from"] . '","' . $fieldName . '"'. ")' class='glyphicon glyphicon-remove'></button>";
                $html .= "<image class='img-thumbnail' src='" . base_url() . "content/image/$anImage'/>";
                $html .= "</div>";
            }
            $html .= "</div>";
        }

        return $html;
    }

    /**
     * 
     * @param type $fieldName
     * @param type $fieldType
     * @param type $fieldDefaultValue
     * @param type $fieldHelp
     * @param type $fieldDisplayName
     * @return string 
     */
    public function generateField($fieldName, $fieldType = "text", $fieldDefaultValue = "", $fieldHelp = "", $fieldDisplayName = "", $configIndex = "", $item_id = 0) {


        if ($fieldType == "hidden") {
            $field = $this->inputTemplates[$fieldType];
        } else {
            $field = $this->fieldWrapper;

            $prependeditems = "";


            if (($fieldType == "image" && $item_id != 0) || ($fieldType == "images" && $item_id != 0)) {
                $prependeditems = $this->getFieldPreviousImages($item_id, $fieldName);
            }
            $field = str_replace("##INPUT##", $prependeditems . $this->inputTemplates[$fieldType] . form_error($fieldName), $field);
            $field = str_replace("##HELP##", $fieldHelp, $field);


            if ($fieldDisplayName != "") {
                $field = str_replace("##LABEL##", $fieldDisplayName, $field);
            } else {
                $generatedDisplayName = ucwords(str_replace("_", " ", $fieldName));
                $field = str_replace("##LABEL##", $generatedDisplayName, $field);
            }
        }


        if ($fieldType == "select") {

            /**
             * Generate Options 
             */
            foreach ($this->currentEntity["join"] as $joinTable => $joinCondition) {

                $joinTable = $joinTable;

                if (strstr($configIndex, $joinTable)) {
                    /**
                     * This joined table is part of the select 
                     */
                    $mainTable = $this->currentEntity["from"];

                    $joinedColumnes = explode("=", $joinCondition);

                    $joinedColumnes[0] = trim($joinedColumnes[0]);
                    $joinedColumnes[1] = trim($joinedColumnes[1]);

                    if (strstr($joinedColumnes[0], $joinTable)) {
                        /**
                         * This column is from joined table 
                         */
                        $joinTableColumn = str_replace($joinTable . ".", "", $joinedColumnes[0]);
                        $mainTableColumn = str_replace($mainTable . ".", "", $joinedColumnes[1]);
                    } else {
                        $joinTableColumn = str_replace($joinTable . ".", "", $joinedColumnes[1]);
                        $mainTableColumn = str_replace($mainTable . ".", "", $joinedColumnes[0]);
                    }

                    $generatedOptions = "";

                    $joinedTableRows = $this->CI->db->select("$configIndex, $joinTable.$joinTableColumn")
                            ->from($joinTable)
                            ->get()
                            ->result_array();


                    $vdValue = set_value($mainTableColumn);

                    if ($vdValue == "")
                        $vdValue = $fieldDefaultValue;

                    foreach ($joinedTableRows as $row) {

                        if ($row[$fieldName] == $vdValue) {
                            $vdValue = $row[$joinTableColumn];
                        }

                        $option = "<option value='$row[$joinTableColumn]'>$row[$fieldName]</option>";
                        $generatedOptions .= $option;
                    }

                    $joinedEntity = str_replace("lookup_", "", $joinTable);
                    $joinedEntity = str_replace("tbl_", "", $joinedEntity);
                    $field = str_replace("##LOOKUPNEW##", site_url("admin/dashboard/$joinedEntity" . "_auth"), $field);

                    $field = str_replace("##default##", $vdValue, $field);

                    $field = str_replace("##name##", $mainTableColumn, $field);
                    $field = str_replace("##OPTIONS##", $generatedOptions, $field);
                }
//                $joinedTable = $this->CI->db
//                        ->select("")
//                        ->get()->row_array();
            }
        } else {

            $vdValue = set_value($fieldName);

            if ($vdValue != "")
                $field = str_replace("##default##", $vdValue, $field);
            else
                $field = str_replace("##default##", $fieldDefaultValue, $field);


            $field = str_replace("##name##", $fieldName, $field);
        }


        return $field;
    }

    /**
     * 
     * @param type $configIndex
     * @param type $configValue 
     */
    public function makeField($configIndex, $configValue, $oldData = false, $item_id = 0) {

        $field = explode(".", $configIndex);
        $fieldName = $field[1];

        $prop = explode("#", $configValue);
        $fieldType = $prop[0];


        if ($oldData != false) {
            $fieldDefaultValue = $oldData[$fieldName];
        } else {
            $fieldDefaultValue = $prop[1];
        }

        $fieldHelp = $prop[2];

        $fieldDisplayName = $prop[3];
        if ($fieldDisplayName == "") {
            $fieldDisplayName = ucwords(str_replace("_", " ", $fieldName));
        }

        $fieldValidation = $prop[4];

        return $this->generateField($fieldName, $fieldType, $fieldDefaultValue, $fieldHelp, $fieldDisplayName, $configIndex, $item_id);
    }

    /**
     * Generate Form Validation Rules
     * @param type $entity
     * @return type 
     */
    public function generateRules($entity, $item_id = 0) {


        $validationRules = array();

        foreach ($entity["select"] as $configIndex => $configValue) {

            $field = explode(".", $configIndex);
            $prop = explode("#", $configValue);



            if ($configIndex != $entity["action_key"]) {  //Exception is hidden Primary Key fields
                $fieldName = $field[1];
                $fieldDisplayName = $prop[3];
                $fieldType = $prop[0];

                if ($fieldDisplayName == "")
                    $fieldDisplayName = ucwords(str_replace("_", " ", $fieldName));

                $fieldValidation = $prop[4];


                if ($fieldType == "select") {
                    foreach ($entity["join"] as $joinTable => $joinCondition) {
                        if (strstr($configIndex, $joinTable)) {

                            $mainTable = $entity["from"];
                            $joinedColumnes = explode("=", $joinCondition);
                            $joinedColumnes[0] = trim($joinedColumnes[0]);
                            $joinedColumnes[1] = trim($joinedColumnes[1]);

                            if (strstr($joinedColumnes[0], $joinTable)) {
                                /**
                                 * This column is from joined table 
                                 */
                                $joinTableColumn = str_replace($joinTable . ".", "", $joinedColumnes[0]);
                                $mainTableColumn = str_replace($mainTable . ".", "", $joinedColumnes[1]);
                            } else {
                                $joinTableColumn = str_replace($joinTable . ".", "", $joinedColumnes[1]);
                                $mainTableColumn = str_replace($mainTable . ".", "", $joinedColumnes[0]);
                            }

                            $rule = array(
                                "field" => $mainTableColumn,
                                "label" => $fieldDisplayName,
                                "rules" => $fieldValidation
                            );

                            $validationRules[] = $rule;
                        }
                    }
                } else {

                    $rule = array(
                        "field" => $fieldName,
                        "label" => $fieldDisplayName,
                        "rules" => $fieldValidation
                    );

                    if (($item_id != 0) && (strstr($fieldValidation, "unique"))) {
                        //Its an edit and there seems to be unique validation
                        $all_field_rules = explode("|", $fieldValidation);
                        $valid_rules = array();
                        foreach ($all_field_rules as $aRule) {
                            if (strstr($aRule, "unique")) {
                                
                            } else {
                                $valid_rules[] = $aRule;
                            }
                        }

                        $valid_rules = implode("|", $valid_rules);
                        $rule["rules"] = $valid_rules;
                    }

                    $validationRules[] = $rule;
                }
            }
        }

        return $validationRules;
    }

    /**
     * Generate Form
     * @param type $entity
     * @param type $oldData
     * @return type 
     */
    public function generate($entity, $oldData = false, $item_id = 0) {


        $this->currentEntity = $entity;

        $form = "";
        foreach ($entity["select"] as $aFieldColumnName => $fieldType) {

            if ($aFieldColumnName == $entity["action_key"]) {
                $form .= $this->makeField($aFieldColumnName, "hidden#$entity[action_val]###");
            } else {
                $form .= $this->makeField($aFieldColumnName, $fieldType, $oldData, $item_id);
            }
        }


        /**
         * Add the buttons
         */
        $btnStrip = $this->buttonStripWrapper;

        $actions = $entity["actions"];
        unset($actions["edit"]);

        $buttons = "";
        foreach ($actions as $action => $controller) {
            $link = $this->linkTemplate;

            if ($action == "delete" && $oldData != false) {

                $link = str_replace("##ATR##", 'onclick="return confirmDelete()"', $link);
                $link = str_replace("##HREF##", site_url("admin/dashboard/$controller/$entity[action_val]"), $link);
                $link = str_replace("##TEXT##", '<i class="fa fa-trash-o"></i>&nbsp; Delete', $link);
                $link = str_replace("##CLASS##", "danger", $link);
            } elseif ($action != "delete" && $oldData != false) {

                $link = str_replace("##ATR##", '', $link);
                $link = str_replace("##HREF##", site_url("admin/dashboard/$controller/$entity[action_val]"), $link);
                $link = str_replace("##TEXT##", '<i class="fa fa-star"></i>&nbsp; ' . $action, $link);
                $link = str_replace("##CLASS##", "primary", $link);
                $link .="&nbsp;";
//                $link = "";
            } else {
                $link = "";
                $link .="&nbsp;";
            }

            $buttons .= $link;
        }



        $btnStrip = str_replace("##EXTRABTNS##", $buttons, $btnStrip);
        $form .= $btnStrip;

        return $form;
    }

    /**
     * Select Row by ID 
     * @param type $entity
     * @param type $id
     * @return type 
     */
    public function selectEntityRowById($entity, $id) {
        /**
         * SELECT $_* FROM  $_*
         */
        $selectColumns = array();
        foreach ($entity["select"] as $column => $prop) {
            $selectColumns[] = $column;
        }

        $select = implode(",", $selectColumns);
        $this->CI->db
                ->select($select)
                ->from($entity['from']);

        /**
         *  JOIN $_* ON $_* 
         */
        if (isset($entity["join"])) {
            foreach ($entity["join"] as $joinTable => $joinCodition) {
                $this->CI->db->join($joinTable, $joinCodition);
            }
        }

        $this->CI->db->where($entity["action_key"], $id);

        return $this->CI->db->get()->row_array();
    }

    /**
     * Save entity to database.
     * @param type $entity
     * @param type $postData
     * @return type 
     */
    public function saveEntity($entity, $postData) {

        $table = $entity["from"];
        $primary_key = str_replace("$table.", "", $entity["action_key"]);
        $id = $postData[$primary_key];

        unset($postData[$primary_key]);
        unset($postData["action"]);


        $update_data = $postData;


        foreach ($entity["select"] as $column => $prop) {

            $field = explode(".", $column);
            $fieldName = $field[1];
//            unset($update_data["$fieldName"]);
//                  echo "1)<pre>";
//            print_r($update_data);

            if (strstr($prop, "images")) {
                
                unset($update_data["$fieldName"]);
                /**
                 * Upload All Images 
                 */
                $imageArray = array();
                $config['upload_path'] = './content/image/';
                $allowedExts = array("jpeg", "jpg", "png");
                $maxSize = 3145728; //3MB



                foreach ($_FILES as $key => $imgFiles) {

                    foreach ($imgFiles["tmp_name"] as $fileIndx => $fileTmpName) {

                        $temp = explode(".", $imgFiles["name"][$fileIndx]);
                        $extension = strtolower(end($temp));

                        if (( ($imgFiles["type"][$fileIndx] == "image/jpeg")
                                || ($imgFiles["type"][$fileIndx] == "image/jpg")
                                || ($imgFiles["type"][$fileIndx] == "image/pjpeg")
                                || ($imgFiles["type"][$fileIndx] == "image/x-png")
                                || ($imgFiles["type"][$fileIndx] == "image/png"))
                                && ($imgFiles["size"][$fileIndx] < $maxSize)
                                && in_array($extension, $allowedExts)) {

                            if ($imgFiles["error"][$fileIndx] > 0) {
                                
                            } else {

                                $fileNameOnServer = filenameprep($imgFiles["name"][$fileIndx]);

                                if (file_exists($config['upload_path'] . $fileNameOnServer)) {
                                    $fileNameOnServer = time() . $fileNameOnServer;
                                    //File exists use a custom name
                                    move_uploaded_file($imgFiles["tmp_name"][$fileIndx], $config['upload_path'] . $fileNameOnServer);
                                    $imageArray[] = $fileNameOnServer;
                                } else {
                                    //File not duplicate use existing name
                                    move_uploaded_file($imgFiles["tmp_name"][$fileIndx], $config['upload_path'] . $fileNameOnServer);
                                    $imageArray[] = $fileNameOnServer;
                                }
                            }
                        }
                    }
                }


                /**
                 * Its an edit 
                 */
                if ($id != 0) {

                    $prev = $this->CI
                            ->db->select("*")
                            ->from($entity["from"])
                            ->where($entity["action_key"], $id)
                            ->get()
                            ->row_array();

                    $old_images = explode(",", trim($prev[$fieldName], " ,"));
                    $imageArray = array_merge($old_images, $imageArray);
                    $update_data[$fieldName] = trim(implode(",", $imageArray),", ");
                } else {
                    /**
                     * Insert 
                     */
                    $update_data[$fieldName] = implode(",", $imageArray);
                }
            } elseif (strstr($prop, "image")) {

                unset($update_data["$fieldName"]);


                if ($_FILES[$fieldName]['name'] != "") {

                    /**
                     * Prep upload 
                     */
                    $config = array();
                    $config['upload_path'] = './content/image/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['overwrite'] = FALSE;

                    $this->CI->load->library('upload', $config);

                    if (!$this->CI->upload->do_upload($fieldName)) {
                        //If error do nothing special
                    } else {
                        $data = array('upload_data' => $this->CI->upload->data());
                        $update_data[$fieldName] = $data['upload_data']['file_name'];

                        if ($id != 0) {

                            $prev = $this->CI
                                    ->db->select("*")
                                    ->from($entity["from"])
                                    ->where($entity["action_key"], $id)
                                    ->get()
                                    ->row_array();


                            //Delete previous file
                            $prev_file = "./content/image/$prev[$fieldName]";

                            if (file_exists($prev_file)) {
                                unlink($prev_file);
                            }
                        }
                    }
                }
            } elseif (strstr($prop, "file")) {

                unset($update_data["$fieldName"]);


                if ($_FILES[$fieldName]['name'] != "") {

                    /**
                     * Prep upload 
                     */
                    $config = array();
                    $config['upload_path'] = './content/files/';
                    $config['allowed_types'] = 'jpg|jpeg|png|doc|docx|pdf|rtf|txt|text|xls|xlsx|csv';
                    $config['overwrite'] = FALSE;

                    $this->CI->load->library('upload', $config);

                    if (!$this->CI->upload->do_upload($fieldName)) {
                        //If error do nothing special
                    } else {
                        $data = array('upload_data' => $this->CI->upload->data());
                        $update_data[$fieldName] = $data['upload_data']['file_name'];

                        if ($id != 0) {

                            $prev = $this->CI
                                    ->db->select("*")
                                    ->from($entity["from"])
                                    ->where($entity["action_key"], $id)
                                    ->get()
                                    ->row_array();


                            //Delete previous file
                            $prev_file = "./content/files/$prev[$fieldName]";

                            if (file_exists($prev_file)) {
                                unlink($prev_file);
                            }
                        }
                    }
                }
            }
        }

//
//        echo "2)<pre>";
//        print_r($update_data);
//        exit();


        if ($id == 0) {
            $this->CI->db->insert($entity["from"], $update_data);
        } else {
            $this->CI->db->where($entity["action_key"], $id);
            $this->CI->db->update($entity["from"], $update_data);
        }


        return $this->CI->db->affected_rows();
    }

    /**
     * Get title of entity
     * @param type $table
     * @return type 
     */
    public function title($table) {
        $title = str_replace("tbl_", "", $table);
        $title = str_replace("lookup_", "", $title);

        $title = ucfirst($title);
        return $title;
    }

}

