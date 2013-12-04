<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

  /**
   * Class for a common use
   *
   * PHP 5.3+
   *
   * @author Arthur Duarte <arthur@aduarte.net>
   * @category Galatea
   * @package Controllers
   * @subpackage Ajax
   * @see CI_Controller
  */
  class Common extends CI_Controller
  {
    /**
     * Get all amazon URLs that could be used to show some image
     *
     * @access public
     * @return JSON Amazon URLs
     */
    public function get_amazon_url()
    {
      // Define items
      $items = array(
        'ambiance' => 'ambiances',
        'item'     => 'items',
        'user'     => 'users'
      );

      // Mount all URLS.
      foreach($items as $name => $item) $urls[$name] = amazon_url("images/{$item}", FALSE, FALSE, TRUE);

      // Print URLs
      echo json_encode($urls);
    }
  }

/* End of file common.php */
/* Location: ./application/controllers/ajax/common.php */
?>