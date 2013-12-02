<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expertises extends CI_Controller {

  /**
   * get
   *
   * Get the expertises
   *
   * @access public
   * @return json
   */
  public function get() {
    $return = array();
    $expertises = new Expertise();
    $expertises->order_by('name', 'asc');
    $expertises->get();
    foreach ($expertises as $expertise) {
      $return[] = array(
        'id' => $expertise->id,
        'name' => $expertise->name,
        'description' => $expertise->description
        );
    }
    echo json_encode($return);
  }

}

/* End of file expertises.php */
/* Location: ./application/controllers/ajax/expertises.php */
