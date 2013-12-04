<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

/**
 * Some actions for ambiance area
 *
 * PHP 5.3+
 *
 * @category Galatea
 * @package Controllers
 * @subpackage Sites
 * @author Diogo Lacerda <diogo.lacerda@gmail.com>
 * @author Arthur Duarte <arthur@aduarte.net>
 * @see CI_Controller
 */
class Ambiances extends CI_Controller
{
  /**
   * Define Amazon URL for images
   * @var string
   */
  private $amazon_url;

  /**
   * URL for category AJAX request
   * @var string
   */
  private $category_ajax_url;

  private $form_rules = array(

    // Name
    array(
      'field' => 'title',
      'label' => 'Título',
      'rules' => 'required|alpha',
    ),

    // Image
    array(
      'field' => 'image',
      'label' => 'Imagem',
      'rules' => 'required',
    ),

    // Category
    array(
      'field' => 'main_category',
      'label' => 'Categoria',
      'rules' => 'required|is_natural_no_zero',
    )

  );

  /**
   * Initial actions
   */
  public function __construct()
  {
    parent::__construct();

    $this->load->helper('html');
    $this->load->library('social_links');

    // Define amazon URL
    $this->amazon_url = amazon_url('images/ambiances');

    // Get category URL to perform AJAX requests
    $this->category_ajax_url = site_url('ajax/categories/get');
  }

  /**
   * Main page
   *
   * @access public
   * @return void
   */
  public function index($ambianceId = false)
  {
    if ($ambianceId) {
      $data['ambianceId'] = $ambianceId;
    }

    // Define breadcrumbs
    $breadcrumbs['breadcrumbs'] = array(
      // Main page
      array(
        'href'  => site_url(),
        'title' => 'Página inicial',
        'name'  => 'Home'
      ),

      // Category page
      array(
        'href'  => site_url('site/categories/index'),
        'title' => 'Inspire-me',
        'name'  => 'Inspire-me'
      )
    );

    // Check if the form was submitted
    if( $this->input->post() ) {

      // Set validation rules
      $this->form_validation->set_rules($this->form_rules);

      // Check if the rules passed
      if( $this->form_validation->run() ) {

        // Check if the sub-category was submitted
        $category_id = $this->input->post('sub_category') ? $this->input->post('sub_category') : $this->input->post('main_category');

        // Instanciate a new ambiance object
        $ambiance = new Ambiance();

        // Set data to be inserted into database
          $ambiance->user_id     = $this->session->userdata('id');
          $ambiance->title       = $this->input->post('title');
          $ambiance->image       = $this->input->post('image');
          $ambiance->category_id = $category_id;
          $ambiance->status      = 0;

        // Create a new registry
        $ambiance->save();

        // Separete all products
        $products_ids = explode( ';', $this->input->post('product_ids') );

        // Create relationship between ambiance and all products
        foreach ($products_ids as $product_id) {
          $product = new Item();
          $product->get_by_id($product_id);
          $ambiance->save($product);
        }

        $this->session->set_flashdata('success', "O ambiente <strong>{$ambiance->title}</strong> foi criado com sucesso!");

      }else{
        // Set error message
        $this->session->set_flashdata('error', 'Preencha os campos obrigatórios');
      }

    }

    // Load needed helpers
    $this->load->helper( array('html', 'form') );

    // Load needed libraries
    $this->load->library( array('social_links', 'vote_button', 'denounce_button') );

    // Set a new category instance
    $categories = new Category();
    $categories->where('parent_id', 0)->order_by('name', 'ASC')->get(); // Get only main categories and order it ascending by name

    // Set a new ambiance instance
    $ambiances = new Ambiance();
    $ambiances->where('status', 1);

    // Check if any filter was submitted
    if( $this->input->get('filter') ) {

      // Switch the kind of filter
      switch ( $this->input->get('filter') ) {

        // Following
        case 'following':
          $ambiances->where_related('ambiance_vote', 'user_id', $this->session->userdata('id') );
          break;

        // Favorites
        case 'mine':
          $ambiances->where('user_id', $this->session->userdata('id') );
          break;

        // Most voted
        case 'most_voted':
          $ambiances->include_related_count('ambiance_vote');
          $ambiances->order_by('ambiance_vote_count', 'desc');
          break;

      }

    }

    // Default number of items that need to be shown
    $resultLimit = 50;

    // Filter the ambiance selection by the category if aplicable
    if( $this->input->get('category') ) $ambiances->where('category_id', $this->input->get('category') );

    // Order and limit the result and return it
    $ambiances->order_by('create_date', 'DESC')->limit($resultLimit, 0)->get();

    // Create array to create categories <ul> markup
    foreach($categories as $category)
      $data['li'][] = anchor("inspire-me/?category={$category->id}&filter=" . $this->input->get('filter'), $category->name);

    // Category menu
    {
      // categories filters
      $filters = array(

        array(
          'label'       => 'TUDO',
          'filter_name' => 0,
        ),

        array(
          'label'       => 'SEGUINDO',
          'filter_name' => 'following',
        ),

        array(
          'label'       => 'MINHAS',
          'filter_name' => 'mine',
        ),

        array(
          'label'       => 'POPULARES',
          'filter_name' => 'most_voted',
        ),

      );

      // Category title
      $lis[] = 'organizar por:';

      // Category list
      $lis[] = "<a href=\"//\" class=\"sort-link\">CATEGORIAS</a>" . sprintf('%s', ul($data['li'], 'class="sub-nav"') );

      // Mount filters mark-up
      foreach($filters as $filter) {

        // Default URL
        $href = 'inspire-me';

        // Check if any filter was set up
        if($filter['filter_name'])
          $href .= "?category=" . $this->input->get('category') . "&filter={$filter['filter_name']}";

        // Create <a> tag mark up
        $lis[] = anchor($href, $filter['label']);

      }

      // Mount <ul> mark up
      $data['ambiance_menu'] = ul($lis, 'class="nav-organize"');
    }

    // Define all necessary data
    {
      $data['breadcrumbs']       = $this->load->view('site/common/breadcrumbs', $breadcrumbs, true);
      $data['social_links']      = new Social_Links();
      $data['vote_button']       = new Vote_Button();
      $data['denounce_button']   = new Denounce_Button();
      $data['categories']        = $categories;
      $data['selected_category'] = $this->input->get('category');
      $data['ambiances']         = $ambiances;
      $data['resultLimit']       = $resultLimit;
    }

    // Define scripts that need to be included into the page
    $data['scripts'] = array(
      'plugins/customSelect.jquery',
      'plugins/jquery.imagesloaded.min',
      'plugins/jquery.masonry.min',
      'site/VerticalSlider',
      'site/thumb',
      'site/script',
      'site/ambiances/index',
    );

    $this->load->view('site/common/header/main', $data);
    $this->load->view('site/ambiance/page', $data);
    $this->load->view('site/ambiance/sections/categories', $data);
    $this->load->view('site/common/footer/main', $data);

  }

}
