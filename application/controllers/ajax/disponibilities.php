<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

  class Disponibilities extends CI_Controller
  {
    /**
     * Logged user ID
     * @var integer
     */
    private $user_id;

    /**
     * Disponibility ID
     * @var integer
     */
    private $disponibility_id;

    public function __construct()
    {
      parent::__construct();

      # Define logged user ID
      $this->user_id = $this->input->get('user_id');

      # Define disponibility ID
      $this->disponibility_id = $this->input->get('id');
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
        # Get disponibility ID
        $disponibility_id = $this->input->get('id');

        # Get user ID
        $vote = new Item_Vote();
        $vote->where('item_id', $disponibility_id)
             ->where('user_id', $this->session->userdata('id'))
             ->get();

        # Instanciate a new product
        $product = new Item($disponibility_id);

        # Check if the disponibility has already been voted
        if( $vote->exists() )
        {
          # Delete the vote
          $vote->delete();

          # Send the response
          echo json_encode(array('result' => 'alert', 'text' => "O produto \"{$product->name}\" foi retirado de seus favoridos"));

        }else{
          # Set variables
          $vote->item_id = $disponibility_id;
          $vote->user_id = $this->session->userdata('id');

          # Save into database
          $vote->save();

          echo json_encode(array('result' => 'success', 'text' => "O produto \"{$product->name}\" foi adicionado aos seus favoritos"));
        }
      }else{
        echo json_encode(array('result' => 'error', 'text' => "Para adicionar produtos aos favoritos, é necessário que você esteja logado na Galatea"));
      }

    }

    /**
     * Denounce a disponibility
     * @return void
     */
    public function denounce()
    {
      $denounce = new Disponibility_Denounce();
      $denounce->user_id = $this->user_id;
      $denounce->disponibility_id = $this->disponibility_id;
      $denounce->get_where( array('user_id' => $this->user_id, 'disponibility_id' => $this->disponibility_id) );

      # Check if the user already renounced the disponibility
      if( !$denounce->exists() )
      {
        $denounce->user_id = $this->user_id;
        $denounce->disponibility_id = $this->disponibility_id;
        $denounce->save();
      }
    }
  }

?>
