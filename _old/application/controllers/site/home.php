<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

  class Home extends CI_Controller
  {

    /**
     * Main page
     * @return void
     */
    public function index()
    {

      // Load libraries
      $this->load->library( array('social_links', 'vote_button', 'denounce_button') );

      // Projects
      $projects = new Item();
      $projects->where( array('status' => 1, 'type' => 1, 'delivery_date <' => date('Y-m-d'),'delete_date IS NULL --' => '') )
               ->order_by("id", "random")
               ->limit(4)
               ->get();

      // Products
      $products = new Item();
      $products->where( array('status' => 1, 'type' => 2) )
               ->order_by("id", "random")
               ->limit(4)
               ->get();

      //Ambiances
      $ambiances = new Ambiance();
      $ambiances->order_by("id", "random")
                ->limit( ceil($products->result_count() / 2) )
                ->get();

      $home_layouts    = new Home_Layout(); // New e Layout
      $social_links    = new Social_Links(); // Social Links
      $vote_button     = new Vote_Button(); // Vote button
      $denounce_button = new Denounce_button(); // Denounce button
      $categories      = new Category();
      $carroussels     = new Carroussel();

      {
        $toview['home_layouts']    = $home_layouts->order_by('id', 'desc')->limit(2)->get();
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
          'plugins/jquery.cookie',
          'site/VerticalSlider',
          'site/util',
          'site/home'
        );

      }

      // Load views
      {
        $this->load->view('site/common/header/main', $toview);
        $this->load->view('site/common/header/categories', $toview);
        $this->load->view('site/common/header/carroussel', $toview);
        $this->load->view('site/home', $toview);
        $this->load->view('site/common/footer/main', $toview);
      }
    }

    public function search()
    {

      if( $this->input->post('search') ) {
        $search = $this->input->post('search');

            //Products
        $products = new Item();
        $products->where( array('status' => 1, 'type' => 2) )
                 ->like('name', $search)
                 ->order_by("create_date", "desc")
                 ->get();
        // die($products->check_last_query());
        $toview['products'] = $products;
        $toview['search'] = $search;

        $this->template->load('site', 'site/search', $toview);
      }else{
        redirect(site_url());
      }

    }

    function newsletter()
    {

      if ( $this->input->post() ) {

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ( !$this->form_validation->run() ) {
          $this->session->set_flashdata('error', validation_errors());
          redirect(site_url());
        }

        //$newsletter
        $news = new Newsletter();
        $news->where('email', $this->input->post('email'));
        $news->get();

        if ( $news->exists() ) {
          $this->session->set_flashdata('error', 'Email já cadastrado.');
          redirect();
        }

        $news->email = $this->input->post('email');

        if ( $news->save() ) {
          $this->session->set_flashdata('success', 'Obrigado por ser inscrever em nossa newsletter!.');
          redirect('site/home');
        }else{
          $this->session->set_flashdata('error', 'Ocorreu um erro na gravação do newsletter.');
          redirect(site_url('site/home'));
        }

      }

    }

  }

/* End of file home.php */
/* Location: ./application/controllers/site/home.php */
?>
