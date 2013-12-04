<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Disponibility_price_variations extends CI_Controller {

  public function index(){
    $this->output->enable_profiler(TRUE);
    $disponibility_variation_values = new Disponibility_Variation_Value();
    $disponibility_variation_values->order_by('create_date', 'desc');
    $disponibility_variation_values->include_related('disponibility_variation/disponibility/item', array('name'));
    $disponibility_variation_values->include_related('disponibility_variation', array('name'));

    $toview['disponibility_variation_values'] = $disponibility_variation_values->get();
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Variaçoes de preço das disponibilidades' => site_url('admin/disponibility_price_variations')
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/disponibility_price_variation/index', $toview);
  }

  public function delete($disponibility_price_variation_id, $disponibility_variation_value_id){
    $disponibility_price_variation = new Disponibility_Price_Variation($disponibility_price_variation_id);
    if(!$disponibility_price_variation->delete()){
      $this->session->set_flashdata('error', $disponibility_price_variation->error->transaction);
    }
    redirect(site_url('admin/disponibility_price_variations/edit/'.$disponibility_variation_value_id));
  }

  public function edit($disponibility_variation_value_id){
    $this->output->enable_profiler(TRUE);

    $disponibility_variation_value = new Disponibility_Variation_Value();
    $disponibility_variation_value->id = $disponibility_variation_value_id;
    $disponibility_variation_value->include_related('disponibility_variation', array('name'));
    $disponibility_variation_value->include_related('disponibility_variation/disponibility/item', array('name'));
    $disponibility_variation_value->get();
    if(!$disponibility_variation_value->exists()){
      $this->session->set_flashdata('error', 'Valor de variação não encontrado.');
      redirect(site_url('admin/disponibility_price_variations'));
    }

    if($this->input->post()){
      $disponibility_price_variation = new Disponibility_Price_Variation();

      //IF price variations exists it will be updated
      $disponibility_price_variation->where("disponibility_variation_value_id", $this->input->post('disponibility_variation_value_id'));
      $disponibility_price_variation->where("state_id", $this->input->post('state'));
      $disponibility_price_variation->where("city_id", $this->input->post('city'));
      $disponibility_price_variation->get();

      $disponibility_price_variation->disponibility_variation_value_id = $this->input->post('disponibility_variation_value_id');
      $disponibility_price_variation->state_id = $this->input->post('state');
      $disponibility_price_variation->city_id = $this->input->post('city');
      $variation_price = $this->input->post('price');
      $variation_price = str_replace(".", "", $variation_price);
      $variation_price = str_replace(",", ".", $variation_price);
      $disponibility_price_variation->price = $variation_price;
      if(!$disponibility_price_variation->save()){
        $this->session->set_flashdata('error', $disponibility_price_variation->error->transaction);
        redirect(site_url('admin/disponibility_price_variations/edit/'.$disponibility_variation_value->id));
      }

      $this->session->set_flashdata('success', 'Salvo com sucesso');
      redirect(site_url('admin/disponibility_price_variations/edit/'.$disponibility_variation_value->id));
    }


    $disponibility_price_variations = new Disponibility_Price_Variation();
    $disponibility_price_variations->where("disponibility_variation_value_id", $disponibility_variation_value->id);
    $disponibility_price_variations->include_related('state', array('name'));
    $disponibility_price_variations->include_related('city', array('name'));
    $disponibility_price_variations->get();
    $toview['disponibility_price_variations'] = $disponibility_price_variations;
    $toview['disponibility_variation_value'] = $disponibility_variation_value;
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Variaçoes de preço das disponibilidades' => site_url('admin/disponibility_price_variations'),
      'Editar' => '#'
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_script(assets_url('js/plugins/jquery.sheepItPlugin-1.0.0.js'));
    $this->template->set_script(assets_url('js/admin/disponibility_price_variation/edit.js'));
    $this->template->load('admin', 'admin/disponibility_price_variation/edit', $toview);
  }

}

/* End of file disponibility_price_variation.php */
/* Location: ./application/controllers/admin/disponibility_price_variation.php */
