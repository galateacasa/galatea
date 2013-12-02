<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller
{
  private $category_actual = FALSE;

  public function show($slug_parent, $slug_child = FALSE)
  {
    // Instanciate a new category
    $category_main = new Category();
    $category_main->where( array('slug' => $slug_parent, 'parent_id' => 0) )->get();

    // Instance a new category description
    $category_description = new Category_Description();

    // Check if the category exists
    if( !$category_main->exists() ) redirect( site_url('site/galatea_404') );

    // Define product class
    $products = new Item();

    // Define sidebar sub-categories
    $sidebar_sub_categories = new Category();

    // Define category
    $category_description->where('parent_id', $category_main->id);

    // Define breadcrumbs
    $breadcrumbs['breadcrumbs'] = array(

      // Main page
      array(
        'href' => base_url(),
        'name' => 'Home',
      ),

      // Main category
      array(
        'href' => base_url("categoria/{$category_main->slug}/"),
        'name' => $category_main->name,
      ),

    );

    // The child category was sent?
    if($slug_child)
    {
      $category_sub = new Category();
      $category_sub->where( array('slug' => $slug_child, 'parent_id' => $category_main->id) )->get();

      // Breadcrumb sub-category address
      $breadcrumbs['breadcrumbs'][] = array(
        'href' => base_url("categoria/{$category_main->slug}/" . $category_sub->slug),
        'name' => $category_sub->name,
      );

      // The child category exists?
      if( $category_sub->exists() ) {

        // Define product category
        $products->where_related_category('id', $category_sub->id);

        // Define sidebar category
        $sidebar_sub_categories->where('parent_id', $category_main->id);

        // Define the main category
        $category_name = $category_main->name;

        // Deifine actual main category for main menu
        $category_main_actual = $category_main->id;

        // Define the actual sub-category for sidebar
        $this->category_actual = $category_sub->id;

        // Define sub-category
        $category_description->where('child_id', $category_sub->id);

      }else{

        // Define sub-category
        $category_description->where('child_id', 0);

      }

    }else{

      // Define parent category name
      $category_name = $category_main->name;

      // Define sub-categories
      $sub_categories = new Category();
      $sub_categories->where('parent_id', $category_main->id)->get();

      // Get all products that have the sub-category
      $products->where_related_category('parent_id', $category_main->id);

      // Unset variable
      unset($sub_categories);

      // Deifine actual main category for main menu
      $category_main_actual = $category_main->id;

      // Define sidebar category
      $sidebar_sub_categories->where('parent_id', $category_main->id);

      // Define sub-category
      $category_description->where('child_id', 0);

    }

    // Define only products that is effectively a "product" and is activated
    $products->where( array('status' => 1, 'type' => 2) );

    //ORDER
    if( $this->input->get('order') ) {
      //order by price
      if ($this->input->get('order') == 'price_asc') {
        $products->order_by('production_price', 'asc');
      }else{
        $products->order_by('production_price', 'desc');
      }

    }else{
      $products->order_by("create_date", "desc");
    }

    //FILTER
    if( $this->input->get('filter') )
    {
      // Voted (favorites)
      if( $this->input->get('filter') == 'favorites' and $this->session->userdata('id') )
        $products->where_related('item_vote', 'user_id', $this->session->userdata('id'));

      //LAST 30 DAYS NEWS
      if($this->input->get('filter') == 'news') {
        $last30days = date('Y-m-d', strtotime(date('Y-m-d') . '-30 days'));
        $products->where('create_date >', $last30days);
      }
    }

    $category_url = "categoria/{$category_main->slug}";

    if( isset($category_sub) ) {
      $category_url .= "/{$category_sub->slug}";
      $category['image'] = $category_sub->image;
      $category['href']  = $category_sub->link_address ? $category_sub->link_address : '#';
    }else{
      $category['image'] = $category_main->image;
      $category['href']  = $category_main->link_address ? $category_main->link_address : '#';
      $category_sub = FALSE;
    }

    $categories = new Category();

    // Get category description
    $category_description->get();

    // Variables to the view
    {
      $toview['breadcrumbs']          = $this->load->view('site/common/breadcrumbs', $breadcrumbs, TRUE);
      $toview['category_main']        = $category_main;
      $toview['category_sub']         = $category_sub;
      $toview['categories']           = $categories->where('parent_id', 0)->get();
      $toview['category_url']         = $category_url = isset($category_url) ? $category_url : FALSE;
      $toview['category']             = $category;
      $toview['category_actual']      = $this->category_actual;
      $toview['category_name']        = $category_name;
      $toview['products']             = $products->get();
      $toview['sub_categories']       = $sidebar_sub_categories->get();
      $toview['category_main_actual'] = $category_main_actual;
      $toview['title']                = $category_description->title;
      $toview['metas']                = meta('description', $category_description->description);
    }

    $this->load->view('site/common/header/main', $toview);
    $this->load->view('site/common/header/categories', $toview);
    $this->load->view('site/category', $toview);
    $this->load->view('site/common/footer/main', $toview);

  }

  public function show_projects()
  {
    // Define breadcrumbs
    $breadcrumbs['breadcrumbs'] = array(
      // Main page
      array(
        'href'  => site_url(),
        'title' => 'Página inicial',
        'name'  => 'Home'
      ),

      // Vote page
      array(
        'href'  => site_url('site/categories/show_projects/'),
        'title' => 'Vote',
        'name'  => 'Vote'
      )
    );

    // Define all project that is activated and have been released
    $projects = new Item();
    $projects->where('status = 1 AND
                      type = 1 AND
                      (
                        delivery_date < \'' . date('Y-m-d') . '\' OR
                        delivery_date = \'' . date('Y-m-d') . '\'
                      )')
             ->order_by("create_date", "desc");

    // Any filter was defined?
    if( $this->input->get('filter') ) {
      // The filter is "favorites" and the user is logged in?
      if($this->input->get('filter') == 'favorites' and $this->session->userdata('id') )
        $projects->where_related('item_votes', 'user_id', $this->session->userdata('id'));

      // The filter is a news filter?
      if($filter == 'news') {
        //LAST 30 DAYS NEWS
        $today = date('Y-m-d');
        $last30days = date('Y-m-d', strtotime($today . '+30 days'));
        $projects->where_between('create_date', "'$today 00:00:00'", "'$last30days 23:59:59'");
      }
    }

    // Define view variable
    $data = array(
      'projects' => $projects->get(),
      'breadcrumbs' => $this->load->view('site/common/breadcrumbs', $breadcrumbs, true)
    );

    // Define witch template will be used into the template
    $this->template->load('site', 'site/category_projects', $data);
  }

  /**
   * List all projects from all categories
   * @return void
   */
  public function show_news()
  {
    // Define breadcrumbs
    $breadcrumbs['breadcrumbs'] = array(
      // Main page
      array(
        'href'  => site_url(),
        'title' => 'Página inicial',
        'name'  => 'Home'
      ),

      // Vote page
      array(
        'href'  => site_url('site/categories/show_news/'),
        'title' => 'Novidades',
        'name'  => 'Novidades'
      )
    );

    # Get all activated products
    $products = new Item();
    $products->where(array('status' => 1, 'type' => 2));

    # Any order was set up?
    if( $this->input->get('order') )
    {
      //order by price
      if($this->input->get('order') == 'price_asc') {
        $products->order_by("production_price", "ASC");
      }else{
        $products->order_by("production_price", "DESC");
      }
    }else{
      $products->order_by("create_date", "DESC");
    }

    # Any filter was set up and the user is logged in?
    if( $this->input->get('filter') and $this->session->userdata('id') ) {
      # The filter is the "favorites" filter?
      if($filter == 'favorites') $products->where_related('item_votes', 'user_id', $this->session->userdata('id') );
    }

    // Define view variable
    $data = array(
      'products' => $products->get(),
      'breadcrumbs' => $this->load->view('site/common/breadcrumbs', $breadcrumbs, true)
    );

    # Load the correctly view at the template
    $this->template->load('site', 'site/category_news', $data);
  }
}
