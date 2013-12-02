<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suggested_items extends CI_Controller {

  public function index(){
    $suggested_items = new Suggested_Item();
    $suggested_items->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $suggested_items->order_by('create_date', 'desc');
    $toview['suggested_items'] = $suggested_items->get();
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Itens sugeridos' => site_url('admin/suggested_items')
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/suggested_item/index', $toview);
  }

  public function create(){

    if($this->input->post()){
      $suggested_item = new Suggested_Item();
      $suggested_item->name = $this->input->post('name');
      $suggested_item->description = $this->input->post('description');
      $usr = $this->session->userdata('user');
      $suggested_item->user_id = $usr['id'];

      if(!$suggested_item->save()){
        $this->session->set_flashdata('error', $suggested_item->error->transaction);
        redirect('admin/suggested_items/create/');
      }

      //SAVE IMAGES
      if($this->input->post('images')){
        $images = $this->input->post('images');

        foreach($images as $img){
          $suggested_item_image = new Suggested_Item_Image();
          $suggested_item_image->suggested_item_id = $suggested_item->id;
          $suggested_item_image->image = $img;
          if (!$suggested_item_image->save()) {
            $this->session->flashdata('error', $suggested_item_image->error->transaction);
            redirect('admin/suggested_items/create/');
          }
        }
      }

      $this->session->set_flashdata('success', 'Salvo com sucesso.');
      redirect('admin/Suggested_items/edit/'.$suggested_item->id);

    }
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Itens sugeridos' => site_url('admin/suggested_items'),
      'Criar' => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_script(assets_url('js/plugins/jquery.ae.image.resize.min.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.filedrop.js'));
    $this->template->load('admin', 'admin/suggested_item/create');
  }

  public function edit($suggested_item_id){
    $suggested_item = new Suggested_Item($suggested_item_id);
    if(!$suggested_item->exists()){
      $this->session->set_flashdata('error', 'Ítem sugerido não encontrado.');
      redirect('admin/suggested_items');
    }

    if($this->input->post()){
      $suggested_item->name = $this->input->post('name');
      $suggested_item->description = $this->input->post('description');

      if(!$suggested_item->save()){
        $this->session->set_flashdata('error', $suggested_item->error->transaction);
        redirect('admin/suggested_items/edit/'.$suggested_item->id);
      }

      //IMAGES
      //Remove old item_images
      $suggested_item_images_del = new Suggested_Item_Image();
      $suggested_item_images_del->where('suggested_item_id', $suggested_item->id)->get();
      if(!$suggested_item_images_del->delete_all()){
        $this->session->$this->session->set_flashdata('error', $suggested_item_images_del->error->transaction);
        redirect('admin/suggested_items/edit/'.$suggested_item->id);
      }
      //SAVE IMAGES
      if($this->input->post('images')){
        $images = $this->input->post('images');

        foreach($images as $img){
          $suggested_item_image = new Suggested_Item_Image();
          $suggested_item_image->suggested_item_id = $suggested_item->id;
          $suggested_item_image->image = $img;
          if (!$suggested_item_image->save()) {
            $this->session->flashdata('error', $suggested_item_image->error->transaction);
            redirect('admin/suggested_items/edit/'.$suggested_item->id);
          }
        }
      }

      $this->session->set_flashdata('success', 'Salvo com sucesso.');
    }
    $toview['suggested_item'] = $suggested_item;
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Itens sugeridos' => site_url('admin/suggested_items'),
      'Editar' => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_script(assets_url('js/plugins/jquery.ae.image.resize.min.js'));
    $this->template->set_script(assets_url('js/plugins/jquery.filedrop.js'));
    $this->template->load('admin', 'admin/suggested_item/edit', $toview);
  }

}

/* End of file suggested_items.php */
/* Location: ./application/controllers/admin/suggested_items.php */
