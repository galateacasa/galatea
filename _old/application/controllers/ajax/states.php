<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Requests for state information via AJAX
 *
 * PHP 5.3+
 *
 * @author Diogo Lacerda <diogo.lacerda@gmail.com>
 * @author Arthur Duarte <arthur@aduarte.net>
 * @category Galatea
 * @package Controllers
 * @subpackage Ajax
 * @see CI_Controller
 */
class States extends CI_Controller
{
  /**
   * get
   *
   * Get the states or cities from state passed as parameter
   *
   * @param int $state_id
   * @access public
   * @return json
   */
  public function get() {
    $return = array();
    $state_id = false;
    if($this->input->get_post('state_id')){
      $state_id = $this->input->get_post('state_id');
    }
    if($this->input->get_post('id')){
      $state_id = $this->input->get_post('id');  
    }
    
    if ($state_id) {
      $state = new State($state_id);
      foreach ($state->city->get() as $city) {
        $return[] = array(
            'id' => $city->id,
            'name' => $city->name,
            'state_id' => $city->state_id
        );
      }
    } else {
      $states = new State();
      $states->get();
      foreach ($states as $state) {
        $return[] = array(
            "id" => $state->id,
            'name' => $state->name,
            'acronym' => $state->acronym
        );
      }
    }
    echo json_encode($return);
  }

  /**
   * Return all states and a specific cities of the state.
   * This method is used specificly for user profile edition
   *
   * @access public
   * @return JSON All necessary data to fill <select> tags
   */
  public function getAllWithCities()
  {
    // Instanciate new state
    $states = new State();

    // Instanciate new state based into user state
    $userState = new State();
    $userState->where('acronym', $this->input->get('state'))->get();

    // Get all cities information based on user state
    $cities = new City();
    $cities->where('state_id', $userState->id)->get();

    // Define default response
    $options = array(

      'state' => array(
        'name' => ucwords( strtolower($userState->name) ),
        'list' => ''
      ),

      'city' => array(
        'name' => $this->input->get('city'),
        'list' => ''
      ),

    );

    // Define <option> pattern to be used
    $optionPattern = "<option value='%s' %s>%s</option>";

    // Create <option> tag estruture for states
    foreach ( $states->get() as $_state) {
      $options['state']['list'] .= sprintf(
        $optionPattern,
        $_state->id,
        $_state->acronym == $this->input->get('state') ? 'selected' : '',
        $_state->name
      );
    }

    // Create <option> tag estruture for cities
    foreach ( $cities as $_city) {
      $options['city']['list'] .= sprintf(
        $optionPattern,
        $_city->id,
        $_city->name == $this->input->get('city') ? 'selected' : '',
        $_city->name
      );
    }

    // Print data
    echo json_encode($options);
  }
}

/* End of file states.php */
/* Location: ./application/controllers/ajax/states.php */
?>