<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ambiance_slider
{
  protected $ci;

  public function __construct() {
    $this->ci =& get_instance();
  }

  function get($ambiance_object, $type = 'star', $activate = FALSE)
  {
    # Define icon
    $data['icon'] = $type;

    # Define activation
    $data['activation'] = $activate == TRUE ? 'activate' : '';

    # Load social_links, vote_button and denounce_button libraries
    $this->ci->load->library( array('social_links', 'vote_button', 'denounce_button') );

    # Social Links
    $data['social_links'] = new Social_Links();

    # Vote button
    $vote_button = new Vote_Button();
    $data['vote_button'] = $vote_button;

    # Instanciate denounce button
    $denounce_button = new Denounce_button();
    $denounce_button->define('ambiance', $ambiance_object->id);
    $data['denounce_button'] = $denounce_button;

    # Ambiance data
    $data['ambiance'] = $ambiance_object;

    # Return ambiance slider HTML markup
    return $this->ci->load->view('site/common/slider-ambiance', $data, TRUE);
  }
}

/* End of file product.php */
/* Location: ./application/libraries/product.php */
