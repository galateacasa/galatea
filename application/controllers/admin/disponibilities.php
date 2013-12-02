<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Disponibilities extends CI_Controller {

  public function index(){
    $disponibilities = new Disponibility();
    $disponibilities->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $disponibilities->where('status', 'approved');
    $disponibilities->order_by('create_date', 'desc');

    $toview['disponibilities'] = $disponibilities->get();
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Disponibilidades' => site_url('admin/disponibilities')
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/disponibility/index', $toview);
  }

  function create($item_id){
    $user = $this->session->userdata('user');
    $disponibility = new Disponibility();
    $disponibility->where(array('user_id'=>$user['id'], 'item_id'=>$item_id))->get();
    if(!$disponibility->exists()){
      $item = new Item($item_id);
      if(!$item->exists()){
        $this->session->set_flashdata('error', 'Item não encontrado.');
        redirect('admin/disponibilities');
      }
      //Create disponibility
      $disponibility->user_id = $user['id'];
      $disponibility->item_id = $item->id;
      $disponibility->status = "pending";
      if(!$disponibility->save()){
        $this->session->set_flashdata('error', $disponibility->error->transaction);
        redirect('admin/disponibilities');
      }

      //Create Disponibility variations based on the item variations and variations_values
      foreach($item->item_variation->get() as $item_variation){
        $disponibility_variation = new Disponibility_Variation();
        $disponibility_variation->disponibility_id = $disponibility->id;
        $disponibility_variation->name = $item_variation->name;
        if(!$disponibility_variation->save()){
          $this->session->set_flashdata('error', $disponibility_variation->error->transaction);
          redirect('admin/disponibilities');
        }
        foreach ($item_variation->item_variation_value->get() as $item_variation_value) {
          $disponibility_variation_value = new Disponibility_Variation_Value();
          $disponibility_variation_value->disponibility_variation_id = $disponibility_variation->id;
          $disponibility_variation_value->name = $item_variation_value->name;
          if(!$disponibility_variation_value->save()){
            $this->session->set_flashdata('error', $disponibility_variation_value->error->transaction);
            redirect('admin/disponibilities');
          }
        }
      }

      //END Disponibility Creation
      $this->session->set_flashdata('success', 'Disponibilidade criada com sucesso!');
      redirect('admin/disponibilities/edit/'.$disponibility->id);
    }else{
      //Disponibility already exists, redirect to edit page
      redirect('admin/disponibilities/edit/'.$disponibility->id);
    }
  }

  //Remove Variations that are not included in the $arrVariations array
  //Remove Variation values that are not included in the $arrValues array
  public function removeVariations($disponibility_id, $arrVariations, $arrValues){
    $disponibility = new Disponibility($disponibility_id);

    //Variations Values
    $disponibility_variation_values = new Disponibility_Variation_Value();
    $disponibility_variation_values->where_related('disponibility_variation/disponibility','id', $disponibility);
    if(count($arrValues) > 0){
      $disponibility_variation_values->where_not_in('id', $arrValues);
    }
    $disponibility_variation_values->get();
    if (!$disponibility_variation_values->delete_all()) {
      $this->session->set_flashdata('error', 'Erro ao excluir valor de variação');
      redirect(site_url('admin/disponibilities/edit/'.$disponibility_id));
    }

    //Variations
    $disponibility_variations = new Disponibility_Variation();
    $disponibility_variations->where_related('disponibility', 'id', $disponibility);
    if(count($arrVariations) > 0){
      $disponibility_variations->where_not_in('id', $arrVariations);
    }
    $disponibility_variations->get();

    if(!$disponibility_variations->delete_all()){
      $this->session->set_flashdata('error', 'Erro ao excluir variações');
      redirect(site_url('admin/disponibilities/edit/'.$disponibility_id));
    }
  }

  public function edit($disponibility_id){
    $disponibility = new Disponibility($disponibility_id);
    if(!$disponibility->exists()){
      $this->session->set_flashdata('error', 'Disponibilidade não encontrada.');
      redirect('admin/disponibilities');
    }

    if($this->input->post()){
      $production_price = $this->input->post('production_price');
      $production_price = str_replace(".", "", $production_price);
      $production_price = str_replace(",", ".", $production_price);
      $disponibility->production_price = $production_price;
      $disponibility->weekly_production = $this->input->post('weekly_production');

      //SAVE VARIATIONS
      $arrVariations = array();
      $arrValues = array();
      if ($this->input->post('disponibility')) {
        $variations_post = $this->input->post('disponibility');
        $variations = $variations_post['variations'];
        foreach ($variations as $var) {
          $disponibility_variation = new Disponibility_Variation($var['variation-id']);
          $disponibility_variation->name = $var['variation'];
          $disponibility_variation->produce = (isset($var['no-produce'])?false:true);
          $disponibility_variation->disponibility_id = $disponibility_id;
          if(!$disponibility_variation->save()){
            $this->session->set_flashdata('error', $disponibility_variation->error->transaction);
            redirect('site/disponibilities');
          }
          $arrVariations[] = $disponibility_variation->id;
          foreach ($var['values'] as $val) {

            $disponibility_variation_value = new Disponibility_Variation_Value($val['value-id']);
            $disponibility_variation_value->disponibility_variation_id = $disponibility_variation->id;
            $disponibility_variation_value->name = $val['value'];
            $disponibility_variation_value->produce = (isset($val['no-produce'])?false:true);

            $value_variation = $val['value_variation'];
            $value_variation = str_replace(".", "", $value_variation);
            $value_variation = str_replace(",", ".", $value_variation);
            if ($val['value_type'] == "percent") {
              $disponibility_variation_value->variation_price_percent = $value_variation;
            }elseif ($val['value_type'] == "money") {
              $disponibility_variation_value->variation_price_value = $value_variation;
            }
            if(!$disponibility_variation_value->save()){
              $this->session->set_flashdata('error', $disponibility_variation_value->error->transaction);
              redirect('site/disponibilities');
            }
            $arrValues[] = $disponibility_variation_value->id;
          }
        }
      }

      if(!$disponibility->save()){
        $this->session->set_flashdata('error', $disponibility->error->transaction);
        redirect('site/disponibilities');
      }

      //Remove variations excluded in the crud
      $this->removeVariations($disponibility->id, $arrVariations, $arrValues);

      $this->session->set_flashdata('success', 'Salvo com sucesso!');
    }

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Disponibilidades' => site_url('admin/disponibilities'),
      'Editar' => '#'
      );
    $toview['disponibility'] = $disponibility;
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_script(assets_url('js/plugins/jquery.sheepItPlugin-1.0.0.js'));
    $this->template->set_script(assets_url('js/admin/disponibility/edit.js'));
    $this->template->load('admin', 'admin/disponibility/edit', $toview);
  }

}

/* End of file disponibilities.php */
/* Location: ./application/controllers/admin/disponibilities.php */
