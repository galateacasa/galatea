<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

  public $path = "/images/items/";

  private $amazon_url;

  function __construct()
  {
    parent::__construct();

    #$this->load->helper('html');

    # Define amazon URL for images
    $this->amazon_url = amazon_url('images/items');
  }

  public function index(){
    $products_list = new Item();
    $products_list->where(array('type' => 2, 'delete_date' => null));
    $products_list->order_by('name', 'desc');
    $products_list->get();
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Produtos' => site_url('admin/products')
      );

    $products = array();
    foreach ($products_list as $product) {
      $category = new Category($product->category_id);
      if ($category->parent_id != 0) {
        $product->subcategory = $category;
        $product->category    = new Category($category->parent_id);
      }
      else {
        $product->subcategory = $category;
        $product->category    = $category;
      }

      $suppliers_relation = new Items_supplier();
      $suppliers_relation->where(array('item_id' => $product->id));
      $suppliers_relation->get();
      $suppliers = array();

      foreach ($suppliers_relation as $supplier_relation) {
        $supplier = new User($supplier_relation->user_id);
        $suppliers[] = $supplier;
      }
      $product->suppliers = $suppliers;

      $product->designer = new User($product->user_id);

      $variation_materials = new Item_variation_material();
      $variation_materials->where(array('item_id' => $product->id));
      $variation_materials->get();
      $cheapest_material = '';
      $variation_measurements = new Item_variation_measurement();
      $variation_measurements->where(array('item_id' => $product->id));
      $variation_measurements->get();
      $cheapest_measurement = '';
      foreach ($variation_materials as $material) {
        if ($cheapest_material == '' || $material->additional_amount < $cheapest_material) {
          $cheapest_material = $material->additional_amount;
        }
      }
      foreach ($variation_measurements as $measurement) {
        if ($cheapest_measurement == '' || $measurement->additional_amount < $cheapest_measurement) {
          $cheapest_measurement = $measurement->additional_amount;
        }
      }

      $product->minimum_price = $product->production_price + $cheapest_material + $cheapest_measurement;
      $product->minimum_price = "R$ ".number_format($product->minimum_price, 2, ',', '.');

      $products[] = $product;
    }

    $toview['products'] = $products;

    # exit(print_r($products[1]->suppliers));

    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/product/index', $toview);
  }

  public function create($id = '') {
    if( $this->input->post() ) {
      if ($id == '' || $id == 0) {
      //   # Create Project
      //   $project = new Item();
      //   $project->status           = '0';
      //   $project->name             = $this->input->post('name');
      //   $project->description      = $this->input->post('description');
      //   $project->category_id      = ($this->input->post('sub_category')) ? $this->input->post('sub_category') : $this->input->post('category');
      //   $project->user_id          = $this->input->post('designer');
      //   $project->production_price = $this->input->post('production_price');
      //   $project->delivery_cost    = $this->input->post('delivery_cost');

      //   $project->status           = $this->input->post('status');
      //   $project->type             = '1';

      //   #Save Project
      //   if(!$project->save()){
      //     $this->session->set_flashdata('error', $project->error->transaction);
      //     redirect('admin/products');
      //   }
      } else {
        $project = new Item($id);
      }

      // exit('done');

      # Product
      $product = new Item();
      $product->status           = '0';
      $product->name             = $this->input->post('name');
      $product->description      = $this->input->post('description');
      $product->category_id      = $this->input->post('category');
      $product->user_id          = $this->input->post('designer');
      $product->production_price = $this->input->post('production_price');
      $product->delivery_cost    = $this->input->post('delivery_cost');
      $product->delivery_time    = $this->input->post('delivery_time');
      $product->status           = $this->input->post('status');
      $product->type             = '2';

      # Product Project Parent ID:
      $product->parent_project_id = isset($project) == TRUE ? $project->id : NULL;

      #Save Product
      if(!$product->save()){
        $this->session->set_flashdata('error', $product->error->transaction);
        redirect('admin/products');
      }


      # Variations
      $post_variations = array(
        'materials'    => $this->input->post('materials'),
        'measurements' => $this->input->post('measurements')
      );
      $variations = array(
        'materials'    => array(),
        'measurements' => array()
      );


      foreach ($post_variations as $variation_title => $variation_values) {
        foreach ($variation_values as $key => $variation) {
          foreach ($variation as $id => $value) {
            if ($value != '' && $value != '0') {
              $variations[$variation_title][$id][$key] = $value;
            }
          }
        }
      }

      foreach ($variations['materials'] as $id => $variation_material) {
       if ($variation_material['material'] != '' && $variation_material['material'] != '0') {

          $new_variation = new Item_variation_material();
          $new_variation->item_id           = $product->id;
          $new_variation->material          = $variation_material['material'];
          if (isset($variation_material['variation_cost'])) {
            $new_variation->variation_cost    = $variation_material['variation_cost'];
          }
          if (isset($variation_material['additional_amount'])) {
            $new_variation->additional_amount = $variation_material['additional_amount'];
          }
          $new_variation->save();

          if ($id == '' || $id == 0) {
            $project_variation = new Item_variation_material();
            $project_variation->item_id           = $project->id;
            $project_variation->material          = $variation_material['material'];
            $new_variation->save();
          }
        }
      }

      foreach ($variations['measurements'] as $id => $variation_measurement) {
        if ($variation_measurement['width'] != '' && $variation_measurement['width'] != 0 &&
            $variation_measurement['height'] != '' && $variation_measurement['height'] != 0 &&
            $variation_measurement['depth'] != '' && $variation_measurement['depth'] != 0) {

          $new_variation = new Item_variation_measurement();
          $new_variation->item_id           = $product->id;
          $new_variation->width             = $variation_measurement['width'];
          $new_variation->height            = $variation_measurement['height'];
          $new_variation->depth             = $variation_measurement['depth'];
          if (isset($variation_measurement['variation_cost'])) {
            $new_variation->variation_cost    = $variation_measurement['variation_cost'];
          }
          if (isset($variation_measurement['additional_amount'])) {
            $new_variation->additional_amount = $variation_measurement['additional_amount'];
          }
          $new_variation->save();

          if ($id == '' || $id == 0) {
            $new_variation = new Item_variation_measurement();
            $new_variation->item_id           = $project->id;
            $new_variation->width             = $variation_measurement['width'];
            $new_variation->height            = $variation_measurement['height'];
            $new_variation->depth             = $variation_measurement['depth'];
          }
        }
      }

      if($this->input->post('supplier')){
        $suppliers = array();

        foreach ($this->input->post('supplier') as $supplier_col => $supplier_values) {
          foreach ($supplier_values as $id => $value) {
            if ($value != '' && $value != '0') {
              $suppliers[$id][$supplier_col] = $value;
            }
          }
        }

        foreach($suppliers as $supplier){
          $supplier_add = new Items_supplier();
          $supplier_add->item_id           = $product->id;
          $supplier_add->user_id           = $supplier['id'];
          $supplier_add->production_amount = $supplier['production_amount'];
          if (!$supplier_add->save()) {
            $this->session->flashdata('error', $supplier_add->error->transaction);
            redirect('admin/products');
          }

          if ($id == '' || $id == 0) {
            $project_supplier_add = new Items_supplier();
            $project_supplier_add->item_id           = $project->id;
            $project_supplier_add->user_id           = $supplier['id'];
            $project_supplier_add->production_amount = $supplier['production_amount'];
            if (!$project_supplier_add->save()) {
              $this->session->flashdata('error', $project_supplier_add->error->transaction);
              redirect('admin/products');
            }
          }
        }
      }

      //SAVE IMAGES
      if($this->input->post('images')){
        $images = $this->input->post('images');

        $imgs = array();
        $cont = 0;
        foreach($images as $img){
          $product_image = new Item_Image();
          $product_image->item_id = $product->id;
          $product_image->image = $img;
          $product_image->principal = ($cont == 0) ? 1 : 0;
          if (!in_array($img, $prev_imgs)) {
            $prev_imgs[] = $img;
            if (!$product_image->save($imgs)) {
              $this->session->flashdata('error', $product_image->error->transaction);
              redirect('admin/products');
            }
            $cont++;
          }
        }
      }

      $this->session->set_flashdata('success', 'Salvo com sucesso!');
      redirect('admin/products/edit/'.$product->id);
    }

    $projects = new Item();
    $projects->where(array('type' => 1));
    $projects->order_by('name', 'asc');
    $projects->get();


    $categories = new Category();
    $categories->order_by('name', 'asc');
    $categories->get();

    $images = array();

    if ($id != 0 && $id != '') {
      $project = new Item($id);

      $variation_materials = new Item_variation_material();
      $variation_materials->where(array('item_id' => $project->id));
      $variation_materials->get();

      $variation_measurements = new Item_variation_measurement();
      $variation_measurements->where(array('item_id' => $project->id));
      $variation_measurements->get();

      $toview['product']                = $project;
      $toview['variation_materials']    = $variation_materials;
      $toview['variation_measurements'] = $variation_measurements;


      $images_list = new Item_image();
      $images_list->where(array('item_id' => $project->id));
      $images_list->get();

      foreach ($images_list as $image) {
        $images[] = $image->image;
      }
    }

    $designers = new User();
    $designers->where(array('role' => 3));
    $designers->get();

    $all_suppliers = new User();
    $all_suppliers->where(array('role' => 2));
    $all_suppliers->get();

    $statuses = array(
      'Não Publicado' => 0,
      'Publicado'     => 1
    );

    $toview['projects']       = $projects;
    $toview['categories']     = $categories;
    $toview['designers']      = $designers;
    $toview['statuses']       = $statuses;
    $toview['all_suppliers']  = $all_suppliers;

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Produtos' => site_url('admin/products'),
      'Criar' => '#'
    );

    # Get Inline Scripts
    $inline = '';
    if (empty($images)) {
      $inline = $this->getScriptsInline();
    } else {
      $inline = $this->getScriptsInline($images);
    }


    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_style(assets_url('js/plugins/jquery.multiselect/jquery.multiSelect.css'));
    $this->template->set_script(assets_url('js/plugins/jquery.ae.image.resize.min.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.sheepItPlugin-1.0.0.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.filedrop.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.multiselect/jquery.multiSelect.js'));
    $this->template->set_script(assets_url('js/site/upload_box.js'));
    $this->template->set_script('', $this->getScriptsCreate());
    $this->template->set_script('', $inline);

    $this->template->load('admin', 'admin/product/create', $toview);

  }

  public function edit($product_id){
    $product = new Item($product_id);

    if(!$product->exists() || $product->type != 2){
      $this->session->set_flashdata('error', 'Produto não encontrado');
      redirect(site_url('admin/products'));
    }

    if($this->input->post()){
      $product->name             = $this->input->post('name');
      $product->description      = $this->input->post('description');
      $product->category_id      = $this->input->post('sub_category') ? $this->input->post('sub_category') : $this->input->post('category');
      $product->user_id          = $this->input->post('designer');
      $product->production_price = $this->input->post('production_price');
      $product->delivery_cost    = $this->input->post('delivery_cost');
      $product->delivery_time    = $this->input->post('delivery_time');
      $product->status           = $this->input->post('status');

      $post_variations = array(
        'materials'    => $this->input->post('materials'),
        'measurements' => $this->input->post('measurements')
      );
      $variations = array(
        'materials'    => array(),
        'measurements' => array()
      );

      $old_materials = new Item_variation_material();
      $old_materials->where(array('item_id' => $product->id));
      $old_materials->get();
      $old_materials->delete_all();

      $old_measurements = new Item_variation_measurement();
      $old_measurements->where(array('item_id' => $product->id));
      $old_measurements->get();
      $old_measurements->delete_all();

      foreach ($post_variations as $variation_title => $variation_values) {
        foreach ($variation_values as $key => $variation) {
          foreach ($variation as $id => $value) {
            if ($value != '' && $value != '0') {
              $variations[$variation_title][$id][$key] = $value;
            }
          }
        }
      }

      if(!$product->save()){
        $this->session->set_flashdata('error', $product->error->transaction);
        redirect('admin/products');
      }

      foreach ($variations['materials'] as $id => $variation_material) {
        if (isset($variation_material['material']) && $variation_material['material'] != '' && $variation_material['material'] != '0') {

          $new_variation = new Item_variation_material();
          $new_variation->item_id           = $product->id;
          $new_variation->material          = $variation_material['material'];
          if (isset($variation_material['variation_cost'])) {
            $new_variation->variation_cost    = $variation_material['variation_cost'];
          }
          if (isset($variation_material['additional_amount'])) {
            $new_variation->additional_amount = $variation_material['additional_amount'];
          }
          $new_variation->save();
        }

      }

      foreach ($variations['measurements'] as $id => $variation_measurement) {
        if (
            isset($variation_measurement['width']) && $variation_measurement['width']  != '' && $variation_measurement['width'] != 0 &&
            isset($variation_measurement['width']) && $variation_measurement['height'] != '' && $variation_measurement['height'] != 0 &&
            isset($variation_measurement['width']) && $variation_measurement['depth']  != '' && $variation_measurement['depth'] != 0
          ) {

          $new_variation = new Item_variation_measurement();
          $new_variation->item_id           = $product->id;
          $new_variation->width             = $variation_measurement['width'];
          $new_variation->height            = $variation_measurement['height'];
          $new_variation->depth             = $variation_measurement['depth'];
          if (isset($variation_measurement['variation_cost'])) {
            $new_variation->variation_cost    = $variation_measurement['variation_cost'];
          }
          if (isset($variation_measurement['additional_amount'])) {
            $new_variation->additional_amount = $variation_measurement['additional_amount'];
          }
          $new_variation->save();
        }
      }



      $old_suppliers = new Items_supplier();
      $old_suppliers->where(array('item_id' => $product->id));
      $old_suppliers->get();
      $old_suppliers->delete_all();

      // Save Suppliers
      if($this->input->post('supplier')){
        $suppliers = array();

        foreach ($this->input->post('supplier') as $supplier_col => $supplier_values) {
          foreach ($supplier_values as $id => $value) {
            $suppliers[$id][$supplier_col] = $value;
          }
        }

        foreach($suppliers as $supplier){
          $supplier_add = new Items_supplier();
          $supplier_add->item_id           = $product->id;
          $supplier_add->user_id           = $supplier['id'];
          $supplier_add->production_amount = $supplier['production_amount'];
          if (!$supplier_add->save()) {
            $this->session->flashdata('error', $suppliers->error->transaction);
            redirect('admin/products');
          }
        }
      }

      $old_images = new Item_image();
      $old_images->where(array('item_id' => $product->id));
      $old_images->get();
      $old_images->delete_all();

      //SAVE IMAGES
      if($this->input->post('images')){
        $images = $this->input->post('images');

        $imgs = array();
        $prev_imgs = array();
        $cont = 0;
        foreach($images as $img){
          $product_image = new Item_Image();
          $product_image->item_id = $product->id;
          $product_image->image = $img;
          $product_image->principal = ($cont == 0) ? 1 : 0;
          if (!in_array($img, $prev_imgs)) {
            $prev_imgs[] = $img;
            if (!$product_image->save($imgs)) {
              $this->session->flashdata('error', $product_image->error->transaction);
              redirect('admin/products');
            }
            $cont++;
          }
        }
      }

      $this->session->set_flashdata('success', 'Salvo com sucesso!');
    }

    $categories = new Category();
    $categories->where(array('parent_id !=' => '0'));
    $categories->get();

    $variation_materials = new Item_variation_material();
    $variation_materials->where(array('item_id' => $product->id));
    $variation_materials->get();

    $variation_measurements = new Item_variation_measurement();
    $variation_measurements->where(array('item_id' => $product->id));
    $variation_measurements->get();

    $designers = new User();
    $designers->where(array('role' => 3));
    $designers->get();

    $all_suppliers = new User();
    $all_suppliers->where(array('role' => 2));
    $all_suppliers->get();

    $suppliers = new Items_supplier();
    $suppliers->where(array('item_id' => $product->id));
    $suppliers->get();

    $images_list = new Item_image();
    $images_list->where(array('item_id' => $product->id));
    $images_list->get();

    $images = array();

    foreach ($images_list as $image) {
      $images[] = $image->image;
    }

    $statuses = array(
      'Não Publicado' => 0,
      'Publicado'     => 1
    );

    $toview['product']                = $product;
    $toview['categories']             = $categories;
    $toview['variation_materials']    = $variation_materials;
    $toview['variation_measurements'] = $variation_measurements;
    $toview['designers']              = $designers;
    $toview['statuses']               = $statuses;
    $toview['designers']              = $designers;
    $toview['all_suppliers']          = $all_suppliers;
    $toview['suppliers']              = $suppliers;
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Produtos' => site_url('admin/products'),
      'Editar' => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);

    $this->template->set_style(assets_url('js/plugins/jquery.multiselect/jquery.multiSelect.css'));

    $this->template->set_script(assets_url('js/plugins/jquery.ae.image.resize.min.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.sheepItPlugin-1.0.0.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.filedrop.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.multiselect/jquery.multiSelect.js'));
    $this->template->set_script(assets_url('js/site/upload_box.js'));

    # Get Inline Scripts
    $inline = '';
    if (empty($images)) {
      $inline = $this->getScriptsInline();
    } else {
      $inline = $this->getScriptsInline($images);
    }
    $this->template->set_script('', $inline);

    $this->template->load('admin', 'admin/product/edit', $toview);
  }

  public function remove($product_id){
    $product = new Item($product_id);
    $product->delete_date = date('Y-m-d H:i:s', time());
    if (!$product->save()) {
      $this->session->flashdata('error', $product->error->transaction);
      redirect('admin/products');
    }
    $this->session->set_flashdata('success', 'Removido com sucesso!');
    redirect('admin/products/');
  }

  private function getScriptsCreate() {
    $site_url = site_url('admin/products/create/');
    $scripts_inline = <<<SCRIPTS
      $(document).ready(function() {
        $('#project').change(
          function() {
            var selectVal = $('#project :selected').val();
            if (selectVal != 0) {
              window.location.href="{$site_url}/" + selectVal;
            }
          }
        );
      });
SCRIPTS;

    return $scripts_inline;
  }

  private function getScriptsInline($images = '') {
    if (is_array($images)) {
      $images = implode(';', $images);
    }
    $scripts_inline = <<<SCRIPTS
      $(document).ready(function() {
        // Script to upload images on the fly
        new upload_box('dropbox', 'message', 'images/items', '{$this->amazon_url}', '12', 'thumbnails', '{$images}', 100, 100);

        // Script to add Measurements Boxes
        $('.measurements_default').hide();
        $('#measurements_add').click(
          function() {
            if ($('.measurements_default').is(':hidden')) {
              $('.measurements_default').show();
            } else {
              var measurements = $('.measurements_default').clone()
              measurements.removeClass('measurements_default');
              $('#measurements_template').append(measurements);
              addRemovable();
            }
          }
        );

        // Script to add Material Boxes
        $('.materials_default').hide();
        $('#materials_add').click(
          function() {
            if ($('.materials_default').is(':hidden')) {
              $('.materials_default').show();
            } else {
              var materials = $('.materials_default').clone();
              materials.removeClass('materials_default');
              $('#materials_template').append(materials);
              addRemovable();
            }
          }
        );

        // Script to add Supplier Boxes
        $('.suppliers_default').hide();
        $('#suppliers_add').click(
          function() {
            if ($('.suppliers_default').is(':hidden')) {
              $('.suppliers_default').show();
            } else {
              var suppliers = $('.suppliers_default').clone();
              suppliers.removeClass('suppliers_default');
              $('#suppliers_template').append(suppliers);
              addRemovable();
            }
          }
        );

        //Script to remove Variation Boxes
        addRemovable();
      });

      function addRemovable() {
        $('.variations_remove_current').click(
          function() {
            if ($(this).parent().parent().hasClass('measurements_default') || $(this).parent().parent().hasClass('materials_default')) {
              $(this).parent().parent().hide();
            } else {
              $(this).parent().parent().remove();
            }
          }
        );
        $('.suppliers_remove_current').click(
          function () {
            if ($(this).parent().parent().hasClass('suppliers_default')) {
              $(this).parent().parent().hide();
            } else {
              $(this).parent().parent().remove();
            }
          }
        );
      }
SCRIPTS;

    return $scripts_inline;
  }

  private function getStylesInline() {
    $styles_inline = <<<STYLES
      .thumbnails {
        list-style: none;
        margin: 0;
      }
      .thumbnails li {
        margin-top: 20px;
      }
      .thumbnails img {
        width:
      }

STYLES;
  }



}

/* End of file products.php */
/* Location: ./application/controllers/admin/products.php */
