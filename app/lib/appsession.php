<?php

namespace Mvc\Lib;

class appSession extends \SessionHandler {


  private $s_name = 'MYSsS';
  private $max_s_life = 0;
  private $s_ssl = FALSE;
  private $s_http = true;
  private $s_path = '/';
  private $s_domain = '.mvc.org';
  private $s_save_path = SESSION_SAVE_PATH;
  private $s_sec = 'AES-128-ECB';
  private $s_ci_key = 'WYBHB-2018';
  private $time = 25;

  public function __construct() {

    ini_set('session.use.cookies',1);
    ini_set('session.use.only.cookies',1);
    ini_set('session.use.trans_sid',0);
    ini_set('session.save_handler', 'files');

    session_name($this->s_name);
    session_save_path($this->s_save_path);
    session_set_cookie_params(
      $this->max_s_life,
      $this->s_path,
      $this->s_domain,
      $this->s_ssl,
      $this->s_http
    );

    session_set_save_handler($this,true);

  }


  public function __get($key) {
    return FALSE !== $_SESSION[$key] ? $_SESSION[$key] : FALSE;
  }

  public function __set($key,$val) {
    $_SESSION[$key] = $val;
  }

  public function __isset($key) {
    return isset($_SESSION[$key]) ? true : false;
  }
  public function __unset($key) {
    unset($_SESSION[$key]);
  }


  public function kill()
  {
      session_unset();
      setcookie(
          $this->s_name, '', time() - 1000,
          $this->s_path, $this->s_domain,
          $this->s_ssl, $this->s_http
      );
      session_destroy();
  }

      public function read($id) {

      $data = openssl_decrypt(parent::read($id), $this->s_sec, $this->s_ci_key);
      return $data === false ? '' : $data;
      }

      public function write($id, $data){

          return parent::write($id, openssl_encrypt($data, $this->s_sec, $this->s_ci_key));
      }

      public function start() {
        if(session_id() === '') {
              if(session_start()) {
                $this->set_s_time();
                $this->check_s_valid();
              }
            }
          }

      private function set_s_time() {
        if(!isset($this->sessionStartTime)) {
          $this->sessionStartTime = time();
        }

        return true;
      }

      private function check_s_valid() {
        if((time() - $this->sessionStartTime) > ($this->time * 60 )) {
          $this->reSession();

        }
        return true;
      }


      private function reSession() {
        $this->sessionStartTime = time();
        return session_regenerate_id(true);

      }

}
