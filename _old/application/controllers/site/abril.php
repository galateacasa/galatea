<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Abril extends CI_Controller
{

  public function index()
  {
    $categories = new Category();

    $toview = array(
      'scripts' => array(
        'plugins/jquery.ae.image.resize.min',
        'plugins/jquery.mCustomScrollbar',
        'site/script',
        'site/thumb',
        'site/Dropdown',
        'site/disponibility/show',
        'site/HorizontalSlider'
      ),
      'categories' => $categories->where('parent_id', 0)->get(),
      'user' => new User($this->session->userdata('id'))
    );

    $this->load->view('site/common/header/main', $toview);
    $this->load->view('site/common/header/categories', $toview);
    $this->load->view('site/abril/concurso-cultural', $toview);
    $this->load->view('site/common/footer/main', $toview);
  }
}
