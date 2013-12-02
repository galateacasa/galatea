<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller {

  public $path = "/images/categories/";

  private $amazon_url;

  function __construct()
  {
    parent::__construct();

    #$this->load->helper('html');

    # Define amazon URL for images
    $this->amazon_url = amazon_url('images/categories');
  }

  public function index(){
    $categories = new Category();
    $categories->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $categories->order_by('create_date', 'desc')->get();
    $toview['categories'] = array();
    foreach ($categories as $key => $category) {
      $parent = new Category($category->parent_id);
      $category->parent = $parent;
      $toview['categories'][] = $category;
    }

        $subcategories = new Category();
        $toview['subcategories'] = $subcategories->get();

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Categorias' => site_url('admin/categories')
      );

    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/category/index', $toview);
  }

  public function create(){
    if($this->input->post()){
      $this->form_validation->set_rules('name', 'Nome', 'required');

      if (!$this->form_validation->run()) {
        $this->session->set_flashdata('error', validation_errors());
        redirect(site_url('admin/categories/create'));
      }

      //save category
      $category            = new Category();
      $category->name      = $this->input->post('name');
      $category->parent_id = $this->input->post('category');
      $category->image     = $this->input->post('image');

      if ($this->input->post('subcategories')) {
        $subcategories = $this->input->post('subcategories');

        foreach ($subcategories as $subcategory) {
          $subcategory            = new Category($subcategory);
          $subcategory->parent_id = $category->id;
          $subcategory->save();
        }
      }

      if(!$category->save()){
        $this->session->set_flashdata('error', $category->error->transaction);
        redirect(site_url('admin/categories/create'));
      }
      $this->session->set_flashdata('success', 'Salvo com sucesso.');
      redirect(site_url('admin/categories/edit/'.$category->id));
    }

    $all_categories = new Category();
    $all_categories->get();

    $free_categories = array();

    # Test all Categories and list Only the ones that can be used as sub-categories, to maintain Single Sublevel.
    foreach($all_categories as $one_category) {
      $free = TRUE;
      if ($one_category->parent_id != 0) {
        $free = FALSE;
      } else {
        foreach ($all_categories as $sub_category) {
          if ($one_category->id == $sub_category->parent_id) {
            $free = FALSE;
          }
        }
      }

      if ($free) {
        $free_categories[] = $one_category;
      }
    }

    $toview['free_categories'] = $free_categories;

    # Get Custom Scripts
    $this->get_scripts();

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Categorias' => site_url('admin/categories'),
      'Criar' => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_script(assets_url('js/plugins/jquery.ae.image.resize.min.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.filedrop.js'));
    $this->template->set_script(assets_url('js/admin/category/create.js'));
    $this->template->load('admin', 'admin/category/create', $toview);
  }

  public function edit($category_id){
    $category = new Category($category_id);
    if(!$category->exists()){
      $this->session->set_flashdata('error', 'Categoria não encontrada');
      redirect(site_url('admin/categories'));
    }

    if($this->input->post()){
      $this->form_validation->set_rules('name', 'Nome', 'required');

      if (!$this->form_validation->run()) {
        $this->session->set_flashdata('error', validation_errors());
        redirect(site_url('admin/categories/create'));
      }

      $category->name = $this->input->post('name');
      $category->parent_id = $this->input->post('category');
      $category->image = $this->input->post('image');

      $oldSubCategories = new Category();
      $oldSubCategories->where(array('parent_id' => $category->id));
      $oldSubCategories->get();

      $postedSubCategories = array();
      if ($this->input->post('subcategories')) {
        $postedSubCategories = $this->input->post('subcategories');
      }

      if ($oldSubCategories->exists()) {
        foreach($oldSubCategories as $oldSubCategory) {
          if(!in_array($oldSubCategory->id, $postedSubCategories)) {
            $oldSubCategory->parent_id = 0;
            $oldSubCategory->save();
          }
        }
      }

      if ($this->input->post('subcategories')) {
        foreach ($postedSubCategories as $subcategory) {
          $subcategory = new Category($subcategory);
          $subcategory->parent_id = $category->id;
          $subcategory->save();
        }
      }

      if(!$category->save()){
        $this->session->set_flashdata('error', $category->error->transaction);
        redirect(site_url('admin/categories/edit/'.$category->id));
      }

      $this->session->set_flashdata('success', 'Salvo com successo.');
    }

    $all_categories = new Category();
    $all_categories->get();
    $free_categories = array();

    $subcategories = new Category();
    $subcategories->where(array('parent_id' => $category->id));
    $subcategories->get();

    # if this Category isn't already a Subcategory
    if ($category->parent_id == 0 || $category->parent_id == '') {
      # Test all Categories and list Only the ones that can be used as sub-categories, to maintain Single Sublevel.
      foreach($all_categories as $one_category) {
        $free = TRUE;
        if ($one_category->parent_id != '0') {
          $free = FALSE;
        } else if ($one_category->id == $category->id) {
          $free = FALSE;
        } else {
          foreach ($all_categories as $sub_category) {
            if ($one_category->id == $sub_category->parent_id) {
              $free = FALSE;
            }
          }
        }

        if ($free) {
          $free_categories[] = $one_category;
        }
      }
    } else {
      $free_categories = false;
    }

    $toview['free_categories'] = $free_categories;
    $toview['category']        = $category;
    $toview['subcategories']   = $subcategories;

    # Get Custom Scripts
    if ($category->image == 0) {
      $this->get_scripts();
    } else {
      $this->get_scripts($category->image);
    }

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Categorias' => site_url('admin/categories'),
      'Editar' => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_script(assets_url('js/plugins/jquery.ae.image.resize.min.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.filedrop.js'));
    $this->template->load('admin', 'admin/category/edit', $toview);
  }

    private function _verify_parent_category($category_id){
        $category = new Category();
        $category->where('parent_id', $category_id);
        if($category->exists()){
            foreach($category->get() as $categ){
                $categ->delete();
            }
        }
    }

    public function remove($category_id){
        $category = new Category($category_id);
        if(!$category->exists()){
            $this->session->set_flashdata('error', 'Categoria não encontrada.');
            redirect(site_url('admin/categories'));
        }

        $subCategories = new Category();
        $subCategories->where(array('parent_id' => $category->id));
        $subCategories->get();

        foreach($subCategories as $subCategory) {
          # Removing only the Father and unlinking Sub-Categories.
          #$subCategory->parent_id = 0;
          #$subCategory->save();

          # Removing all Sub-Categories.
          $this->load->library('s3', 's3');
          $fullpath = $this->config->item('s3_ambient').$this->path;
          $this->s3->deleteObject($this->config->item('s3_bucket'), $fullpath . $subCategory->image);
          $subCategory->delete();
        }

        $this->load->library('s3', 's3');
        $fullpath = $this->config->item('s3_ambient').$this->path;
        $this->s3->deleteObject($this->config->item('s3_bucket'), $fullpath . $category->image);

        //verify if exists subcategory
        $this->_verify_parent_category($category_id);
        $category->delete();
        $this->session->set_flashdata('success', 'Removido com sucesso.');
        redirect(site_url('admin/categories'));

    }

    private function get_scripts($image = '') {
      $scripts_inline = <<<SCRIPTS
      $(document).ready(function() {
        // Script to upload images on the fly
        new upload_box('dropbox', '', 'images/categories', '{$this->amazon_url}', 1, 'thumbnail', '{$image}', 400);
      });
SCRIPTS;

      # Set external JavaScripts
    {
      # Scripts
      $scripts = array(
        'site/upload_box',
        'plugins/jquery.ae.image.resize.min'
      );

      # Set all scripts
      foreach($scripts as $script) $this->template->set_script( assets_url('js/' . $script . '.js') );
    }

    # Set scripts
    $this->template->set_script('', $scripts_inline);
    }

}

/* End of file categories.php */
/* Location: ./application/controllers/admin/categories.php */
