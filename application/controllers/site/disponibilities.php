<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

/**
 * All necessary logic to show a product
 *
 * PHP version 5.3+
 *
 * @category Galatea
 * @package Controllers
 * @subpackage Site
 * @author Diogo Lacerda <diogo.lacerda@gmail.com>
 * @author Arthur Duarte <arthur@aduarte.net>
 * @see CI_Controller
 */
class Disponibilities extends CI_Controller
{
  /**
   * Show specific product
   *
   * @access public
   * @param  string $slug Product URL slug
   * @return void
   */
  public function show($slug = FALSE)
  {
    # Load libraries
    $this->load->library('message');

    # check if disponibility_id was passed as post REQUEST
    if(!$slug) $slug = $this->input->post('slug');

    # Create a new object to work with database
    $product = new Item();
    $product->where('slug', $slug)->get();

    # Check if the disponibility exist and it's a product
    if ( $product->exists() )
    {
      // The product have any meta title defined?
      if ($product->meta_title) {
        $title = $product->meta_title;
      }else{
        $title = "{$product->name} - Galatea";
      }

      // The product have any meta description defined?
      if ($product->meta_description) $toview['metas'] = meta('description', $product->meta_description);

      $message = new Message();
      $message->define('product', $product->id, 'Comentários e reviews');

      // Define sub-category
      $categorySub = $product->category->get();

      // Define main category information
      $categoryMain = new Category($categorySub->parent_id);

      // Define breadcrumbs
      $breadcrumbs['breadcrumbs'] = array(

        // Main page
        array(
          'href' => base_url(),
          'name' => 'Home',
        ),

        // Category page
        array(
          'href' => base_url("categoria/{$categoryMain->slug}/" . $categorySub->slug),
          'name' => $categorySub->name,
        ),

        // Product page
        array(
          'href' => base_url("produto/{$product->slug}"),
          'name' => $product->name,
        ),
      );

      $same_style_query = '';

      foreach ($product->ambiance->get() as $same_style_ambiance)
      {
        $same_style_amb = new Ambiance($same_style_ambiance->id);

        if( $same_style_amb->item->get()->exists() ):
          foreach ($same_style_amb->item->get() as $same_style_item)
            if($same_style_item->id != $product->id) $same_style_query .= "OR id = '{$same_style_item->id}'";
        endif;
      }

      if( !empty($same_style_query) )
      {
        $same_style_query = substr($same_style_query, 3);

        $same_style = new Item();
        $same_style->where($same_style_query)->get();
      }else{
        $same_style = 0;
      }

      // Get all products that have the same sub-category
      {
        $related_products = new Item();
        $related_products->where_related_category('id', $product->category->id)->get();
      }

      //SOCIAL LINKS
      $this->load->library('social_links');
      $social_links = new Social_Links();

      $order_items = new Order_Item();
      $order_items->where('item_id', $product->id)->where_related_order('status', 1)->get();

      $items_suppliers = new Items_Supplier();
      $items_suppliers->where('item_id', $product->id)->get();

      $categories = new Category();

      // Variables
      {
        $toview['socialLinks']       = $social_links->get($product->name, $product->description, amazon_url('images/items/'.$product->item_image->get()->image), base_url("site/disponibilities/show/{$product->id}"));
        $toview['product']           = $product;
        $toview['item_supplier']     = $items_suppliers;
        $toview['order_items']       = $order_items;
        $toview['same_style']        = $same_style;
        $toview['related_products']  = $related_products;
        $toview['related_ambiances'] = $product->ambiance->get();
        $toview['materials']         = $product->Item_Variation_Material->get();
        $toview['measures']          = $product->Item_Variation_Measurement->get();
        $toview['breadcrumbs']       = $this->load->view('site/common/breadcrumbs', $breadcrumbs, TRUE);
        $toview['message']           = $message;
        $toview['ambiance_link']     = $this->input->get('ambiance_id');
        $toview['categories']        = $categories->where('parent_id', 0)->get();
        $toview['title']             = $title;
      }

      // Define scripts
      $toview['scripts'] = array(
        'plugins/jquery.ae.image.resize.min',
        'plugins/jquery.mCustomScrollbar',
        'site/script',
        'site/thumb',
        'site/Dropdown',
        'site/disponibility/show',
        'site/HorizontalSlider',
      );

      $this->load->view('site/common/header/main', $toview);
      $this->load->view('site/common/header/categories', $toview);
      $this->load->view('site/disponibility/show', $toview);
      $this->load->view('site/common/footer/main', $toview);

    }else{
      // Set error message
      $this->session->set_flashdata('error', 'Produto não encontrado');
      redirect('galatea_404');
    }

  }

  public function show_project($slug) {
    $project = new Item();
    $project->where(array('slug' => $slug, 'type' => 1))->get();

    if ($project->exists()) {
      $categories = new Category();

      $this->load->library('message');
      $message = new Message();
      $message->define('project', $project->id);

      $toview = array(
        'scripts' => array(
          'plugins/jquery.ae.image.resize.min',
          'plugins/jquery.mCustomScrollbar',
          'site/script',
          'site/thumb',
          'site/Dropdown',
          'site/disponibility/show',
          'site/HorizontalSlider'
        ),
        'categories' => $categories->where('parent_id', 0)->get(),
        'project' => $project,
        'user' => new User($this->session->userdata('id')),
        'message' => $message
      );

      $this->load->view('site/common/header/main', $toview);
      $this->load->view('site/common/header/categories', $toview);
      $this->load->view('site/disponibility/show_project', $toview);
      $this->load->view('site/common/footer/main', $toview);
    } else {
      // Set error message
      $this->session->set_flashdata('error', 'Projeto não encontrado');
      redirect('galatea_404');
    }
  }

}
?>
