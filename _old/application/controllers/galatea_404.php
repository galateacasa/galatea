<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Galatea_404 extends CI_Controller {

  public function index(){
    # Products
    $products = new Item();
    $products->where( array('status' => 1, 'type' => 2) )
       ->order_by("id", "random")
      ->limit(2)
      ->get();

    //Ambiances
    $ambiances = new Ambiance();
    $ambiances->order_by("id", "random");
    $ambiances->limit(1);
    $ambiances->get();

    $toview['products'] = $products;
    $toview['ambiances'] = $ambiances;

    $this->template->load('site', 'site/error', $toview);
  }

}

/* End of file galatea_404.php */
/* Location: ./application/controllers/galatea_404.php */
