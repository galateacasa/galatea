<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_balances extends CI_Controller {

  public function index(){
    $user_balances = new User_Balance();
    $user_balances->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $user_balances->order_by('create_date', 'desc');
    $toview['user_balances'] = $user_balances->get();
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Saldo do Usuário' => site_url('admin/user_balances')
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/user_balance/index', $toview);
  }

}

/* End of file user_balances.php */
/* Location: ./application/controllers/admin/user_balances.php */
