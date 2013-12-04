<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Curadoria extends CI_Controller {

  /**
   * get
   *
   * Get the avaliation_text
   *
   * @param int $avaliation_id
   * @access public
   * @return json
   */
  public function get_avaliation_text(){
    $avaliation_id = $this->input->post('avaliation_id');

    $avaliation_text = new Avaliation_Text($avaliation_id);

    if(!$avaliation_text->exists()){
      echo json_encode(array('result'=>false));
      die();
    }

    echo json_encode(array('result'=>true, 'message'=>$avaliation_text->text));
  }

}

/* End of file curadoria.php */
/* Location: ./application/controllers/ajax/curadoria.php */
