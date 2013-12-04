<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

/**
 * Actions related to ambiances AJAX requests
 *
 * PHP 5.3+
 *
 * @category Galatea
 * @package Controllers
 * @subpackage Ajax
 * @author Diogo Lacerda <diogo.lacerda@gmail.com>
 * @author Arthur Duarte <arthur@aduarte.net>
 * @see CI_Controller
 */
class Ambiances extends CI_Controller
{
  /**
   * User ID
   * @var integer
   */
  private $user_id;

  /**
   * Ambiance ID
   * @var integer
   */
  private $ambiance_id;

  public function __construct()
  {
    parent::__construct();

    # Define user ID
    $this->user_id = $this->input->get('user_id');

    # Define ambiance ID
    $this->ambiance_id = $this->input->get('id');
  }

  /**
   * Create a new ambiance entry
   * @return void
   */
  public function newEntry()
  {
    // Instanciate a new ambiance object
    $ambiance = new Ambiance();

    // Set data to be inserted into database
    {
      $ambiance->user_id     = $this->session->userdata('id');
      $ambiance->title       = $this->input->get('title');
      $ambiance->image       = $this->input->get('image');
      $ambiance->category_id = $this->input->get('category');
      $ambiance->status      = 1;
    }

    // Create a new registry
    $ambiance->save();

    // Separete all products
    $products_ids = explode( ';', $this->input->get('products_ids') );

    // Create relationship between ambiance and all products
    foreach ($products_ids as $product_id) {
      $product = new Item();
      $product->get_by_id($product_id);
      $ambiance->save($product);
    }
  }

  /**
   * get
   *
   * Get the ambiances
   *
   * @access public
   * @return json
   */
  public function get()
  {

    $return = array();
    $ambiances = new Ambiance();
    $ambiances->order_by('name', 'asc');
    $ambiances->get();

    foreach ($ambiances as $ambiance) {

      $return[] = array(
        'id'   => $ambiance->id,
        'name' => $ambiance->name
      );

    }

    echo json_encode($return);

  }

  /**
   * Load specific view to be added into the ambiances list
   *
   * @access public
   * @return HTML Specific view to be added to the website
   */
  public function loadMore()
  {

    // Instanciate new ambiance class
    $ambiances = new Ambiance();
    $ambiances->order_by('create_date', 'DESC')
              ->limit(1, $this->input->get('start') )
              ->get();

    // Load the required libraries
    $this->load->library( array('vote_button', 'denounce_button', 'social_links') );

    // Define view variables
    $data = array(
      'ambiances'       => $ambiances,
      'vote_button'     => new Vote_Button(),
      'denounce_button' => new Denounce_Button(),
      'social_links'    => new Social_Links(),
    );

    if ($ambiances->result_count() > 0) {
      echo $this->load->view('site/ambiance/sections/content', $data, TRUE);
    }else{
      echo 'vazio';
    }

  }

  /**
   * Vote or unvote the disponibility
   * @return void
   */
  public function vote()
  {
    // Check if the user is logged in
    if( $this->session->userdata('id') )
    {
      // Instanciate a new vote
      $vote = new Ambiance_Vote();
      $vote->where('user_id', $this->session->userdata('id') )
           ->where('ambiance_id', $this->input->get('id') )
           ->get();

      // Instanciate a new product
      $ambiance = new Ambiance($this->input->get('id'));

      // Check if the ambiance has already been voted
      if( $vote->exists() )
      {
        // Delete the vote
        $vote->delete();

        // Send the response
        echo json_encode(array('result' => 'alert', 'text' => "O ambiente \"{$ambiance->title}\" foi retirado de seus favoridos"));

      }else{
        // Set variables
        $vote->ambiance_id = $this->input->get('id');
        $vote->user_id = $this->session->userdata('id');

        // Save into database
        $vote->save();

        // Send message
        echo json_encode(array('result' => 'success', 'text' => "O ambiente \"{$ambiance->title}\" foi adicionado aos seus favoritos"));
      }
    }else{
      echo json_encode(
        array('result' => 'error', 'text' => "Faça login na Galatea para adicionar ambientes como favoritos.")
      );
    }

  }

  /**
   * Denounce an ambiance
   * @return void
   */
  public function denounce()
  {
    // Create a new denounce
    $denounce = new Ambiance_Denounce();
    $denounce->user_id = $this->user_id;
    $denounce->ambiance_id = $this->ambiance_id;
    $denounce->get_where( array('user_id' => $this->user_id, 'ambiance_id' => $this->ambiance_id) );

    // Check if the user already renounced the disponibility
    if( !$denounce->exists() )
    {
      $denounce->user_id = $this->user_id;
      $denounce->ambiance_id = $this->ambiance_id;
      $denounce->save();
    }
  }

  /**
   * Mount ambiance show pop-up
   * @return string HTML markup for pop-up
   */
  public function mount_pop_up()
  {
    // Check if the ambiance ID was sent
    if( $this->input->get('ambiance_id') )
    {
      // Instanciate the ambiance
      $ambiance = new Ambiance( $this->input->get('ambiance_id') );

      // Load needed libraries
      $this->load->library( array('social_links', 'vote_button', 'denounce_button') );

      // Define social links
      $data['social_links'] = new Social_Links();

      // Define vote button
      $data['vote_button'] = new Vote_Button();

      // Define denounce button
      $data['denounce_button'] = new Denounce_Button();

      // Define ambiance data
      $data['ambiance'] = $ambiance;

      // Print out the view
      echo $this->load->view('site/ambiance/sections/pop_up', $data, TRUE);
    }else{
      echo "Não foi possível carregar o ambiante solicitado.";
    }

  }
}

?>