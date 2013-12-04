<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends CI_Controller {

  public function capture() {
    $email = trim($this->input->get_post('email'));

    if ($email) {
      $capture = new Capture();
      $capture->email = $email;
      $capture->save();

      die(json_encode(array('success' => true)));
    }

    die(json_encode(array('success' => false)));
  }

  public function abril() {
    $name  = trim($this->input->get_post('name'));
    $email = trim($this->input->get_post('email'));
    $reason = trim($this->input->get_post('reason'));

    if ($name && $email && $reason) {
      $abril = new Abril();
      $abril->name = $name;
      $abril->email = $email;
      $abril->reason = $reason;
      $abril->save();

      die(json_encode(array('success' => true)));
    }

    die(json_encode(array('success' => false)));
  }
}
