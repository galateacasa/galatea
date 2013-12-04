<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

  public function index(){
    if(!$this->session->userdata('admin')){
      redirect(site_url('admin/login'));
    }
    $usr = $this->session->userdata('admin');
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Dashboard' => site_url('admin')
    );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/dashboard');
  }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin/admin.php */
