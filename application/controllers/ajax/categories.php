<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * All methods to work with AJAX requests for categories
 *
 * PHP 5.3+
 *
 * @author Diogo Lacerda <diogo.lacerda@gmail.com>
 * @package Controllers
 * @subpackage Ajax
 * @category Galatea
 * @see CI_Controller
 */
class Categories extends CI_Controller
{

  /**
   * Get all sub-categories from specific category
   *
   * Get the categories or sub_categories from category passed as parameter
   *
   * @access public
   * @param int $category_id
   * @return json
   */
  public function get()
  {

    $return = array();

    if( $this->input->get_post('id') ) {

      $category_id = $this->input->get_post('id');
      $sub_categories = new Category();
      $sub_categories->where('parent_id', $category_id)->get();

      foreach ($sub_categories as $sub_category)
        $return[] = array('id' => $sub_category->id, 'name' => $sub_category->name);

    }else{

      $categories = new Category();

      $categories->where('parent_id', '')
                 ->or_where('parent_id', 0)
                 ->or_where('parent_id', NULL)
                 ->get();

      foreach ($categories as $category)
        $return[] = array("id" => $category->id, 'name' => $category->name);

    }

    // Return de data
    echo json_encode($return);

  }

}

/* End of file categories.php */
/* Location: ./application/controllers/ajax/categories.php */
?>
