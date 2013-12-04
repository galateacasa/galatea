<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Items extends CI_Controller
{

  /**
   * Logged user ID
   * @var integer
   */
  public $user_id;

  /**
   * Item ID
   * @var integer
   */
  public $item_id;

  public function __construct()
  {
    parent::__construct();

    # Define user ID
    $this->user_id = $this->input->get('user_id');

    # Define item ID
    $this->item_id = $this->input->get('id');
  }

  /**
   * get
   *
   * Get the items
   *
   * @access public
   * @return json
   */
  public function get() {
    $return = array();
    $items = new Item();
    $items->order_by('name', 'asc');
    $items->get();
    foreach ($items as $item) {
      $return[] = array(
        'id' => $item->id,
        'name' => $item->name
        );
    }
    echo json_encode($return);
  }

  /**
   * get_measurements
   *
   * Get the item measurements variation
   *
   * @access public
   * @return json
   */
  public function get_measurements($item_id) {
    $return = array();
    $item = new Item($item_id);

    $measurements = new Item_Variation_Measurement();
    $measurements->where_related($item)
                 ->get();

    foreach ($measurements as $measure) {
      $return[] = array(
        'id' => $measure->id,
        'name' => $measure->width." cm ".$measure->height." cm ".$measure->depth,
        'addtional_amount' => $measure->addtional_amount,
        'addtional_type' => $measure->addtional_type
        );
    }
    echo json_encode($return);
  }

  /**
   * Get products by their name
   * @return JSON Products descriptions
   */
  public function get_by_name()
  {
    # Define keyword
    $name = $this->input->get('keyword');

    # Define filter
    $filter = $this->input->get('filter');

    # Get all products that match with the keyword
    $products = new Item();
    $products->where( array('status' => 1, 'type' => 2) )
             ->like('name', $name);

    # Check if need to filter by user preferences
    if($filter == 'favorites') $products->where_related_item_vote( 'user_id', $this->session->userdata('id') );

    # Get all products
    $products->get();

    # Get all image products and prepare for JSON conversion
    foreach( $products as $product )
    {
      # Convert data to array
      $result = $product->to_array();

      # Get image reference
      $result['image'] = $product->item_image->get()->image;

      # Add data to main array
      $results[] = $result;
    }

    # Return result as JSON format
    echo isset($result) ? json_encode($results) : json_encode( array() );
  }

  /**
   * Vote or unvote the disponibility
   * @return void
   */
  public function vote()
  {
    # Check if the user is logged in
    if( $this->session->userdata('id') )
    {
      # Get user ID
      $vote = new Item_Vote();
      $vote->where('item_id', $this->input->get('id'))
           ->where('user_id', $this->session->userdata('id'))
           ->get();

      # Instanciate a new product
      $project = new Item($this->input->get('id'));

      # Check if the disponibility has already been voted
      if( $vote->exists() )
      {
        # Delete the vote
        $vote->delete();

        # Send the response
        echo json_encode(array('result' => 'alert', 'text' => "O seu voto para o projeto \"{$project->name}\" foi removido."));

      }else{
        # Set variables
        $vote->item_id = $this->input->get('id');
        $vote->user_id = $this->session->userdata('id');

        # Save into database
        $vote->save();

        echo json_encode(array('result' => 'success', 'text' => "Voto computado para o projeto \"{$project->name}\"."));
      }
    }else{
      echo json_encode(
        array('result' => 'error', 'text' => "Você precisa fazer login na Galatea para votar em projetos")
      );
    }

  }

  /**
   * Denounce an item
   * @return void
   */
  public function denounce()
  {
    $denounce = new Item_Denounce();
    $denounce->user_id = $this->user_id;
    $denounce->item_id = $this->item_id;
    $denounce->get_where( array('user_id' => $this->user_id, 'item_id' => $this->item_id) );

    # Check if the user already denounced
    if( !$denounce->exists() )
    {
      $denounce->user_id = $this->user_id;
      $denounce->item_id = $this->item_id;
      $denounce->save();

      # Define result
      $result['message'] = 'Obrigado por nos notificar';
      $result['type']    = 'success';
    }else{

      # Define result
      $result['message'] = 'Você já denunciou este item, estamos averiguando. Mais uma vez obrigado!';
      $result['type']    = 'error';
    }

    # Print the result as a JSON
    echo json_encode($result);
  }

  /**
   * Add a new message that come from form
   * @return JSON Message data
   */
  public function send_message()
  {
    // The user is logged in?
    if ( !$this->session->userdata('id') ) {
      echo json_encode('error', 'É necessário estar logado para postar comentários');
    }

    // Helper to convert mysql datetime
    $this->load->helper('message_date');

    // Get values from submit
    {
      $item_id   = $this->input->get('id');
      $sender_id = $this->input->get('sender_id');
      $message   = $this->input->get('message');
      $parent_id = $this->input->get('parent_id');
      $type      = $this->input->get('type');
    }

    // Instanciate item message and define variables
    {
      $item_message = new Item_Message();
      $item_message->item_id   = $item_id;
      $item_message->sender_id = $sender_id;
      $item_message->message   = $message;
      $item_message->parent_id = $parent_id;
      $item_message->type      = $type;
      $item_message->status    = 1;
      $item_message->save();
    }

    // Create array to be passed as a JSON format
    $result = array(
      'datetime'     => message_date($item_message->create_date),
      'id'           => $item_message->id,
      'message'      => $item_message->message,
      'parent_id'    => $item_message->parent_id,
      'user_name'    => $item_message->sender->name,
      'user_profile' => site_url("site/users/profile/{$item_message->sender_id}")
    );

    // Return JSON format
    echo json_encode($result);
  }

  /**
   * Delete user message
   *
   * @access public
   * @return void
   */
  public function delete_message()
  {
    // Get values from submit
    $message_id = $this->input->get('id');

    // Instanciate the user message and define delete date
    {
      $item_message = new Item_Message($message_id);
      $item_message->status = 0;
      $item_message->save();
    }

    $parent_message = new Item_Message();
    $messages = $parent_message->where('parent_id', $message_id)->get();

    // Check if the message have any parent message
    if( $messages->exists() ) {

      // Remove all parents
      foreach($messages as $message){
        $message->status = 0;
        $message->save();
      }

    }

  }

  public function setItemMessageRead()
  {
    $message_id = $this->input->post('message_id');

    $item_message = new Item_Message($message_id);
    if(!$item_message->exists()){
      echo json_encode(array('success'=>false, 'error'=> 'Mensagem não encontrada.'));
      die();
    }

    $item_message->read_date = date('Y-m-d H:i:s');
    $item_message->save();
    echo json_encode(array('success'=>true));
  }

}

/* End of file items.php */
/* Location: ./application/controllers/ajax/items.php */
