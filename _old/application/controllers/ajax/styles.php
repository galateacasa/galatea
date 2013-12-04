<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Styles extends CI_Controller {

  /**
   * get
   *
   * Get the styles
   *
   * @access public
   * @return json
   */
  public function get() {
    $return = array();
    $styles = new Style();
    $styles->order_by('name', 'asc');
    $styles->get();
    foreach ($styles as $style) {
      $return[] = array(
        'id' => $style->id,
        'name' => $style->name,
        'description' => $style->description
        );
    }
    echo json_encode($return);
  }

}

/* End of file styles.php */
/* Location: ./application/controllers/ajax/styles.php */
