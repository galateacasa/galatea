<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
  private $quantity = 2;

  public function loadMore() {
    // Load libraries
    $this->load->library( array('social_links', 'vote_button', 'denounce_button') );

    // Projects
    $projects = new Item();
    $projects->where( array('status' => 1, 'type' => 1, 'delivery_date <' => date('Y-m-d'),'delete_date IS NULL --' => '') )
             ->limit(4)
             ->get();

    // Products
    $products = new Item();
    $products->where( array('status' => 1, 'type' => 2) )
             ->limit(4)
             ->get();

      //Ambiances
      $ambiances = new Ambiance();
      $ambiances->limit( ceil($products->result_count() / 2) )
                ->get();

    $home_layouts    = new Home_Layout(); // New e Layout
    $social_links    = new Social_Links(); // Social Links
    $vote_button     = new Vote_Button(); // Vote button
    $denounce_button = new Denounce_button(); // Denounce button
    $categories      = new Category();
    $carroussels     = new Carroussel();

    {
      $toview['home_layouts']    = $home_layouts->order_by('id', 'desc')
                                                ->limit($this->quantity, $this->input->post('page') * $this->quantity)
                                                ->get();
      $toview['social_links']    = $social_links;
      $toview['vote_button']     = $vote_button;
      $toview['denounce_button'] = $denounce_button;
      $toview['products']        = $products;
      $toview['projects']        = $projects;
      $toview['ambiances']       = $ambiances;
      $toview['title']           = 'Móveis online personalizados e objetos de decoração – Galatea Casa';
      $toview['categories']      = $categories->where('parent_id', 0)->get();
      $toview['carroussels']     = $carroussels->order_by('id', 'desc')->get();

      $toview['metas'] = meta(
        'description',
        'Encontre modelos únicos de poltronas, cadeiras, sofás e diversos móveis personalizados na Galatea, a sua loja de móveis online de alto padrão'
      );

      $toview['scripts'] = array(
        'plugins/jquery.ae.image.resize.min',
        'site/VerticalSlider',
        'site/util',
        'site/home'
      );

    }

      die($this->load->view('site/home-ajax', $toview, true));
    }
  }
