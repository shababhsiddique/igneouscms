<?php

/**
 * Simple Captcha Library
 * 
 * Simple captcha library for codeigniter without creating images in the filesystem
 * 
 * @author   : Dino (DBK)
 * @link     : http://technew.in
 * 
 */

class Simple_captcha {

  private $captcha_text = NULL;

  function __construct() {
    @session_start();
    $this->captcha_text = $this->random_string();
  }

  function set_captcha_session($captcha_area = '') {
    $session_name = 'captcha_' . $captcha_area;
    $_SESSION[$session_name] = $this->captcha_text;
  }

  function get_captcha_text($captcha_area = '') {
    $session_name = 'captcha_' . $captcha_area;
    if (isset($_SESSION[$session_name]))
      $this->captcha_text = $_SESSION[$session_name];
    else
      $this->captcha_text = NULL;
    unset($_SESSION[$session_name]);
    return $this->captcha_text;
  }

  function draw_captcha($captcha_area = '') {
    header("Content-type: image/png");
    $this->set_captcha_session($captcha_area);
    $text_arr = str_split($this->captcha_text, 1);
    $im = @imagecreate('150', '50');
    imageline($im, rand(0, 179), rand(0, 49), rand(0, 179), rand(0, 49), imagecolorallocate($im, rand(200, 255), rand(200, 255), rand(200, 255)));
    imageline($im, rand(0, 179), rand(0, 49), rand(0, 179), rand(0, 49), imagecolorallocate($im, rand(200, 255), rand(200, 255), rand(200, 255)));
    imageline($im, rand(0, 179), rand(0, 49), rand(0, 179), rand(0, 49), imagecolorallocate($im, rand(200, 255), rand(200, 255), rand(200, 255)));
    imageline($im, rand(0, 179), rand(0, 49), rand(0, 179), rand(0, 49), imagecolorallocate($im, rand(200, 255), rand(200, 255), rand(200, 255)));
    imageline($im, rand(0, 179), rand(0, 49), rand(0, 179), rand(0, 49), imagecolorallocate($im, rand(200, 255), rand(200, 255), rand(200, 255)));
    imagestring($im, 5, rand(30, 40), rand(11, 33), $text_arr[0], imagecolorallocate($im, rand(0, 100), rand(0, 100), rand(0, 100)));
    imagestring($im, 5, rand(50, 60), rand(11, 33), $text_arr[1], imagecolorallocate($im, rand(0, 100), rand(0, 100), rand(0, 100)));
    imagestring($im, 5, rand(70, 80), rand(11, 33), $text_arr[2], imagecolorallocate($im, rand(0, 100), rand(0, 100), rand(0, 100)));
    imagestring($im, 5, rand(90, 100), rand(11, 33), $text_arr[3], imagecolorallocate($im, rand(0, 100), rand(0, 100), rand(0, 100)));
    imagestring($im, 5, rand(110, 120), rand(11, 33), $text_arr[4], imagecolorallocate($im, rand(0, 100), rand(0, 100), rand(0, 100)));
    imagepng($im);
    imagedestroy($im);
  }

  function random_string() {
    $string = "23456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    return substr(str_shuffle($string), 0, 5);
  }

}

?>
