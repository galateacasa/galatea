<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vitrine extends CI_Controller {

  public function index(){
    $toview['vitrine'] = array();
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Vitrine' => site_url('admin/vitrine')
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_style(assets_url('js/plugins/gridster/jquery.gridster.css'));
    $this->template->set_script(assets_url('js/plugins/gridster/jquery.gridster.js'));
    $this->template->set_script(assets_url('js/admin/vitrine/index.js'));
    $this->template->load('admin', 'admin/vitrine/index', $toview);
  }

}

/* End of file vitrine.php */
/* Location: ./application/controllers/admin/vitrine.php */
