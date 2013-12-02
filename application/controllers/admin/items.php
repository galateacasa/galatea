<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Items extends CI_Controller {

  public function index(){
    $items = new Item();
    $items->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $items->order_by('create_date', 'desc');
    $toview['items'] = $items->get();
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Projetos' => site_url('admin/items')
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/item/index', $toview);
  }

  public function create() {
    if( $this->input->post() ) {
      $item = new Item();

      $item->name        = $this->input->post('name');
      $item->description = $this->input->post('description');
      $item->height      = $this->input->post('height');
      $item->width       = $this->input->post('width');
      $item->depth       = $this->input->post('depth');
      $item->url         = $this->input->post('url');
      $item->style_id    = $this->input->post('style_id');

      if($this->input->post('sub_category')){
        $item->category_id = $this->input->post('sub_category');
      }else{
        $item->category_id = $this->input->post('category');
      }

      if(!$item->save()){
        $this->session->set_flashdata('error', $item->error->transaction);
        redirect('admin/items');
      }

      //SAVE VARIATIONS
      if ($this->input->post('item')) {
        $variations_post = $this->input->post('item');

        $variations = $variations_post['variations'];
        foreach ($variations as $var) {
          $item_variation = new Item_Variation();
          $item_variation->name = $var['variation'];
          $item_variation->item_id = $item->id;
          if(!$item_variation->save()){
            $this->session->set_flashdata('error', $item_variation->error->transaction);
            redirect('admin/items');
          }
          foreach ($var['values'] as $val) {
            $item_variation_value = new Item_Variation_Value();
            $item_variation_value->item_variation_id = $item_variation->id;
            $item_variation_value->name = $val['value'];
            if(!$item_variation_value->save()){
              $this->session->set_flashdata('error', $item_variation_value->error->transaction);
              redirect('admin/items');
            }
          }
        }
      }

      //SAVE IMAGES
      if($this->input->post('images')){
        $images = $this->input->post('images');

        $imgs = array();
        foreach($images as $img){
          $item_image = new Item_Image();
          $item_image->item_id = $item->id;
          $item_image->image = $img;
          if (!$item_image->save($imgs)) {
            $this->session->flashdata('error', $item_image->error->transaction);
            redirect('admin/items');
          }
        }
      }

      $this->session->set_flashdata('success', 'Salvo com sucesso!');
      redirect('admin/items/edit/'.$item->id);
    }
    $toview['categories'] = "";
    $categories = new Category();
    $categories->order_by('name', 'asc');
    $categories->get();
    foreach($categories as $cat){
      $toview['categories'][] = "<option value='$cat->id' >$cat->name</option>";
    }

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Projetos' => site_url('admin/items'),
      'Criar' => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_style(assets_url('js/plugins/jquery.multiselect/jquery.multiSelect.css'));
    $this->template->set_script(assets_url('js/plugins/jquery.ae.image.resize.min.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.sheepItPlugin-1.0.0.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.filedrop.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.multiselect/jquery.multiSelect.js'));
    $this->template->set_script(assets_url('js/admin/item/create.js'));
    $this->template->load('admin', 'admin/item/create', $toview);

  }

  //Remove Variations that are not included in the $arrVariations array
  //Remove Variation values that are not included in the $arrValues array
  public function removeVariations($item_id, $arrVariations, $arrValues){
    $item = new Item($item_id);

    //Variations Values
    $item_variation_values = new Item_Variation_Value();
    $item_variation_values->where_related('item_variation/item','id', $item);
    if(count($arrValues) > 0){
      $item_variation_values->where_not_in('id', $arrValues);
    }
    $item_variation_values->get();
    if (!$item_variation_values->delete_all()) {
      $this->session->set_flashdata('error', 'Erro ao excluir valor de variação');
      redirect(site_url('admin/items/edit/'.$item_id));
    }

    //Variations
    $item_variations = new Item_Variation();
    $item_variations->where_related('item', 'id', $item);
    if(count($arrVariations) > 0){
      $item_variations->where_not_in('id', $arrVariations);
    }
    $item_variations->get();

    if(!$item_variations->delete_all()){
      $this->session->set_flashdata('error', 'Erro ao excluir variações');
      redirect(site_url('admin/items/edit/'.$item_id));
    }
  }

  public function edit($item_id){
    $item = new Item($item_id);

    if(!$item->exists()){
      $this->session->set_flashdata('error', 'Projeto não encontrado');
      redirect(site_url('admin/items'));
    }

    if($this->input->post()){
      $item->name = $this->input->post('name');
      $item->description = $this->input->post('description');
      $item->height = $this->input->post('height');
      $item->width = $this->input->post('width');
      $item->depth = $this->input->post('depth');
      $item->url = $this->input->post('url');
      $item->style_id = $this->input->post('style_id');

      if ($this->input->post('sub_category')) {
        $item->category_id = $this->input->post('sub_category');
      }else{
        $item->category_id = $this->input->post('category');
      }

      //SAVE VARIATIONS
      if ($this->input->post('item')) {
        $variations_post = $this->input->post('item');

        $variations = $variations_post['variations'];
        $arrVariations = array();
        $arrValues = array();
        foreach ($variations as $var) {
          $item_variation = new Item_Variation($var['variation-id']);
          $item_variation->name = $var['variation'];
          $item_variation->item_id = $item_id;
          if(!$item_variation->save()){
            $this->session->set_flashdata('error', $item_variation->error->transaction);
            redirect(site_url('admin/items'));
          }
          $arrVariations[] = $item_variation->id;
          foreach ($var['values'] as $val) {
            $item_variation_value = new Item_Variation_Value($val['value-id']);
            $item_variation_value->item_variation_id = $item_variation->id;
            $item_variation_value->name = $val['value'];
            if(!$item_variation_value->save()){
              $this->session->set_flashdata('error', $item_variation_value->error->transaction);
              redirect(site_url('admin/items'));
            }
            $arrValues[] = $item_variation_value->id;
          }
        }
      }
      if(!$item->save()){
        $this->session->set_flashdata('error', $item->error->transaction);
        redirect(site_url('admin/items'));
      }

      //Remove variations excluded in the crud
      $this->removeVariations($item->id, $arrVariations, $arrValues);

      //IMAGES
      //Remove old item_images
      $item_images_del = new Item_Image();
      $item_images_del->where('item_id', $item_id)->get();
      if(!$item_images_del->delete_all()){
        $this->session->$this->session->set_flashdata('error', $item_images_del->error->transaction);
        redirect(site_url('admin/items'));
      }
      //SAVE IMAGES
      if($this->input->post('images')){
        $images = $this->input->post('images');

        $imgs = array();
        foreach($images as $img){
          $item_image = new Item_Image();
          $item_image->item_id = $item_id;
          $item_image->image = $img;
          if (!$item_image->save($imgs)) {
            $this->session->flashdata('error', $item_image->error->transaction);
            redirect(site_url('admin/items'));
          }
        }
      }

      $this->session->set_flashdata('success', 'Salvo com sucesso!');
    }

    $toview['item'] = $item;
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Projetos' => site_url('admin/items'),
      'Editar' => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);

    $this->template->set_style(assets_url('js/plugins/jquery.multiselect/jquery.multiSelect.css'));

    $this->template->set_script(assets_url('js/plugins/jquery.ae.image.resize.min.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.sheepItPlugin-1.0.0.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.filedrop.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.multiselect/jquery.multiSelect.js'));
    $this->template->set_script(assets_url('js/admin/item/edit.js'));

    $this->template->load('admin', 'admin/item/edit', $toview);
  }

}

/* End of file items.php */
/* Location: ./application/controllers/admin/items.php */
