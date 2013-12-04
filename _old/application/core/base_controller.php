<?php

class Base_controller extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->verify_cookie();
  }


  /*
  * Verify if there is a cookie and try to login the user
   */
  function verify_cookie(){
    $cookie_user = $this->input->cookie('keep_logged_galatea');
    // die(var_dump($cookie_user));
    if ($cookie_user) {

    // find user id of cookie_user stored in application database
      $user = new User();
      $user->where('keep_logged_hash', $cookie_user)->get();
      if($user->exists()){
        // set session if necessary
        if (!$this->session->userdata('user')) {
          $usr = array(
            "id"    => $user->id,
            "name"  => $user->name,
            "email" => $user->email,
            "role"  => $user->role
            );
          $this->session->set_userdata("user", $usr);
        }
      }
    }
  }

}

/* End of file base_controller.php */
/* Location: ./application/core/base_controller.php */
