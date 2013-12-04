<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Library to add the denounce button for projects, products, etc in any place
 */
class Denounce_button
{
  /**
   * Gives access to the Code Igniter instances, so you could load libraries, helpers, etc
   * @var object
   */
  protected $ci;

  /**
   * Object 
   * @var string
   */
  protected $object;

  /**
   * Controller to be used at the AJAX request
   * @var string
   */
  protected $controller;

  /**
   * Initial actions
   */
  public function __construct() {
    $this->ci = &get_instance();
  }

  /**
   * Define the object type
   * @param string $type Type name
   */
  public function define($type, $id)
  {
    switch ($type)
    {
      # Projects
      case 'project':
        $object = new Item($id);
        $controller = 'items';
      break;

      # Products
      case 'product':
        $object = new Item($id);
        $controller = 'items';
      break;

      # Ambiance
      case 'ambiance':
        $object = new Ambiance($id);
        $controller = 'ambiances';
      break;
    }

    # Define object
    $this->object = $object;

    # Define object controller
    $this->controller = $controller;

    return $this;
  }

  /**
   * Get the mounted HTML markup
   * @return string HTML markup to be used
   */
  public function get()
  {
    # Create HTML markup
    $html = <<<BTN
      <span class='denounce hotspot'>
        <a
          id="item_denounce_{$this->object->id}"
          class="item_denounce"
          data-denounce-type="{$this->controller}"
          data-denounce-id="{$this->ci->session->userdata('id')}"
        >denounce</a>
      </span>
BTN;

    # Return HTML markup
    return $html;
  }

}

/* End of file denounce_button.php */
/* Location: ./application/libraries/denounce_button.php */
