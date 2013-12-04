<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller
{

  /**
   * email_verify
   *
   * Check if email is avaliable
   *
   * @param int $state_id
   * @access public
   * @return json
   */
  public function email_verify() {
    $return = array();
    $email = $this->input->post('email');
    $user = new User();
    $user->where("email", $email)->get();
    $return = ($user->exists()) ? FALSE : TRUE;
    echo json_encode($return);
  }

  /**
   * get
   *
   * Get the users
   *
   * @access public
   * @return json
   */
  public function get() {
    $return = array();
    $users = new User();
    $users->order_by('name', 'asc');
    $users->get();
    foreach ($users as $user) {
      $return[] = array(
        "id" => $user->id,
        'name' => $user->name
        );
    }
    echo json_encode($return);
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
      # Define Vote class
      $vote = new User_Vote();
      $vote->where('user_id', $this->input->get('id') )
           ->where('user_voted_id', $this->session->userdata('id') )
           ->get();

      # Instanciate a new user
      $user = new User($this->input->get('id'));

      # Check if the disponibility has already been voted
      if( $vote->exists() )
      {
        # Delete the vote
        $vote->delete();

        # Send the response
        echo json_encode(array('result' => 'alert', 'text' => "Você deixou de seguir \"{$user->name} {$user->surname}\"."));

      }else{
        # Set variables
        $vote->user_id = $this->input->get('id');
        $vote->user_voted_id = $this->session->userdata('id');

        # Save into database
        $vote->save();

        echo json_encode(array('result' => 'success', 'text' => "Agora você está seguindo \"{$user->name} {$user->surname}\"."));
      }
    }else{
      echo json_encode(
        array('result' => 'error', 'text' => "Você precisa fazer login na Galatea para seguir alguém.")
      );
    }

  }

  /**
   * Add a new message that come from form
   * @return JSON Message data
   */
  public function send_message()
  {
    $this->load->helper('message_date');

    # Get values from submit
    {
      $user_id   = $this->input->get('id');
      $sender_id = $this->input->get('sender_id');
      $message   = $this->input->get('message');
      $parent_id = $this->input->get('parent_id');
      $type      = $this->input->get('type');
    }

    # Check if some logged user was set up
    if($sender_id == 'NaN' && $type == 1) exit('É necessário estar autenticado para enviar uma mensagem');

    # Instantiate user message and define variables
    {
      $user_message = new User_Message();
      $user_message->user_id   = $user_id;
      $user_message->sender_id = $sender_id;
      $user_message->message   = $message;
      $user_message->parent_id = $parent_id;
      $user_message->type      = $type;
      $user_message->save();
    }

    # Create array to be passed as a file format
    $result = array(
      'datetime'     => message_date($user_message->create_date),
      'id'           => $user_message->id,
      'message'      => $user_message->message,
      'parent_id'    => $user_message->parent_id,
      'user_name'    => $user_message->sender->name,
      'user_profile' => site_url("site/users/profile/{$user_message->sender_id}")
    );

    # Return JSON format
    echo json_encode($result);
  }

  /**
   * Delete user message
   * @return void
   */
  public function delete_message()
  {
    # Get values from submit
    $message_id = $this->input->get('id');

    # Get actual date and time
    $datetime = date('Y-m-d h:m:s');

    # Instanciate the user message and define delete date
    {
      $user_message = new User_Message($message_id);
      $user_message->delete_date = $datetime;
      $user_message->save();
    }

    $parent_message = new User_Message();
    $messages = $parent_message->where('parent_id', $message_id)->get();

    # Check if the message have any parent message
    if( $messages->exists() )
    {
      # Remove all parents
      foreach($messages as $message){
        $message->delete_date = $datetime;
        $message->save();
      }
    }
  }

  /**
   * Create a clean delivery address form
   * @return void
   */
  public function deliveryAddressForm()
  {
    # Get all countries informations
    $countries = new Country();
    $countries->get();

    # Define countries list
    $data['countries']['all'] = $countries->all_to_single_array('name');

    # Define dafaul user country
    $data['countries']['user'] = 36; # 36 is the Brasil ID into database

    # Print the view
    echo $this->load->view('site/user/edit/delivery_address_new', $data, TRUE);
  }

}

/* End of file users.php */
/* Location: ./application/controllers/ajax/users.php */
