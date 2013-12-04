<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Regions extends CI_Controller {

  public function index(){
    $regions = new Region();
    $regions->select("*")->select_func("DATE_FORMAT", array("@create_date", '[,]', '%d/%m/%Y'), 'create_date');
    $regions->order_by('create_date', 'desc');
    $toview['regions'] = $regions->get();
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Regiões' => site_url('admin/regions')
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->load('admin', 'admin/region/index', $toview);
  }

  public function create(){
    if ($this->input->post()) {
      $region = new Region();
      $region->name = $this->input->post('name');
      if(!$region->save()){
        $this->session->set_flashdata('error', $region->error->transaction);
        redirect(site_url('admin/regions/create'));
      }
      if($this->input->post('states')){
        foreach ($this->input->post('states') as $state_id) {
          $region_state = new Region_State();
          $region_state->region_id = $region->id;
          $region_state->state_id = $state_id;
          if(!$region_state->save()){
            $this->session->set_flashdata('error', $region_state->error->transaction);
            redirect(site_url('admin/regions/create'));
          }
        }
      }

      $this->session->set_flashdata('success', 'Salvo com sucesso.');
      redirect(site_url('admin/regions/edit/'.$region->id));
    }

    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Regiões' => site_url('admin/regions'),
      "Criar" => "#"
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_script(assets_url('js/admin/region/create.js'));
    $this->template->load('admin', 'admin/region/create');
  }

  public function edit($region_id){
    $region = new Region($region_id);
    if(!$region->exists()){
      $this->session->set_flashdata('error', 'Região não encontrada.');
      redirect(site_url('admin/regions'));
    }

    if($this->input->post()){
      $region->name = $this->input->post('name');
      if(!$region->save()){
        $this->session->set_flashdata('error', $region->error->transaction);
        redirect(site_url('admin/regions/edit/'.$region->id));
      }

      if($this->input->post('states')){
        foreach ($this->input->post('states') as $state_id) {
          $region_state = new Region_State();
          $region_state->where('region_id', $region->id);
          $region_state->where('state_id', $state_id);
          $region_state->get();

          //Save only if dont exists
          if(!$region_state->exists()){
            $region_state->region_id = $region->id;
            $region_state->state_id = $state_id;
            if(!$region_state->save()){
              $this->session->set_flashdata('error', $region_state->error->transaction);
              redirect(site_url('admin/regions/edit/'.$region->id));
            }
          }

        }
      }
      $this->session->set_flashdata('success', 'Salvo com sucesso');
      redirect(site_url('admin/regions/edit/'.$region->id));
    }

    $toview['region'] = $region;
    $breadcrumb = array(
      'Home' => site_url('admin'),
      'Regiões' => site_url('admin/regions'),
      "Editar" => "#"
      );
    $this->template->set_breadcrumb($breadcrumb);
    $this->template->set_script(assets_url('js/admin/region/edit.js'));
    $this->template->load('admin', 'admin/region/edit', $toview);
  }

  public function delete($state_id, $region_id){
    $region_state = new Region_State();
    $region_state->where('state_id', $state_id);
    $region_state->where('region_id', $region_id);
    $region_state->get();
    if(!$region_state->delete()){
      $this->session->set_flashdata('error', $region_state->error->transaction);
    }
    $this->session->set_flashdata('success', 'Estado removido com sucesso.');
    redirect(site_url('admin/regions/edit/'.$region_id));
  }

}

/* End of file regions.php */
/* Location: ./application/controllers/admin/regions.php */
