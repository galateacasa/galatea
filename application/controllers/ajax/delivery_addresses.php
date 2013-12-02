<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Delivery_Addresses extends CI_Controller {

  /**
   * verify_logistic
   * 
   * Check if delivery address is attended by logistics
   * 
   * @access public
   * @return json
   */
  public function verify_logistic()
  {
    # Clear the delivery address saved in session
    $this->session->unset_userdata('delivery_address_id');

    # Check if the address is a user default address or cames from the delivery address list
    if( $this->input->post('delivery_address_id') == 'default' ) {
      $data = new User( $this->session->userdata('id') );
      $from_user = TRUE;
    }else{
      $data = new Delivery_Address( $this->input->post('delivery_address_id') );
      $from_user = FALSE;
    }

    # Check if the data about the address exists
    if( $data->exists() )
    {
      # Instanciate a new city object
      $city = new City();
      $city->where( array('id' => $data->city->id, 'reached_by_logistics' => 1) )->get();

      # Check if the city is reached by logistics
      if( $city->exists() )
      {
        $return = TRUE;

        # Save the delivery address information in the session
        $this->session->set_userdata('delivery_address_id', $from_user ? 'default' : $this->input->post('delivery_address_id') );
        $this->session->set_userdata('delivery_address_valid', TRUE);
      }else{
        $return = FALSE;
      }

      # Return to the data
      echo json_encode($return);

    }else{
      echo json_encode(FALSE);
      die();      
    }

  }
}